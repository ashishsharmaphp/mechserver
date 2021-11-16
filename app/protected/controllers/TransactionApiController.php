<?php

class TransactionApiController extends Controller {

    /**
     * Array
      (
      [TransactionApi] => Array
      (
      [user_id] => 1
      [mech_id] => 2
      [service_id] => 5
      [vehical_type] => 1
      [service_time] => 2015-11-17 11:38:28
      [service_charge] => 550
      [paid_by] => cash
      [transaction_id] => CCAVENUE59856565RTGS
      )
      )
     */
    public function actionIndex() {

        if (isset($_REQUEST['TransactionApi'])) {
            $model = new TransactionMaster;
            $response = array();

            $model->attributes = $_REQUEST['TransactionApi'];
            if (!$model->save()) {
                $response['response'] = $model->getErrors();
            } else {
                $response['response'] = 'Record Saved!!';
                $response['id'] = Yii::app()->db->getLastInsertId();
            }

            echo json_encode($response);
        }
    }

}
