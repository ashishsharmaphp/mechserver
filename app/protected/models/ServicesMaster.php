<?php

/**
 * This is the model class for table "services_master".
 *
 * The followings are the available columns in table 'services_master':
 * @property integer $id
 * @property string $service_code
 * @property string $service_description
 * @property integer $vehical_type
 * @property integer $is_active
 * @property string $added_on
 *
 * The followings are the available model relations:
 * @property MechService[] $mechServices
 * @property RequestMaster[] $requestMasters
 * @property TransactionMaster[] $transactionMasters
 */
class ServicesMaster extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'services_master';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('service_code, service_description, vehical_type, is_active', 'required'),
            array('vehical_type, is_active', 'numerical', 'integerOnly' => true),
            array('service_code', 'length', 'max' => 50),
            array('service_description', 'length', 'max' => 150),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, service_code, service_description, vehical_type, is_active', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'mechServices' => array(self::HAS_MANY, 'MechService', 'service_id'),
            'requestMasters' => array(self::HAS_MANY, 'RequestMaster', 'service_id'),
            'transactionMasters' => array(self::HAS_MANY, 'TransactionMaster', 'service_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'service_code' => 'Service Code',
            'service_description' => 'Service Description',
            'vehical_type' => 'Vehical Type',
            'is_active' => 'Is Active',
            'added_on' => 'Added On',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('service_code', $this->service_code, true);
        $criteria->compare('service_description', $this->service_description, true);
        $criteria->compare('vehical_type', $this->vehical_type);
        $criteria->compare('is_active', $this->is_active);
        $criteria->compare('added_on', $this->added_on, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ServicesMaster the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
