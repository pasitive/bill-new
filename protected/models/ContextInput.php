<?php

/**
 * This is the model class for table "context_input".
 *
 * The followings are the available columns in table 'context_input':
 * @property string $id
 * @property string $site_id
 * @property string $transitions_count
 * @property string $transitions_sum
 * @property string $avg_transition_price
 * @property string $created_at
 * @property string $updated_at
 * @property integer $adv_platform_id
 * @property integer $contract_id
 */
class ContextInput extends CActiveRecord
{

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {

            if( $this->transitions_count > 0 )
            {
                $this->avg_transition_price = round($this->transitions_sum / $this->transitions_count, 2);
            }

            return true;
        }

        return false;
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return ContextInput the static model class
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
        return 'context_input';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id, transitions_count, transitions_sum, avg_transition_price, adv_platform_id, created_at', 'required'),
            array('site_id, transitions_count', 'length', 'max' => 10),
            array('transitions_sum, avg_transition_price', 'length', 'max' => 7),
            array('created_at, updated_at', 'safe'),
            array('contract_id', 'numerical'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, site_id, transitions_count, transitions_sum, avg_transition_price, created_at, updated_at', 'safe', 'on' => 'search'),
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
            'site_id' => 'Сайт',
            'transitions_count' => 'Количество переходов',
            'transitions_sum' => 'Сумма',
            'avg_transition_price' => 'Средняя стоимость перехода',
            'created_at' => 'Время создания',
            'updated_at' => 'Время обновления',
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
        $criteria->compare('transitions_count', $this->transitions_count, true);
        $criteria->compare('transitions_sum', $this->transitions_sum, true);
        $criteria->compare('avg_transition_price', $this->avg_transition_price, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }


    public static function getDataByDate( $ssId, $date )
    {
        $siteService = SiteService::model()->findByPk( $ssId );

        $models = self::model()->findAllByAttributes(array(
            'site_id' => $siteService->site_id,
            'created_at' => date('Y-m-d H:i:s', strtotime($date)),
        ));


        $data = array();


        if( count($models) )
        {
            foreach( $models as $model )
            {
                $data[$model->adv_platform_id] = array(
                    'transitions_count' => $model->transitions_count,
                    'transitions_sum' => $model->transitions_sum,
                );
            }
        }


        return array(
            'status' => count( $models ) ? 'success' : 'empty',
            'data' => $data,
        );
    }

}