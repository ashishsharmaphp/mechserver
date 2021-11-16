<?php

class RequestMasterController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * =======================================API Calls==================================
     */

    /**
     * When User requests a service
     * Used to send the notification to nearby mechanic
     * 
     * Array
      (
      [RequestMaster] => Array
      (
      [user_id] => 1
      [service_id] => 2
      [lats] => 19.173465
      [longs] => 72.835795
      [vehical_type] => 1
      [make] => 1
      [model] => 1
      [fuel] => 1
      )
      )
     */
    public function actionrequestService() {

        if (isset($_REQUEST['RequestMaster'])) {

            $user_id = $_REQUEST['RequestMaster']['user_id'];
            $service_id = $_REQUEST['RequestMaster']['service_id'];
            $lat = $_REQUEST['RequestMaster']['lats'];
            $long = $_REQUEST['RequestMaster']['longs'];

            //Get the user details
            $userDet = UserMaster::model()->findByPk($user_id);
            if ($userDet->is_busy == 1) {
                $data['response'] = 'You are on-service currently. Can not raise more requests!!';
                echo json_encode($data);
                die;
            }

            //Step 1 -- Check if mechanics are present and get nearest
            $result = CommonFunctions::getNearbyMechanics($lat, $long, $service_id, false);

            //Step 2 -- Get the requested service location details
            $locationdet = CommonFunctions::getLocationDetail($lat, $long);

            if (count($result) == 0) {

                $data['response'] = 'No Records!!';
            } else {

                //Step 2 -- If mechanics are present then raise a service request
                $request['data'] = $_REQUEST['RequestMaster'];
                $request['data']['location_detail'] = $locationdet;
                $request['data']['status'] = 1;
                $request['data']['user_type'] = 'U';
                $request['data']['related_req_id'] = 0;

                $request_id = $this->submitRequest($request);

                //Save the vehical details
                $vehicalType = $_REQUEST['RequestMaster']['vehical_type'];
                $make = $_REQUEST['RequestMaster']['make'];
                $model = $_REQUEST['RequestMaster']['model'];
                $fuel = $_REQUEST['RequestMaster']['fuel'];

                $sq = "INSERT INTO `request_vehical_details` (`id`, `request_id`, `vehical_type`, `make`, `model`, `fuel`, `added_on`) VALUES (NULL, '$request_id', '$vehicalType', '$make', '$model', '$fuel', CURRENT_TIMESTAMP)";
                 Yii::app()->db->createCommand($sq)->execute();

                //Step 3 -- Get the requested service details
                $serviceDet = ServicesMaster::model()->findByPk($service_id);
                $serviceType = $serviceDet->service_description;

                //Get the vehical details
                $vehicalDetails = CommonFunctions::getRequestVehicalDetails($request_id);

                //Step 6 -- Create the msg body
                $body = array(
                    'alert' => "New Service Requested!!",
                    'service_type' => $serviceType,
                    'service_id' => $service_id,
                    'location' => $locationdet,
                    'request_id' => $request_id,
                    'user_id' => $user_id,
                    'user_name' => $userDet->name,
                    'contact' => $userDet->mobile,
                    'lat' => $lat,
                    'long' => $long,
                    'sound' => 'default',
                    'badge' => 1,
                    'content-available' => '1',
                    'user_type' => 'U',
                    'vehical_details' => array(
                        'vehical_type' => Yii::app()->params['vehical_type'][$vehicalDetails['vehical_type']],
                        'fuel' => Yii::app()->params['fuel'][$vehicalDetails['fuel']],
                        'make' => $vehicalDetails['make'],
                        'model' => $vehicalDetails['model'],
                    )
                );

                //Step 7 -- Send the push notification to mechanic
                if ($result[0]['os'] == 'ios') {
                    $data['response'] = CommonFunctions::sendIphonePush($body, $result[0]['device_token']);
                } else {
                    $data['response'] = CommonFunctions::sendAndroidPush($body, $result[0]['device_token']);
                }
            }

            echo json_encode($data);
        }
    }

    /**
     * When mechanic accepts a request
     * Used to notify to user that request accepted by mechanic
     * 
     * Array
      (
      [RequestMaster] => Array
      (
      [req_id] => 1
      [mech_id] => 2
      [service_id] => 2
      [lats] => 19.173465
      [longs] => 72.835795
      )
      )
     */
    public function actionreplyServiceRequestAccept() {

        if (isset($_REQUEST['RequestMaster'])) {

            $req_id = $_REQUEST['RequestMaster']['req_id'];
            $mech_id = $_REQUEST['RequestMaster']['mech_id'];
            $service_id = $_REQUEST['RequestMaster']['service_id'];
            $lat = $_REQUEST['RequestMaster']['lats'];
            $long = $_REQUEST['RequestMaster']['longs'];

            //Step 2 -- Get the mechanic details
            $mechDet = (object) CommonFunctions::getMechanicInfo($mech_id);

            if ($mechDet->is_busy == 1) {
                $data['response'] = 'You are on-service currently. Can not accept more requests!!';
                echo json_encode($data);
                die;
            }

            $userDet = (object) CommonFunctions::getRequestRaiserDetails($req_id);

            //Step 1 -- Get the location details
            $locationdet = CommonFunctions::getLocationDetail($lat, $long);

            //Step 2 -- Reply request status as accepted by this mechanic
            $request['data'] = array(
                'user_id' => $mech_id,
                'service_id' => $service_id,
                'lats' => $lat,
                'longs' => $long,
            );
            $request['data']['location_detail'] = $locationdet;
            $request['data']['status'] = 2;
            $request['data']['user_type'] = 'M';
            $request['data']['related_req_id'] = $req_id;

            $this->submitRequest($request);

            //Step 4 -- Get the requested service details
            $serviceDet = ServicesMaster::model()->findByPk($service_id);

            //Step 6 -- Create the msg body
            $body = array(
                'alert' => "Your Service Accepted!!",
                'service_type' => $serviceDet->service_description,
                'service_id' => $service_id,
                'location' => $locationdet,
                'request_id' => $req_id,
                'mech_id' => $mechDet->id,
                'mech_name' => $mechDet->name,
                'mech_contact' => $mechDet->mobile,
                'lat' => $lat,
                'long' => $long,
                'sound' => 'default',
                'badge' => 1,
                'content-available' => '1',
                'user_type' => 'M',
            );

            //Step 7 -- Send the push notification to user as Service Accepted!!
            if ($userDet->os == 'ios') {
                CommonFunctions::sendIphonePush($body, $userDet->device_token);
            } else {
                CommonFunctions::sendAndroidPush($body, $userDet->device_token);
            }

            //Step 8 -- Update the mechanic and user as busy
            MechMaster::model()->updateByPk($mech_id, array('is_busy' => 1));
            UserMaster::model()->updateByPk($userDet->id, array('is_busy' => 1));

            $data['response'] = 'Service Accepted!!';

            echo json_encode($data);
        }
    }

    /**
     * If user rejects a service
     * Used to notify mechnic that service rejected by user
     * 
     * Array
      (
      [RequestMaster] => Array
      (
      [req_id] => 1
      [user_id] => 1
      [service_id] => 2
      [lats] => 19.173465
      [longs] => 72.835795
      [comments] => Very high price!!
      )
      )
     */
    public function actionreplyUserServiceReject() {

        if (isset($_REQUEST['RequestMaster'])) {

            $req_id = $_REQUEST['RequestMaster']['req_id'];
            $user_id = $_REQUEST['RequestMaster']['user_id'];
            $service_id = $_REQUEST['RequestMaster']['service_id'];
            $lat = $_REQUEST['RequestMaster']['lats'];
            $long = $_REQUEST['RequestMaster']['longs'];

            $userDet = UserMaster::model()->findByPk($user_id);
            $mechDet = CommonFunctions::getMechanicAssignedtoRequest($req_id);

            //Step 1 -- Get the location details
            $locationdet = CommonFunctions::getLocationDetail($lat, $long);

            //Step 2 -- Reply request status as accepted by this mechanic
            $request['data'] = array(
                'user_id' => $user_id,
                'service_id' => $service_id,
                'lats' => $lat,
                'longs' => $long,
                'location_detail' => $locationdet,
                'status' => 8,
                'user_type' => 'U',
                'related_req_id' => $req_id,
                'comments' => $_REQUEST['RequestMaster']['comments']
            );

            $this->submitRequest($request);

            //Step 4 -- Get the requested service details
            $serviceDet = ServicesMaster::model()->findByPk($service_id);

            //Step 6 -- Create the msg body
            $body = array(
                'alert' => "User Service Rejected!!",
                'service_type' => $serviceDet->service_description,
                'service_id' => $service_id,
                'location' => $locationdet,
                'request_id' => $req_id,
                'user_name' => $userDet->name,
                'user_contact' => $userDet->mobile,
                'comments' => $_REQUEST['RequestMaster']['comments'],
                'lat' => $lat,
                'long' => $long,
                'sound' => 'default',
                'badge' => 1,
                'content-available' => '1',
                'user_type' => 'U',
            );

            //Step 7 -- Send the push notification to user as Service Accepted!!
            if ($mechDet['os'] == 'ios') {
                CommonFunctions::sendIphonePush($body, $mechDet['device_token']);
            } else {
                CommonFunctions::sendAndroidPush($body, $mechDet['device_token']);
            }

            //Step 8 -- Update the mechanic and user as FREE
            MechMaster::model()->updateByPk($mechDet['id'], array('is_busy' => 0));
            UserMaster::model()->updateByPk($userDet->id, array('is_busy' => 0));

            $data['response'] = 'Service Rejected!!';

            echo json_encode($data);
        }
    }

    /**
     * When mechanic reach discuss about job and service charge and starts service
     * Used to notify the user about service started
     * 
     * Array
      (
      [RequestMaster] => Array
      (
      [req_id] => 1
      [mech_id] => 2
      [service_id] => 2
      [lats] => 19.173465
      [longs] => 72.835795
      )
      )
     */
    public function actionreplyServiceStart() {

        if (isset($_REQUEST['RequestMaster'])) {

            $req_id = $_REQUEST['RequestMaster']['req_id'];
            $mech_id = $_REQUEST['RequestMaster']['mech_id'];
            $service_id = $_REQUEST['RequestMaster']['service_id'];
            $lat = $_REQUEST['RequestMaster']['lats'];
            $long = $_REQUEST['RequestMaster']['longs'];

            //Step 1 -- Get the location details
            $locationdet = CommonFunctions::getLocationDetail($lat, $long);

            //Step 2 -- Reply request status as started by this mechanic
            $request['data'] = array(
                'user_id' => $mech_id,
                'service_id' => $service_id,
                'lats' => $lat,
                'longs' => $long,
                'location_detail' => $locationdet,
                'status' => 3,
                'user_type' => 'M',
                'related_req_id' => $req_id,
            );

            $this->submitRequest($request);

            //Step 3 -- Get the mechanic details
            $mechDet = (object) CommonFunctions::getMechanicInfo($mech_id);

            //Step 4 -- Get the request raiser's details
            $userDet = (object) CommonFunctions::getRequestRaiserDetails($req_id);

            //Step 5 -- Get the requested service details
            $serviceDet = ServicesMaster::model()->findByPk($service_id);

            //Step 6 -- Create the msg body
            $body = array(
                'alert' => "Your Service Started!!",
                'service_type' => $serviceDet->service_description,
                'service_id' => $service_id,
                'location' => $locationdet,
                'request_id' => $req_id,
                'mech_id' => $mechDet->id,
                'mech_name' => $mechDet->name,
                'mech_contact' => $mechDet->mobile,
                'lat' => $lat,
                'long' => $long,
                'sound' => 'default',
                'badge' => 1,
                'content-available' => '1',
                'user_type' => 'M',
            );

            //Step 7 -- Send the push notification to user as Service Started!!
            if ($userDet->os == 'ios') {
                CommonFunctions::sendIphonePush($body, $userDet->device_token);
            } else {
                CommonFunctions::sendAndroidPush($body, $userDet->device_token);
            }


            $data['response'] = 'Service Started!!';

            echo json_encode($data);
        }
    }

    /**
     * When Mechanic Completes a service
     * Used to notify to a user about this and to do the payment
     * 
     * Array
      (
      [RequestMaster] => Array
      (
      [req_id] => 1
      [mech_id] => 2
      [service_id] => 2
      [service_charge] => 200
      [lats] => 19.173465
      [longs] => 72.835795
      )
      )
     */
    public function actionreplyServiceCompleted() {

        if (isset($_REQUEST['RequestMaster'])) {

            $req_id = $_REQUEST['RequestMaster']['req_id'];
            $mech_id = $_REQUEST['RequestMaster']['mech_id'];
            $service_id = $_REQUEST['RequestMaster']['service_id'];
            $service_charge = $_REQUEST['RequestMaster']['service_charge'];
            $lat = $_REQUEST['RequestMaster']['lats'];
            $long = $_REQUEST['RequestMaster']['longs'];

            //Unique transaction Id
            $trId = CommonFunctions::generateRandomString();

            //Step 1 -- Get the location details
            $locationdet = CommonFunctions::getLocationDetail($lat, $long);

            //Step 2 -- Reply request status as completed by this mechanic
            $request['data'] = array(
                'user_id' => $mech_id,
                'service_id' => $service_id,
                'lats' => $lat,
                'longs' => $long,
                'location_detail' => $locationdet,
                'status' => 4,
                'user_type' => 'M',
                'related_req_id' => $req_id,
                'comments' => "transaction_id : $trId"
            );

            $this->submitRequest($request);

            //Step 2 -- Get the mechanic details
            $mechDet = (object) CommonFunctions::getMechanicInfo($mech_id);

            //Step 3 -- Get the request raiser's details
            $userDet = (object) CommonFunctions::getRequestRaiserDetails($req_id);

            //Step 4 -- Get the requested service details
            $serviceDet = ServicesMaster::model()->findByPk($service_id);

            //Get the vehical details
            $vehicalDetails = CommonFunctions::getRequestVehicalDetails($req_id);

            //Step 6 -- Create the msg body
            $body = array(
                'alert' => "Your Service has been completed!! Please do the said payment!!",
                'service_type' => $serviceDet->service_description,
                'service_id' => $service_id,
                'service_charge' => $service_charge,
                'location' => $locationdet,
                'request_id' => $req_id,
                'mech_id' => $mech_id,
                'mech_name' => $mechDet->name,
                'mech_contact' => $mechDet->mobile,
                'transaction_id' => $trId,
                'lat' => $lat,
                'long' => $long,
                'sound' => 'default',
                'badge' => 1,
                'content-available' => '1',
                'user_type' => 'M',
                'vehical_details' => array(
                    'vehical_type' => Yii::app()->params['vehical_type'][$vehicalDetails['vehical_type']],
                    'fuel' => Yii::app()->params['fuel'][$vehicalDetails['fuel']],
                    'make' => $vehicalDetails['make'],
                    'model' => $vehicalDetails['model'],
                )
            );

            //Step 7 -- Send the push notification to user as Service Completed!!
            if ($userDet->os == 'ios') {
                CommonFunctions::sendIphonePush($body, $userDet->device_token);
            } else {
                CommonFunctions::sendAndroidPush($body, $userDet->device_token);
            }

            $data['response'] = 'Service Completed!!';

            //Now generate a unique transaction id for this service and store
            $trModel = new TransactionMaster;
            $transaction = array(
                'request_id' => $req_id,
                'user_id' => $userDet->id,
                'mech_id' => $mechDet->id,
                'service_id' => $service_id,
                'service_charge' => $service_charge,
                'status' => '1',
                'paid_by' => '',
                'transaction_id' => $trId,
                'return_transaction_id' => '',
            );
            $trModel->attributes = $transaction;

            if (!$trModel->save()) {
                echo '<pre>';
                print_r($trModel->getErrors());
                die;
            }

            echo json_encode($data);
        }
    }

    /**
     * When User does a payment
     * Used to notify to a mechanic that payment done. and save transaction
     * 
     * Array
      (
      [RequestMaster] => Array
      (
      [req_id] => 1
      [user_id] => 2
      [service_id] => 2
      [service_charge] => 200
      [paid_by] => credit_debit_card/net_banking/voucher/paytm/cash
      [tr_id] => safsdfwe535dgfdgf
      [return_tr_id] => safsdfwe535dgfdgf342342
      [lats] => 19.173465
      [longs] => 72.835795
      )
      )
     */
    public function actionreplyServicePaymentDone() {

        if (isset($_REQUEST['RequestMaster'])) {

            $req_id = $_REQUEST['RequestMaster']['req_id'];
            $user_id = $_REQUEST['RequestMaster']['user_id'];
            $service_id = $_REQUEST['RequestMaster']['service_id'];
            $service_charge = $_REQUEST['RequestMaster']['service_charge'];
            $paid_by = $_REQUEST['RequestMaster']['paid_by'];
            $tr_id = $_REQUEST['RequestMaster']['tr_id'];
            $return_tr_id = $_REQUEST['RequestMaster']['return_tr_id'];
            $lat = $_REQUEST['RequestMaster']['lats'];
            $long = $_REQUEST['RequestMaster']['longs'];

            $userDet = UserMaster::model()->findByPk($user_id);
            $mechDet = CommonFunctions::getMechanicAssignedtoRequest($req_id);

            //Step 1 -- Get the location details
            $locationdet = CommonFunctions::getLocationDetail($lat, $long);

            //Step 2 -- Reply request status as accepted by this mechanic
            $request['data'] = array(
                'user_id' => $user_id,
                'service_id' => $service_id,
                'lats' => $lat,
                'longs' => $long,
                'location_detail' => $locationdet,
                'status' => 7,
                'user_type' => 'U',
                'related_req_id' => $req_id,
                'comments' => "transaction_id : $tr_id"
            );

            $this->submitRequest($request);

            //Step 4 -- Get the requested service details
            $serviceDet = ServicesMaster::model()->findByPk($service_id);

            //Get the vehical details
            $vehicalDetails = CommonFunctions::getRequestVehicalDetails($req_id);

            //Step 6 -- Create the msg body
            $body = array(
                'alert' => "Payment Recieved!!",
                'service_type' => $serviceDet->service_description,
                'service_id' => $service_id,
                'location' => $locationdet,
                'request_id' => $req_id,
                'user_name' => $userDet->name,
                'user_contact' => $userDet->mobile,
                'comments' => $_REQUEST['RequestMaster']['comments'],
                'lat' => $lat,
                'long' => $long,
                'sound' => 'default',
                'badge' => 1,
                'content-available' => '1',
                'user_type' => 'U',
                'vehical_details' => array(
                    'vehical_type' => Yii::app()->params['vehical_type'][$vehicalDetails['vehical_type']],
                    'fuel' => Yii::app()->params['fuel'][$vehicalDetails['fuel']],
                    'make' => $vehicalDetails['make'],
                    'model' => $vehicalDetails['model'],
                )
            );

            //Step 7 -- Send the push notification to mechanic to start
            if ($mechDet['os'] == 'ios') {
                CommonFunctions::sendIphonePush($body, $mechDet['device_token']);
            } else {
                CommonFunctions::sendAndroidPush($body, $mechDet['device_token']);
            }

            $data['response'] = 'Payment Recieved!!';

            //Now generate a unique transaction id for this service and store
            $trModel = new TransactionMaster;
            $transaction = array(
                'request_id' => $req_id,
                'user_id' => $user_id,
                'mech_id' => $mechDet['id'],
                'service_id' => $service_id,
                'service_charge' => $service_charge,
                'status' => '2',
                'paid_by' => $paid_by,
                'transaction_id' => $tr_id,
                'return_transaction_id' => $return_tr_id,
            );
            $trModel->attributes = $transaction;

            if (!$trModel->save()) {
                echo '<pre>';
                print_r($trModel->getErrors());
                die;
            }


            //Step 8 -- Update the mechanic and user as FREE
            MechMaster::model()->updateByPk($mechDet['id'], array('is_busy' => 0));
            UserMaster::model()->updateByPk($userDet->id, array('is_busy' => 0));

            echo json_encode($data);
        }
    }

    /**
     * Used to reply to a raised service request as busy and find other nearby mechanic
     * 
     * Array
      (
      [RequestMaster] => Array
      (
      [req_id] => 1
      [mech_id] => 2
      [service_id] => 2
      [lats] => 19.173465
      [longs] => 72.835795
      )
      )
     */
    public function actionreplyServiceRequestBusy() {

        if (isset($_REQUEST['RequestMaster'])) {

            $req_id = $_REQUEST['RequestMaster']['req_id'];
            $mech_id = $_REQUEST['RequestMaster']['mech_id'];
            $service_id = $_REQUEST['RequestMaster']['service_id'];
            $lat = $_REQUEST['RequestMaster']['lats'];
            $long = $_REQUEST['RequestMaster']['longs'];

            //Step 1 -- Update mechanic as busy
            MechMaster::model()->updateByPk($mech_id, array('is_busy' => 1));

            //Step 2 -- Reply request status as busy by this mechanic
            $request['data'] = array(
                'user_id' => $mech_id,
                'service_id' => $service_id,
                'lats' => $lat,
                'longs' => $long,
                'status' => 6,
                'user_type' => 'M',
                'related_req_id' => $req_id,
            );

            $this->submitRequest($request);

            //Step 3 -- Check if other mechanics are present and get nearest
            $result = CommonFunctions::getNearbyMechanics($lat, $long, $service_id, false);

            if (count($result) == 0) {

                //Step 4 -- Reply request status as NoMechFound
                $request['data'] = array(
                    'user_id' => 0,
                    'service_id' => $service_id,
                    'lats' => '',
                    'longs' => '',
                    'status' => 7,
                    'user_type' => '',
                    'related_req_id' => $req_id,
                );

                $this->submitRequest($request);

                //Step 5 -- Get the request raiser's details
                $userDet = (object) CommonFunctions::getRequestRaiserDetails($req_id);

                //Step 6 -- Create the msg body
                $body = array(
                    'alert' => "Our all the mechanics are busy right now. We are sorry for inconvenience!!",
                    'lat' => $lat,
                    'long' => $long,
                    'sound' => 'default',
                    'badge' => 1,
                    'content-available' => '1',
                    'user_type' => 'M',
                );

                //Step 7 -- Send the push notification to user as no mechanics
                if ($userDet->os == 'ios') {
                    CommonFunctions::sendIphonePush($body, $userDet->device_token);
                } else {
                    CommonFunctions::sendIphonePush($body, $userDet->device_token);
                }


                $data['response'] = 'No Mechanics Found!!';
            } else {

                //Step 4 -- Get the other mechanic's device token
                $deviceTkn = $result[0]['device_token'];

                //Step 5 -- Get the requested service details
                $serviceDet = ServicesMaster::model()->findByPk($service_id);
                $serviceType = $serviceDet->service_description;

                //Step 6 -- Get the request raiser's details
                $userDet = (object) CommonFunctions::getRequestRaiserDetails($req_id);

                //Step 7 -- Get the requested service location details
                $locDet = RequestMaster::model()->findByPk($req_id);
                $locationdet = CommonFunctions::getLocationDetail($locDet->lats, $locDet->longs);

                //Get the vehical details
                $vehicalDetails = CommonFunctions::getRequestVehicalDetails($req_id);

                //Step 8 -- Create the msg body
                $body = array(
                    'alert' => "New Service Requested!!",
                    'service_type' => $serviceType,
                    'service_id' => $service_id,
                    'location' => $locationdet,
                    'request_id' => $req_id,
                    'user_id' => $userDet->id,
                    'user_name' => $userDet->name,
                    'contact' => $userDet->mobile,
                    'lat' => $lat,
                    'long' => $long,
                    'sound' => 'default',
                    'badge' => 1,
                    'content-available' => '1',
                    'user_type' => 'U',
                    'vehical_details' => array(
                        'vehical_type' => Yii::app()->params['vehical_type'][$vehicalDetails['vehical_type']],
                        'fuel' => Yii::app()->params['fuel'][$vehicalDetails['fuel']],
                        'make' => $vehicalDetails['make'],
                        'model' => $vehicalDetails['model'],
                    )
                );

                //Step 9 -- Send the push notification to mechanic
                if ($result[0]['os'] == 'ios') {
                    CommonFunctions::sendIphonePush($body, $deviceTkn);
                } else {
                    CommonFunctions::sendAndroidPush($body, $deviceTkn);
                }

                $data['response'] = "Notification Sent To Other Mechanic!!";
            }

            echo json_encode($data);
        }
    }

    /**
     * Used to submit the ratings of service
     * 
     * Array
      (
      [RequestMaster] => Array
      (
      [user_id] => 1
      [mech_id] => 2
      [request_id] => 2
      [rating] => 2
      [comments] => ok ok
      )
      )
     */
    public function actionsubmitRatings() {

        $data = array();

        if (isset($_REQUEST['RequestMaster'])) {

            $model = new MechRatings;
            $model->attributes = $_REQUEST['RequestMaster'];

            if ($model->save()) {
                $data['response'] = 'Ratings Submitted Successfully';
            } else {
                $data['response'] = $model->getErrors();
            }
        }

        echo json_encode($data);
    }

    public function submitRequest($request) {

        if (count($request) > 0) {

            $model = new RequestMaster;
            $model->attributes = $request['data'];

            if ($model->save()) {

                if ($request['data']['related_req_id'] == 0) {
                    RequestMaster::model()->updateByPk($model->id, array('related_req_id' => $model->id));
                }
                return $model->id;
            } else {

                echo '<pre>';
                print_r($model->getErrors());
                die;
            }
        }
    }

    /**
     * Used to get the request history of a user
     * 
     * Array
      (
      [RequestMaster] => Array
      (
      [user_id] => 1
      )
      )
     */
    public function actiongetHistory() {

        $response = array();

        if (isset($_REQUEST['RequestMaster'])) {
            $userId = $_REQUEST['RequestMaster']['user_id'];

            $sql = "select sm.service_code, rm.location_detail, rm.tracked_on, rm.status
                    from services_master sm, request_master rm
                    where 
                        sm.id = rm.service_id
                    and	rm.user_id = $userId group by rm.related_req_id order by rm.tracked_on desc;";
            
            $result = Yii::app()->db->createCommand($sql)->queryAll();
            
            if (count($result) > 0) {

                $response['response'] = $result;
            } else {
                $response['response'] = 'No Records Found!!';
            }
        }
        
        echo json_encode($response);
    }

    /**
     * Used to get the detail request history of a user
     * 
     * Array
      (
      [RequestMaster] => Array
      (
      [request_id] => 1
      )
      )
     */
    public function actiongetDetailHistory() {

        $response = array();

        if (isset($_REQUEST['RequestMaster'])) {
            $request_id = $_REQUEST['RequestMaster']['request_id'];

            // Request Details
            $sql = "select sm.service_code, sm.service_description, sm.vehical_type, rm.location_detail, rm.tracked_on, rm.status
                    from services_master sm, request_master rm
                    where sm.id = rm.service_id
                    and	rm.id = $request_id;";
            
            $resultRequest = Yii::app()->db->createCommand($sql)->queryRow();

            // Mechanic and payment details
            $sql1 = "select mm.name, mm.mobile, tm.service_charge, tm.status, tm.paid_by, tm.transaction_id, tm.tracked_on
                    from mech_master mm, transaction_master tm
                    where 
                    tm.mech_id = mm.id
                    and tm.request_id = $request_id order by tracked_on DESC limit 1;";
            
            $resultPay = Yii::app()->db->createCommand($sql1)->queryRow();
            
            if (count($resultRequest) > 0) {

                $response['response']['request_details'] = $resultRequest;
                $response['response']['payment_details'] = $resultPay;
            } else {
                $response['response'] = 'No Records Found!!';
            }
        }
        
        echo json_encode($response);
    }

}
