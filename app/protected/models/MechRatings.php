<?php

/**
 * This is the model class for table "mech_ratings".
 *
 * The followings are the available columns in table 'mech_ratings':
 * @property string $id
 * @property integer $mech_id
 * @property integer $user_id
 * @property string $request_id
 * @property integer $rating
 * @property string $comments
 * @property string $added_on
 */
class MechRatings extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'mech_ratings';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs. 
        return array(
            array('mech_id, user_id, request_id, rating', 'required'),
            array('mech_id, user_id, rating', 'numerical', 'integerOnly' => true),
            array('request_id', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, mech_id, user_id, request_id, rating, comments, added_on', 'safe', 'on' => 'search'),
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
            'mech_id' => 'Mech',
            'user_id' => 'User',
            'request_id' => 'Request',
            'rating' => 'Rating',
            'comments' => 'Comments',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('mech_id', $this->mech_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('request_id', $this->request_id, true);
        $criteria->compare('rating', $this->rating);
        $criteria->compare('comments', $this->comments, true);
        $criteria->compare('added_on', $this->added_on, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MechRatings the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
