<?php

/**
 * This is the model class for table "otp_master".
 *
 * The followings are the available columns in table 'otp_master':
 * @property string $id
 * @property integer $user_id
 * @property integer $user_type
 * @property integer $otp
 * @property integer $generated_for
 * @property string $generated_on
 * @property integer $is_expire
 */
class OtpMaster extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'otp_master';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, user_type, otp', 'required'),
            array('user_id, user_type, otp, generated_for, is_expire', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, user_type, otp, generated_for, generated_on, is_expire', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'user_type' => 'User Type',
            'otp' => 'Otp',
            'generated_for' => 'Generated For',
            'generated_on' => 'Generated On',
            'is_expire' => 'Is Expire',
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
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('user_type', $this->user_type);
        $criteria->compare('otp', $this->otp);
        $criteria->compare('generated_for', $this->generated_for);
        $criteria->compare('generated_on', $this->generated_on, true);
        $criteria->compare('is_expire', $this->is_expire);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return OtpMaster the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function generateOTP($user_id, $user_type, $generated_for) {
        $otp = rand(10, 10000);
        $model = new OtpMaster();

        $model->user_id = $user_id;
        $model->user_type = $user_type;
        $model->otp = $otp;
        $model->generated_for = $generated_for;

        if(!$model->save()){
            echo '<pre>';
            print_r($model);
            die(print_r($model->getErrors()));
        }

        return $otp;
}

    public function regenerateOTP($user_id, $user_type) {

        $records = OtpMaster::model()->findAllByAttributes(array('user_id' => $user_id, 'user_type' => $user_type));

        if (count($records) > 0) {

            foreach ($records as $record) {

                if ($record->generated_for == 1) {
                    $data['email_otp'] = $record->otp;
                } elseif ($record->generated_for == 2) {
                    $data['mobile_otp'] = $record->otp;
                }
            }
        } else {
            $data = 0;
        }

        return $data;
    }

}
