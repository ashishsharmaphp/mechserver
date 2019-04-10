<?php

/**
 * This is the model class for table "request_master".
 *
 * The followings are the available columns in table 'request_master':
 * @property string $id
 * @property integer $user_id
 * @property integer $service_id
 * @property string $lats
 * @property string $longs
 * @property string $location_detail
 * @property integer $status
 * @property string $user_type
 * @property string $related_req_id
 * @property string $comments
 * @property string $tracked_on
 *
 * The followings are the available model relations:
 * @property ServicesMaster $service
 * @property RequestVehicalDetails[] $requestVehicalDetails
 */
class RequestMaster extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'request_master';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, service_id, status, related_req_id', 'required'),
            array('user_id, service_id, status, related_req_id', 'numerical', 'integerOnly' => true),
            array('lats, longs', 'length', 'max' => 50),
            array('user_type', 'length', 'max' => 10),
            array('comments', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, service_id, lats, longs, location_detail, status, user_type, related_req_id, comments, tracked_on', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'service' => array(self::BELONGS_TO, 'ServicesMaster', 'service_id'),
            'requestVehicalDetails' => array(self::HAS_MANY, 'RequestVehicalDetails', 'request_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'service_id' => 'Service',
            'lats' => 'Lats',
            'longs' => 'Longs',
            'location_detail' => 'Location Detail',
            'status' => 'Status',
            'user_type' => 'User Type',
            'related_req_id' => 'Related Req',
            'comments' => 'Comments',
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
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('service_id', $this->service_id);
        $criteria->compare('lats', $this->lats, true);
        $criteria->compare('longs', $this->longs, true);
        $criteria->compare('location_detail', $this->location_detail, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('user_type', $this->user_type, true);
        $criteria->compare('related_req_id', $this->related_req_id, true);
        $criteria->compare('comments', $this->comments, true);
        $criteria->compare('tracked_on', $this->tracked_on, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RequestMaster the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
