<?php

/**
 * This is the model class for table "mech_master".
 *
 * The followings are the available columns in table 'mech_master':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $mobile
 * @property string $pass
 * @property string $device_token
 * @property string $os
 * @property integer $email_valid
 * @property integer $mobile_valid
 * @property integer $is_active
 * @property integer $is_busy
 * @property integer $is_logged_in
 * @property string $added_on
 *
 * The followings are the available model relations:
 * @property MechService[] $mechServices
 * @property TrackMaster[] $trackMasters
 * @property TransactionMaster[] $transactionMasters
 */
class MechMaster extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'mech_master';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, email, mobile, pass, device_token, os', 'required'),
            array('email', 'email'),
            array('email', 'customValidateEmail'),
            array('mobile', 'customValidateMobile'),
            array('device_token', 'customValidateDeviceToken'),
            array('email_valid, mobile_valid, is_active, is_busy, is_logged_in', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 100),
            array('email, pass, os', 'length', 'max' => 50),
            array('mobile', 'length', 'max' => 10, 'min' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, email, mobile, pass, device_token, os, email_valid, mobile_valid, is_active, is_busy, is_logged_in, added_on', 'safe', 'on' => 'search'),
        );
    }

    public function customValidateEmail() {
        $email = $this->email;
        $sqlEmail = "select count(*) 
                from (
                    select `email` from mech_master
                    union all
                    select `email` from user_master
                ) a
                where a.email = '$email'";

        $respEmail = Yii::app()->db->createCommand($sqlEmail)->queryScalar();

        if ($respEmail > 0) {
            $this->addError('email', 'Email already registered!!');
            return false;
        }
    }

    public function customValidateMobile() {

        //Validate Mobile ----------------------------------
        $mobile = $this->mobile;
        $sqlMobile = "select count(*) 
                        from (
                            select `mobile` from mech_master
                            union all
                            select `mobile` from user_master
                        ) a
                        where a.mobile = '$mobile'";

        $respMobile = Yii::app()->db->createCommand($sqlMobile)->queryScalar();

        if ($respMobile > 0) {
            $this->addError('email', 'Mobile already registered!!');
            return false;
        }
    }

    public function customValidateDeviceToken() {

        //Validate Mobile ----------------------------------
        $device_token = $this->device_token;
        $sqldevicetoken = "select count(*) 
                        from (
                            select `device_token` from mech_master
                            union all
                            select `device_token` from user_master
                        ) a
                        where a.device_token = '$device_token'";

        $respdevicetoken = Yii::app()->db->createCommand($sqldevicetoken)->queryScalar();

        if ($respdevicetoken > 0) {
            $this->addError('device_token', 'Device token already registered!!');
            return false;
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'mechServices' => array(self::HAS_MANY, 'MechService', 'mech_id'),
            'trackMasters' => array(self::HAS_MANY, 'TrackMaster', 'mech_id'),
            'transactionMasters' => array(self::HAS_MANY, 'TransactionMaster', 'mech_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'mobile' => 'Mobile',
            'pass' => 'Pass',
            'device_token' => 'Device Token',
            'os' => 'Os',
            'email_valid' => 'Email Valid',
            'mobile_valid' => 'Mobile Valid',
            'is_active' => 'Is Active',
            'is_busy' => 'Is Busy',
            'is_logged_in' => 'Is Logged In',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('pass', $this->pass, true);
        $criteria->compare('device_token', $this->device_token, true);
        $criteria->compare('os', $this->os, true);
        $criteria->compare('email_valid', $this->email_valid);
        $criteria->compare('mobile_valid', $this->mobile_valid);
        $criteria->compare('is_active', $this->is_active);
        $criteria->compare('is_busy', $this->is_busy);
        $criteria->compare('is_logged_in', $this->is_logged_in);
        $criteria->compare('added_on', $this->added_on, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MechMaster the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
