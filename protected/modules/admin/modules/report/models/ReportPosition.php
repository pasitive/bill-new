<?php

/**
 * This is the model class for table "report_position".
 *
 * The followings are the available columns in table 'report_position':
 * @property string $id
 * @property integer $report_id
 * @property integer $site_id
 * @property integer $system_id
 * @property string $sum
 * @property string $created_at
 * @property string $updated_at
 */
class ReportPosition extends CActiveRecord
{

    public $yandex;
    public $google;


    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return ReportPosition the static model class
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
        return 'report_position';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('report_id, site_id, system_id', 'numerical', 'integerOnly' => true),
            array('sum', 'length', 'max' => 20),
            array('created_at, updated_at', 'safe'),
// The following rule is used by search().
// Please remove those attributes that should not be searched.
            array('id, report_id, site_id, system_id, sum, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'site' => array(self::BELONGS_TO, 'Site', 'site_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'report_id' => 'Report',
            'site_id' => 'Site',
            'system_id' => 'System',
            'sum' => 'Sum',
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
                'createAttribute' => 'created_at',
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
        $criteria->compare('report_id', $this->report_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('system_id', $this->system_id);
        $criteria->compare('sum', $this->sum, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /*
     * Return grouped data for report view
     */
    public function grouped($reportId)
    {
        $query = 'select
                    site_id,
                    sum(sum) as sum,
                    system_id,
                    (select sum from report_position where system_id = :google_id and site_id = t.site_id and report_id = :report_id_1) as google,
                    (select sum from report_position where system_id = :yandex_id and site_id = t.site_id and report_id = :report_id_2) as yandex
                from
                    report_position t
                where
                    `report_id` = :report_id_3
                group by
                    `site_id`';


        $params = array(
            ':report_id_1' => $reportId,
            ':report_id_2' => $reportId,
            ':report_id_3' => $reportId,
            ':yandex_id' => Factor::SYSTEM_YANDEX,
            ':google_id' => Factor::SYSTEM_GOOGLE,
        );


        return $this->findAllBySql($query, $params);
    }


    /**
     * Returns total balance
     *
     *  return 321554;
     */
    public static function getBalance($reportId)
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'sum(sum) as sum';
        $criteria->condition = 'report_id = :report_id';
        $criteria->params = array(':report_id' => $reportId);

        $balance = self::model()->find($criteria)->sum;

        return $balance;
    }

}