<?php

namespace app\models;

use app\modules\system\models\Office;
use app\modules\system\models\User as SystemUser;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;


/**
 *
 * @property integer $id
 * @property boolean $is_active
 * @property string $username
 * @property string $email
 * @property string $first_name
 * @property string $middle_name
 * @property string $second_name
 * @property string $phone
 * @property string $country
 * @property string $region
 * @property string $city
 * @property string $address
 * @property string $post_index
 * @property string $comment
 * @property string $password_hash
 * @property string $auth_key
 * @property string $chat_hash
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $office_id
 *
 * @property Office $office
 * @property SystemUser $creator
 * @property SystemUser $updater
 */
class User extends ActiveRecord
{
    public static function tableName()
    {
        return 'public.user';
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['is_active', 'is_male'], 'boolean'],
            [['username', 'email', 'first_name', 'middle_name', 'second_name', 'phone'], 'string'],
            [['country', 'region', 'city', 'address', 'post_index'], 'string'],
            [['password_hash', 'auth_key', 'comment'], 'string'],
            [['day_of_birth'], 'string'],
            [['office_id'], 'integer'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => \Yii::t('app', 'ID'),
            'is_active' => \Yii::t('app', 'Active'),
            'username' => \Yii::t('app', 'Login'),
            'email' => \Yii::t('app', 'Email'),
            'first_name' => \Yii::t('app', 'First name'),
            'middle_name' => \Yii::t('app', 'Middle name'),
            'second_name' => \Yii::t('app', 'Second name'),
            'phone' => \Yii::t('app', 'Phone'),
            'country' => \Yii::t('app', 'Country'),
            'region' => \Yii::t('app', 'Region'),
            'city' => \Yii::t('app', 'City'),
            'address' => \Yii::t('app', 'Address'),
            'post_index' => \Yii::t('app', 'Post index'),
            'comment' => \Yii::t('app', 'Comment'),
            'password_hash' => \Yii::t('app', 'Password hash'),
            'auth_key' => \Yii::t('app', 'Auth key'),
            'office_id' => \Yii::t('app', 'Office'),
            'day_of_birth' => \Yii::t('app', 'Date of birth'),
            'is_male' => \Yii::t('app', 'Gender'),
            'fullName' => \Yii::t('app', 'Full name'),
            'fullAddress' => \Yii::t('app', 'Address'),
        ]);
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'office_id',
                ],
                'value' => function ($event) {
                    return \Yii::$app->user->getIdentity()->office_id;
                },
            ],
            [
                'class' => TimestampBehavior::className(),
                'value' => function() {
                    return date('Y-m-d H:i:s');
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_by',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_by',
                ],
                'value' => function ($event) {
                    return \Yii::$app->user->id;
                },
            ]
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffice()
    {
        return $this->hasOne(Office::className(), ['id' =>'office_id']);
    }

    public function getFullName()
    {
        return $this->second_name . ' ' . $this->first_name . ' ' . $this->middle_name . ' (' .$this->username . ')';
    }

    public function getFullAddress()
    {
        return ($this->post_index ? $this->post_index . ', ' : '')
            . ($this->country ? $this->country . ', ' : '')
            . ($this->region ? $this->region . ', ' : '')
            . ($this->city ? $this->city . ', ' : '')
            . ($this->address ? $this->address : '');
    }
}