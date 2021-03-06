<?php

/**
 * This is the model class for table "site_phrase".
 *
 * The followings are the available columns in table 'site_phrase':
 * @property string $id
 * @property string $site_id
 * @property string $phrase
 * @property string $hash
 * @property string $price
 * @property string $created_at
 * @property string $updated_at
 * @property string $site_phrase_group_id
 *
 * The followings are the available model relations:
 * @property Site $site
 */
class SitePhrase extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return SitePhrase the static model class
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
        return 'site_phrase';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id, phrase, price', 'required'),
            array('active', 'boolean'),
            array('price', 'numerical', 'min' => 0, 'tooSmall' => 'Значение должно быть неотрицательным'),
            array('site_id', 'length', 'max' => 10),
            array('phrase', 'length', 'max' => 255),
            array('hash', 'length', 'max' => 32),
            array('created_at, updated_at', 'safe'),
            array('site_phrase_group_id', 'safe'),

            array('id, site_id, phrase, hash, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }


    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            $this->hash = md5($this->phrase);

            if( $this->site_phrase_group_id == '' )
            {
                $this->site_phrase_group_id = new CDbExpression('NULL');
            }

            return true;
        }

        return false;
    }


    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'site' => array(self::BELONGS_TO, 'Site', 'site_id'),
            'group' => array(self::BELONGS_TO, 'SitePhraseGroup', 'site_phrase_group_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'Код',
            'site_id' => 'Сайт',
            'phrase' => 'Запрос',
            'hash' => 'Хеш',
            'price' => 'Цена',
            'created_at' => 'Время создания',
            'updated_at' => 'Время обновления',
            'site_phrase_group_id' => 'Группа',
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
	
	public function siteOf($siteId)
	{
		$this->getDbCriteria()->mergeWith(array(
			'condition' => "t.site_id = $siteId",
		));
		
		return $this;
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

		$criteria->with = array( 'site', 'group' );
        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.site_id', $this->site_id);
        $criteria->compare('phrase', $this->phrase, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('hash', $this->hash, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
			'sort' => array(
				'attributes' => array(
					'site.domain' => array(
						'asc' => 'site.domain ASC',
						'desc' => 'site.domain DESC',
					),
                    'group.name' => array(
                        'asc' => 'group.name ASC',
                        'desc' => 'group.name DESC',
                    ),
					'*',
				),
			),
        ));
    }
	
	public function searchAsArray()
	{
        $criteria = new CDbCriteria;
        $criteria->with = array('group');

		return new CArrayDataProvider($this->findAll( $criteria ), array(
            'sort' => array(
				'attributes' => array(
                    'group.name' => array(
                        'asc' => 'group.name ASC',
                        'desc' => 'group.name DESC',
                    ),
					'*',
				),
			),
		));
	}
}