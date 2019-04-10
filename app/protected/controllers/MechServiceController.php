<?php

class MechServiceController extends Controller {

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
                'actions' => array('index', 'view', 'getAllServices', 'updateService', 'deleteService', 'insertService'),
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
        $model = new MechService;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['MechService'])) {
            $model->attributes = $_POST['MechService'];
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

        if (isset($_POST['MechService'])) {
            $model->attributes = $_POST['MechService'];
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
        $dataProvider = new CActiveDataProvider('MechService');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new MechService('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MechService']))
            $model->attributes = $_GET['MechService'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return MechService the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = MechService::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param MechService $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'mech-service-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * =======================================API Calls==================================
     */

    /**
     * This gives list of all services OR
     * The list of services provide by any mechanic_id
     */
    public function actiongetAllServices() {

        $model = ServicesMaster::model();
        $criteria = new CDbCriteria();

        if (isset($_REQUEST['MechService'])) {
            $mech_id = $_REQUEST['MechService']['mech_id'];
            $criteria->join = "JOIN mech_service m ON t.id = m.service_id and m.mech_id = $mech_id";
        }

        $criteria->condition = "is_active = 1";

        $trips = $model->getCommandBuilder()
                ->createFindCommand($model->tableSchema, $criteria)
                ->queryAll();

        echo json_encode($trips);
    }

    /**
     * Array
      (
      [MechService] => Array
      (
      [mech_id] => 52
      [service_id] => 2
      )
      )
     */
    public function actioninsertService() {

        if (isset($_REQUEST['MechService'])) {

            $mech_id = $_REQUEST['MechService']['mech_id'];
            $service_id = $_REQUEST['MechService']['service_id'];

            $result = MechService::model()->findAllByAttributes(array(
                'mech_id' => $mech_id,
                'service_id' => $service_id
            ));

            if (count($result) > 0) {

                $response['response'] = 'Service Already Exists!!';
            } else {

                $model = new MechService;
                $model->attributes = $_REQUEST['MechService'];

                if (!$model->save()) {
                    $response['response'] = $model->getErrors();
                } else {
                    $response['response'] = 'Service Added!!';
                }
            }
        }

        echo json_encode($response);
    }

    /**
     * Array
      (
      [MechService] => Array
      (
      [mech_id] => 52
      [service_id] => 2
      )
      )
     */
    public function actiondeleteService() {

        if (isset($_REQUEST['MechService'])) {

            $mech_id = $_REQUEST['MechService']['mech_id'];
            $service_id = $_REQUEST['MechService']['service_id'];

            $result = MechService::model()->findAllByAttributes(array(
                'mech_id' => $mech_id,
                'service_id' => $service_id
            ));

            if (count($result) > 0) {

                MechService::model()->deleteByPk($result[0]->id);

                $response['response'] = 'Service Deleted!!';
            } else {

                $response['response'] = 'Service Already Exists!!';
            }
        }

        echo json_encode($response);
    }

    /**
     * Array
      (
      [MechService] => Array
      (
      [mech_id] => 1
      [service_id] => 25
      [price] => 500
      [comments] => ABCD
      )
      )
     */
    public function actionupdateService() {

        if (isset($_REQUEST['MechService'])) {

            $mech_id = $_REQUEST['MechService']['mech_id'];
            $service_id = $_REQUEST['MechService']['service_id'];
            $price = $_REQUEST['MechService']['price'];
            $comments = $_REQUEST['MechService']['comments'];

            $SQL = "UPDATE `mech_service`
                    SET 
                        `price` = '$price', `comments` = '$comments'
                    WHERE 
                        `mech_id` = $mech_id
                    AND
                        `service_id` = $service_id";

            $update = Yii::app()->db->createCommand()->execute($SQL);
            $response['response'] = 'Price Updated!!';
        }

        echo json_encode($response);
    }

}
