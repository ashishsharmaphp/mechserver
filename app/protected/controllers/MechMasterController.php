<?php

class MechMasterController extends Controller {

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
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'register', 'updateLocation', 'getMechInfo', 'regenerateOTP', 'validateOTP', 'getNearBy', 'updateInfo', 'changePwd'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new MechMaster;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_FILES['dp']) && $_FILES['dp']['error'] == 0) {
            $fileName = $this->uploadDoc($_FILES['dp']);
        } else {
            $fileName['file'] = "";
        }

        if (isset($_POST['MechMaster'])) {
            $model->attributes = $_POST['MechMaster'];
            $model->dp = trim($fileName['file'], ',');

            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $fileName = "a";

        if (isset($_FILES['dp']) && $_FILES['dp']['error'] == 0) {
            $fileName = $this->uploadDoc($_FILES['dp']);
        }

        if (isset($_POST['MechMaster'])) {
            $model->attributes = $_POST['MechMaster'];

            if ($fileName != "a") {
                $model->dp = trim($fileName['file'], ',');
            }

            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('MechMaster');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new MechMaster('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MechMaster']))
            $model->attributes = $_GET['MechMaster'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return MechMaster the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = MechMaster::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param MechMaster $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'mech-master-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * =======================================API Calls==================================
     */

    /**
     * Array
      (
      [MechMaster] => Array
      (
      [name] => test
      [email] => test@test.com
      [mobile] => 456456546
      [pass] => 123456
      [os] => ios/android
      )
      )
     */
    public function actionregister() {

        if (isset($_REQUEST['MechMaster'])) {
            $model = new MechMaster;
            $response = array();

            if (isset($_FILES['MechMaster'])) {
                $fileName = $this->uploadDoc($_FILES['MechMaster']);
            } else {
                $fileName['file'] = "";
            }

            $model->attributes = $_REQUEST['MechMaster'];
            $model->dp = trim($fileName['file'], ',');
            $model->is_active = 1;
            if (!$model->save()) {
                $response['response'] = $model->getErrors();
            } else {
                $response['response'] = 'Record Saved!!';
                $response['id'] = $model->id;
                $response['mobile'] = $model->mobile;
                $response['name'] = $model->name;

                $emailOTP = OtpMaster::model()->generateOTP($model->id, 2, 1);
                $this->sendEmail($model->email, $emailOTP);

                /* $mobileOTP = OtpMaster::model()->generateOTP($model->id, 2, 2);
                  $this->sendSMS($model->mobile, $mobileOTP); */
            }

            echo json_encode($response);
        }
    }

    /**
     * Array
      (
      [MechMaster] => Array
      (
      [mech_id] => 1
      [oldPass] => 123456
      [pass] => 123456
      )
      )
     */
    public function actionchangePwd() {
        if (isset($_REQUEST['MechMaster'])) {

            $response = array();
            $mech_id = $_REQUEST['MechMaster']['mech_id'];
            $oldPass = $_REQUEST['MechMaster']['oldPass'];

            $result = MechMaster::model()->findAllByAttributes(array(
                'id' => $mech_id,
                'pass' => $oldPass
            ));

            if (count($result) == 0) {
                $response['response'] = 'Old Password Not Matched!!';
            } else {
                unset($_REQUEST['MechMaster']['oldPass']);
                unset($_REQUEST['MechMaster']['mech_id']);
                MechMaster::model()->updateByPk($mech_id, $_REQUEST['MechMaster']);
                $response['response'] = 'Record Updated!!';
            }

            echo json_encode($response);
        }
    }

    /**
     * Array
      (
      [MechMaster] => Array
      (
      [name] => test
      [email] => test@test.com
      [mech_id] => 1
      [pass] => 123456
      [os] => ios/android
      )
      )
     */
    public function actionupdateInfo() {

        if (isset($_REQUEST['MechMaster'])) {

            $response = array();
            $mech_id = $_REQUEST['MechMaster']['mech_id'];

            if (isset($_FILES['MechMaster'])) {
                $fileName = $this->uploadDoc($_FILES['MechMaster']);
                $_REQUEST['MechMaster']['dp'] = trim($fileName['file'], ',');
            }

            MechMaster::model()->updateByPk($mech_id, $_REQUEST['MechMaster']);

            $response['response'] = 'Record Updated!!';

            echo json_encode($response);
        }
    }

    public function uploadDoc($file) {

        $allowedExt = array('image/jpeg', 'image/png', 'image/tiff', 'image/bmp', 'image/x-windows-bmp', 'application/octet-stream');
        $response = array();
        $response['file'] = '';

        if (count($file) > 0 && $file['error']['dp'] == 0) {

            $result = in_array($file['type']['dp'], $allowedExt);

            if ($result > 0) {

                $temp = explode(".", $file['name']['dp']);
                $newfilename = dirname(__FILE__) . '/../../uploads/dp/' . $temp[0] . '-' . date('d-m-Y_H:i:s') . '.' . end($temp); // for linux

                try {
                    if ((move_uploaded_file($file['tmp_name']['dp'], $newfilename))) { // for linux
                        $response['file'] .= $temp[0] . '-' . date('d-m-Y_H:i:s') . '.' . end($temp) . ',';
                    } else {
                        $response = array();
                    }
                } catch (Exception $e) {
                    echo 'Message: ' . $e->getMessage();
                    die;
                }
            }
        } else {
            return $response = array('error' => 'Some error');
        }

        return $response;
    }

    /**
     * Array
      (
      [MechMaster] => Array
      (
      [mech_id] => 1
      [lat] => 19.171611
      [long] => 72.835001
      )
      )
     */
    public function actionupdateLocation() {

        if (isset($_REQUEST['MechMaster'])) {

            $mech_id = $_REQUEST['MechMaster']['mech_id'];

            $result = TrackMaster::model()->findAllByAttributes(array(
                'mech_id' => $mech_id
            ));

            if (count($result) > 0) {

                $model = TrackMaster::model()->findByPk($result[0]->id);
                $model->attributes = $_REQUEST['MechMaster'];
                $model->tracked_on = date('Y-m-d H:i:s');
            } else {

                $model = new TrackMaster;
                $model->attributes = $_REQUEST['MechMaster'];
                $model->tracked_on = date('Y-m-d H:i:s');
            }

            $model->location_detail = CommonFunctions::getLocationDetail($_REQUEST['MechMaster']['lat'], $_REQUEST['MechMaster']['long']);

            if (!$model->save()) {
                $response['response'] = $model->getErrors();
            } else {
                $response['response'] = 'Location Updated!!';
            }
        }

        echo json_encode($response);
    }

    /**
     * Array
      (
      [MechMaster] => Array
      (
      [mech_id] => 456456546
      )
      )
     */
    public function actiongetMechInfo() {

        if (isset($_REQUEST['MechMaster'])) {
            $model = MechMaster::model()->findByPk($_REQUEST['MechMaster']['mech_id']);
            $response = array();

            if ($model === null) {
                $response['response'] = 'No Records!!';
            } else {
                $response['name'] = $model->name;
                $response['email'] = $model->email;
                $response['mobile'] = $model->mobile;
                $response['dp'] = Yii::app()->getBaseUrl(true) . '/uploads/dp/' . $model->dp;

                $query = "SELECT sm.service_description, pm.price
                          FROM `services_master` sm, `price_master` pm
                          WHERE pm.mech_id = $model->id
                          AND sm.id = pm.service_id";
                $result = Yii::app()->db->createCommand($query)->queryAll();

                $response['Services'] = $result;
                $response['ratings'] = CommonFunctions::getMechanicRatings($model->id);
            }
        }

        echo json_encode($response);
    }

    /**
     * Array
      (
      [MechMaster] => Array
      (
      [mech_id] => 456456546
      )
      )
     */
    public function actionregenerateOTP() {

        $response = array();

        if (isset($_REQUEST['MechMaster'])) {
            $mech_id = $_REQUEST['MechMaster']['mech_id'];

            $otp = OtpMaster::model()->regenerateOTP($mech_id, 2);

            if (is_array($otp)) {

                $record = MechMaster::model()->findByAttributes(array('id' => $mech_id));

                if (!is_null($record) && $record->count() > 0) {
                    $this->sendEmail($record->email, $otp['email_otp']);
                    $this->sendSMS($record->mobile, $otp['mobile_otp']);
                }

                $response['response'] = 'Success';
            } else {
                $response['response'] = 'Old OTP Not Found!!';
            }
        }

        echo json_encode($response);
    }

    /**
     * Array
      (
      [MechMaster] => Array
      (
      [mech_id] => 456456546
      [otp_type] => email
      [otp] => 1141
      )
      )
     */
    public function actionvalidateOTP() {

        $response = array();

        if (isset($_REQUEST['MechMaster'])) {
            $mech_id = $_REQUEST['MechMaster']['mech_id'];
            $otp = $_REQUEST['MechMaster']['otp'];
            $type = $_REQUEST['MechMaster']['otp_type'] == 'email' ? 1 : 2;

            $record = OtpMaster::model()->findByAttributes(array('user_id' => $mech_id, 'user_type' => 2, 'otp' => $otp, 'generated_for' => $type, 'is_expire' => 0));

            if (!is_null($record) && $record->count() > 0) {

                OtpMaster::model()->updateByPk($record->id, array("is_expire" => 1));
                $response['response'] = 'Valid';
            } else {
                $response['response'] = 'Invalid';
            }
        }

        echo json_encode($response);
    }

    /**
     * Array
      (
      [MechMaster] => Array
      (
      [lat] => 19.173465
      [long] => 72.835795
      [service_id] => 2
      )
      )
     */
    public function actiongetNearBy() {

        if (isset($_REQUEST['MechMaster'])) {

            $lat = $_REQUEST['MechMaster']['lat'];
            $long = $_REQUEST['MechMaster']['long'];
            $service_id = $_REQUEST['MechMaster']['service_id'];

            $result = CommonFunctions::getNearbyMechanics($lat, $long, $service_id);

            if (count($result) == 0) {
                $data['response'] = 'No Records!!';
            } else {
                $data['response'] = $result;
            }

            echo json_encode($data);
        }
    }

    /**
     * 
     * @param string $email
     * @param integer $otp
     */
    public function sendEmail($email, $otp) {

        $subject = "Mechanic Team :: Welcome!!";

        $msg = "<p>Dear Sir/Madam,</p>
                    <p>This is to inform you that you are successfully registered on MECHANIC.</p>
                    <p>We welcomes you here.</p>
                    
                    <p>Please enter the below code to activate your email</p>
                    <p style='font-size: 25px;font-weight: bold'>$otp</p>
                    
                    <p>Please enter the code you have recieved on your registered mobile to activate your mobile</p>
                    Regards,<br>MECHANIC ADMIN";

        CommonFunctions::sendEmail($subject, $email, $msg);
    }

    /**
     * 
     * @param integer $mobile
     * @param integer $otp
     */
    public function sendSMS($mobile, $otp) {
        echo "Please enter the $otp to activate your email";
    }

}
