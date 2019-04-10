<?php

/**
 * This is the model class for table "mech_service".
 *
 * The followings are the available columns in table 'mech_service':
 * @property integer $id
 * @property integer $mech_id
 * @property integer $service_id
 * @property string $price
 * @property string $comments
 * @property string $added_on
 *
 * The followings are the available model relations:
 * @property MechMaster $mech
 * @property ServicesMaster $service
 */
class MechService extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'mech_service';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('mech_id, service_id, price', 'required'),
            array('mech_id, service_id', 'numerical', 'integerOnly' => true),
            array('price', 'length', 'max' => 10),
            array('comments', 'length', 'max' => 200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, mech_id, service_id, price, comments', 'safe', 'on' => 'search'),
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
            'service' => array(self::BELONGS_TO, 'ServicesMaster', 'service_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'mech_id' => 'Mech',
            'service_id' => 'Service',
            'price' => 'Price',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('mech_id', $this->mech_id);
        $criteria->compare('service_id', $this->service_id);
        $criteria->compare('price', $this->price, true);
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
     * @return MechService the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
