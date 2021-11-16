<?php

/**
 * This is the model class for table "user_track_master".
 *
 * The followings are the available columns in table 'user_track_master':
 * @property string $id
 * @property integer $user_id
 * @property string $lat
 * @property string $long
 * @property string $location_detail
 * @property string $tracked_on
 */
class UserTrackMaster extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user_track_master';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, lat, long, location_detail', 'required'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('lat, long', 'length', 'max' => 50),
            array('location_detail', 'length', 'max' => 200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, lat, long, location_detail, tracked_on', 'safe', 'on' => 'search'),
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
            'lat' => 'Lat',
            'long' => 'Long',
            'location_detail' => 'Location Detail',
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
        $criteria->compare('lat', $this->lat, true);
        $criteria->compare('long', $this->long, true);
        $criteria->compare('location_detail', $this->location_detail, true);
        $criteria->compare('tracked_on', $this->tracked_on, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserTrackMaster the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
