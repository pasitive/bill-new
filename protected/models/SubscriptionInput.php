<?php

/**
 * This is the model class for table "subscription_input".
 *
 * The followings are the available columns in table 'subscription_input':
 * @property string $id
 * @property string $site_id
 * @property string $sum
 * @property string $link_count
 * @property string $avg_link_price
 * @property string $created_at
 * @property string $updated_at
 */
class SubscriptionInput extends CActiveRecord
{

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->avg_link_price = round($this->sum / $this->link_count, 2);
            return true;
        }
        return false;
    }

    /**
     * Returns the static model of the specified AR class.
     * @return SubscriptionInput the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'subscription_input';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id, sum, link_count, avg_link_price', 'required'),
            array('site_id, sum, link_count, avg_link_price', 'length', 'max' => 10),
            array('created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, site_id, sum, link_count, avg_link_price, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'site_id' => 'Site',
            'sum' => 'Sum',
            'link_count' => 'Link Count',
            'avg_link_price' => 'Avg Link Price',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        );
    }

    /**
     * @return array behaviors.
     */
    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => null,
                'updateAttribute' => 'updated_at',
                'setUpdateOnCreate' => true
            )
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('sum', $this->sum, true);
        $criteria->compare('link_count', $this->link_count, true);
        $criteria->compare('avg_link_price', $this->avg_link_price, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}