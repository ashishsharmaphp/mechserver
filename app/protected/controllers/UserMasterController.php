<?php

class UserMasterController extends Controller {

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
                'actions' => array('index', 'view', 'register', 'login', 'logout', 'updateLocation', 'regenerateOTP', 'validateOTP', 'updateInfo', 'getLocation', 'isLoggedin', 'getUserinfo', 'changePwd'),
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

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('UserMaster');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
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
        $model = new UserMaster;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_FILES['dp']) && $_FILES['dp']['error'] == 0) {
            $fileName = $this->uploadDoc($_FILES['dp']);
        } else {
            $fileName['file'] = "";
        }

        if (isset($_POST['UserMaster'])) {
            $model->attributes = $_POST['UserMaster'];
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

        if (isset($_POST['UserMaster'])) {
            $model->attributes = $_POST['UserMaster'];

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
     * Manages all models. 
     */
    public function actionAdmin() {
        $model = new UserMaster('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UserMaster']))
            $model->attributes = $_GET['UserMaster'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return UserMaster the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = UserMaster::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param UserMaster $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-master-form') {
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
      [UserMaster] => Array
      (
      [mobile] => 456456546
      [device_token] => 123456
      )
      )
     */
    public function actionisLoggedin() {

        if (isset($_REQUEST['UserMaster'])) {
            $mobile = $_REQUEST['UserMaster']['mobile'];
            $device_token = $_REQUEST['UserMaster']['device_token'];
            $response = array();

            $recordUser = UserMaster::model()->findByAttributes(array('mobile' => $mobile, 'device_token' => $device_token, 'is_active' => 1));
            $recordMech = MechMaster::model()->findByAttributes(array('mobile' => $mobile, 'device_token' => $device_token, 'is_active' => 1));

            if ((!is_null($recordUser) && $recordUser->count() > 0) || (!is_null($recordMech) && $recordMech->count() > 0)) {
                $response['response'] = 'TRUE';
            } else {
                $response['response'] = 'FALSE';
            }

            echo json_encode($response);
        }
    }

    /**
     * Array
      (
      [UserMaster] => Array
      (
      [user_id] => 1
      [pass] => 123456
      )
      )
     */
    public function actionchangePwd() {
        if (isset($_REQUEST['UserMaster'])) {

            $response = array();
            $user_id = $_REQUEST['UserMaster']['user_id'];
            $oldPass = $_REQUEST['UserMaster']['oldPass'];

            $result = UserMaster::model()->findAllByAttributes(array(
                'id' => $user_id,
                'pass' => $oldPass
            ));

            if (count($result) == 0) {
                $response['response'] = 'Old Password Not Matched!!';
            } else {
                unset($_REQUEST['UserMaster']['oldPass']);
                unset($_REQUEST['UserMaster']['user_id']);
                UserMaster::model()->updateByPk($user_id, $_REQUEST['UserMaster']);
                $response['response'] = 'Record Updated!!';
            }

            echo json_encode($response);
        }
    }

    /**
     * Array
      (
      [UserMaster] => Array
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

        if (isset($_REQUEST['UserMaster'])) {
            $model = new UserMaster;
            $response = array();

            if (isset($_FILES['UserMaster'])) {
                $fileName = $this->uploadDoc($_FILES['UserMaster']);
            } else {
                $fileName['file'] = "";
            }

            $model->attributes = $_REQUEST['UserMaster'];
            $model->dp = trim($fileName['file'], ',');

            if (!$model->save()) {
                $response['response'] = $model->getErrors();
            } else {
                $response['response'] = 'Record Saved!!';
                $response['id'] = $model->id;
                $response['mobile'] = $model->mobile;
                $response['name'] = $model->name;

                $emailOTP = OtpMaster::model()->generateOTP($model->id, 1, 1);
                $this->sendEmail($model->email, $emailOTP);

                /*
                  $mobileOTP = OtpMaster::model()->generateOTP($model->id, 1, 2);
                  $this->sendSMS($model->mobile, $mobileOTP); */
            }

            echo json_encode($response);
        }
    }

    
    
    /**
     * Array
     (
     [UserMaster] => Array
     (
     [user_id] => 1
     )
     )
     */
    public function actionupdateInfo() {
        
        if (isset($_REQUEST['UserMaster'])) {
            
            $response = array();
            $user_id = $_REQUEST['UserMaster']['user_id'];
            
            if (isset($_FILES['UserMaster'])) {
                $fileName = $this->uploadDoc($_FILES['UserMaster']);
                $_REQUEST['UserMaster']['dp'] = trim($fileName['file'], ',');
            }
            
            UserMaster::model()->updateByPk($user_id, $_REQUEST['UserMaster']);
            
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
      [UserMaster] => Array
      (
      [user_id] => 456456546
      )
      )
     */
    public function actiongetUserInfo() {

        if (isset($_REQUEST['UserMaster'])) {
            $model = UserMaster::model()->findByPk($_REQUEST['UserMaster']['user_id']);
            $response = array();

            if ($model === null) {
                $response['response'] = 'No Records!!';
            } else {
                $response['name'] = $model->name;
                $response['email'] = $model->email;
                $response['mobile'] = $model->mobile;
                $response['dp'] = Yii::app()->getBaseUrl(true) . '/uploads/dp/' . $model->dp;
            }
        }

        echo json_encode($response);
    }

    /**
     * Array
      (
      [UserMaster] => Array
      (
      [mobile] => 456456546
      [pass] => 123456
      [device_token] => 123456sfsdf
      [os] => ios/android
      )
      )
     */
    public function actionlogin() {

        $response = array();

        if (isset($_REQUEST['UserMaster'])) {
            $mobile = $_REQUEST['UserMaster']['mobile'];
            $pass = $_REQUEST['UserMaster']['pass'];

            $recordUser = UserMaster::model()->findByAttributes(array('mobile' => $mobile, 'pass' => $pass, 'is_active' => 1));
            $recordMech = MechMaster::model()->findByAttributes(array('mobile' => $mobile, 'pass' => $pass, 'is_active' => 1));

            if (!is_null($recordUser) && $recordUser->count() > 0) {

                $sql = "Update `user_master` set device_token = '' and `is_logged_in` = 0 where device_token = '$recordUser->device_token';";
                Yii::app()->db->createCommand($sql)->execute();

                $response = array(
                    'response' => 'Login Success!!',
                    'id' => $recordUser->id,
                    'mobile' => $recordUser->mobile,
                    'name' => $recordUser->name,
                    'type' => 'U',
                );

                $updateData = array(
                    'device_token' => $_REQUEST['UserMaster']['device_token'],
                    'os' => $_REQUEST['UserMaster']['os'],
                    'is_logged_in' => 1,
                );
                UserMaster::model()->updateByPk($recordUser->id, $updateData);
            } elseif (!is_null($recordMech) && $recordMech->count() > 0) {

                $sql = "Update `mech_master` set device_token = '' and `is_logged_in` = 0 where device_token = '$recordMech->device_token'";
                Yii::app()->db->createCommand($sql)->execute();

                $response = array(
                    'response' => 'Login Success!!',
                    'id' => $recordMech->id,
                    'mobile' => $recordMech->mobile,
                    'name' => $recordMech->name,
                    'type' => 'M',
                );

                $updateData = array(
                    'device_token' => $_REQUEST['UserMaster']['device_token'],
                    'os' => $_REQUEST['UserMaster']['os'],
                    'is_logged_in' => 1,
                );

                MechMaster::model()->updateByPk($recordMech->id, $updateData);
            } else {

                $response['response'] = 'Invalid Identity!!';
                $response['help'] = 'Invalid mobile number and password!!';
            }
        }

        echo json_encode($response);
    }

    /**
     * Array
      (
      [UserMaster] => Array
      (
      [mobile] => 456456546
      )
      )
     */
    public function actionlogout() {

        $response = array();

        if (isset($_REQUEST['UserMaster'])) {
            $mobile = $_REQUEST['UserMaster']['mobile'];

            $recordUser = UserMaster::model()->findByAttributes(array('mobile' => $mobile));

            $recordMech = MechMaster::model()->findByAttributes(array('mobile' => $mobile));

            if (!is_null($recordUser) && $recordUser->count() > 0) {

                UserMaster::model()->updateByPk($recordUser->id, array("is_logged_in" => 0, "is_busy" => 0, 'device_token' => ''));
                $response['response'] = 'Logout Success!!';
            } elseif (!is_null($recordMech) && $recordMech->count() > 0) {

                MechMaster::model()->updateByPk($recordMech->id, array("is_logged_in" => 0, "is_busy" => 0, 'device_token' => ''));
                $response['response'] = 'Logout Success!!';
            } else {

                $response['response'] = 'Invalid Identity!!';
            }
        }

        echo json_encode($response);
    }

    /**
     * Array
      (
      [UserMaster] => Array
      (
      [user_id] => 456456546
      [lat] => 456456546
      [long] => 456456546
      )
      )
     */
    public function actionupdateLocation() {

        if (isset($_REQUEST['UserMaster'])) {

            $mech_id = $_REQUEST['UserMaster']['user_id'];

            $result = UserTrackMaster::model()->findAllByAttributes(array(
                'user_id' => $mech_id
            ));

            if (count($result) > 0) {

                $model = UserTrackMaster::model()->findByPk($result[0]->id);
                $model->attributes = $_REQUEST['UserMaster'];
                $model->tracked_on = date('Y-m-d H:i:s');
            } else {

                $model = new UserTrackMaster;
                $model->attributes = $_REQUEST['UserMaster'];
                $model->tracked_on = date('Y-m-d H:i:s');
            }

            $model->location_detail = CommonFunctions::getLocationDetail($_REQUEST['UserMaster']['lat'], $_REQUEST['UserMaster']['long']);

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
      [UserMaster] => Array
      (
      [user_id] => 456456546
      )
      )
     */
    public function actionregenerateOTP() {

        $response = array();

        if (isset($_REQUEST['UserMaster'])) {
            $userId = $_REQUEST['UserMaster']['user_id'];

            $otp = OtpMaster::model()->regenerateOTP($userId, 1);

            if (is_array($otp)) {

                $record = UserMaster::model()->findByAttributes(array('id' => $userId));

                if (!is_null($record) && $record->count() > 0) {
                    $this->sendEmail($record->email, $otp['email_otp']);
                    //$this->sendSMS($record->mobile, $otp['mobile_otp']);
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
      [UserMaster] => Array
      (
      [user_id] => 456456546
      [otp_type] => email
      [otp] => 1141
      )
      )
     */
    public function actionvalidateOTP() {

        $response = array();

        if (isset($_REQUEST['UserMaster'])) {
            $userId = $_REQUEST['UserMaster']['user_id'];
            $otp = $_REQUEST['UserMaster']['otp'];
            $type = $_REQUEST['UserMaster']['otp_type'] == 'email' ? 1 : 2;

            $record = OtpMaster::model()->findByAttributes(array('user_id' => $userId, 'user_type' => 1, 'otp' => $otp, 'generated_for' => $type, 'is_expire' => 0));

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
      [UserMaster] => Array
      (
      [user_id] => 456456546
      [user_type] => U/M
      )
      )
     */
    public function actiongetLocation() {

        $response = array();

        if (isset($_REQUEST['UserMaster'])) {
            $userId = $_REQUEST['UserMaster']['user_id'];
            $user_type = $_REQUEST['UserMaster']['user_type'];

            if ($user_type == 'M') {
                $record = TrackMaster::model()->findByAttributes(array('mech_id' => $userId), array('order' => 'tracked_on DESC'));
            } else {
                $record = UserTrackMaster::model()->findByAttributes(array('user_id' => $userId), array('order' => 'tracked_on DESC'));
            }

            if (!is_null($record) && $record->count() > 0) {

                $response['response'] = array(
                    'mech_id' => $record->mech_id,
                    'lat' => $record->lat,
                    'long' => $record->long,
                    'location_detail' => $record->location_detail,
                );
            } else {
                $response['response'] = 'No Records Found!!';
            }
        }

        echo json_encode($response);
    }

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

    public function sendSMS($mobile, $otp) {
        echo "Please enter the $otp to activate your email";
    }

}
