<?php

/**
 * This is the model class for table "transition_input".
 *
 * The followings are the available columns in table 'transition_input':
 * @property string $id
 * @property string $site_id
 * @property string $transitions
 * @property string $created_at
 * @property string $updated_at
 * @property integer $contract_id
 *
 */
class TransitionInput extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return TransitionInput the static model class
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
        return 'transition_input';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id, transitions', 'required'),
            array('site_id, transitions', 'length', 'max' => 10),
            array('created_at, updated_at', 'safe'),
            array('contract_id', 'numerical'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, site_id, transitions, created_at, updated_at', 'safe', 'on' => 'search'),
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
            'transitions' => 'Переходов',
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
        $criteria->compare('transitions', $this->transitions, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }


    public static function getDataByDate( $ssId, $date )
    {
        $siteService = SiteService::model()->findByPk( $ssId );

        $model = self::model()->findByAttributes(array(
            'site_id' => $siteService->site_id,
            'created_at' => date('Y-m-d H:i:s', strtotime($date)),
        ));


        if( !empty($model) )
        {
            $status = 'success';
            $data = array(
                'transitions' => $model->transitions,
            );
        }
        else
        {
            $status = 'empty';
            $data = array(
                'transitions' => '',
            );
        }


        return array(
            'status' => $status,
            'data' => $data,
        );
    }

}