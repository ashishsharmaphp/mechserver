<?php

/**
 * This is the model class for table "transaction_master".
 *
 * The followings are the available columns in table 'transaction_master':
 * @property string $id
 * @property integer $request_id
 * @property integer $user_id
 * @property integer $mech_id
 * @property integer $service_id
 * @property string $service_charge
 * @property string $status
 * @property string $paid_by
 * @property string $transaction_id
 * @property string $return_transaction_id
 * @property string $tracked_on
 *
 * The followings are the available model relations:
 * @property MechMaster $mech
 * @property UserMaster $user
 * @property ServicesMaster $service
 */
class TransactionMaster extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'transaction_master';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('request_id, user_id, mech_id, service_id, service_charge, status, transaction_id', 'required'),
            array('request_id, user_id, mech_id, service_id', 'numerical', 'integerOnly' => true),
            array('service_charge', 'length', 'max' => 10),
            array('status', 'length', 'max' => 50),
            array('paid_by', 'length', 'max' => 17),
            array('transaction_id, return_transaction_id', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, request_id, user_id, mech_id, service_id, service_charge, status, paid_by, transaction_id, return_transaction_id, tracked_on', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'mech' => array(self::BELONGS_TO, 'MechMaster', 'mech_id'),
            'user' => array(self::BELONGS_TO, 'UserMaster', 'user_id'),
            'service' => array(self::BELONGS_TO, 'ServicesMaster', 'service_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'request_id' => 'Request',
            'user_id' => 'User',
            'mech_id' => 'Mech',
            'service_id' => 'Service',
            'service_charge' => 'Service Charge',
            'status' => 'Status',
            'paid_by' => 'Paid By',
            'transaction_id' => 'Transaction',
            'return_transaction_id' => 'Return Transaction',
            'tracked_on' => 'Tracked On',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('request_id', $this->request_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('mech_id', $this->mech_id);
        $criteria->compare('service_id', $this->service_id);
        $criteria->compare('service_charge', $this->service_charge, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('paid_by', $this->paid_by, true);
        $criteria->compare('transaction_id', $this->transaction_id, true);
        $criteria->compare('return_transaction_id', $this->return_transaction_id, true);
        $criteria->compare('tracked_on', $this->tracked_on, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TransactionMaster the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
