<?php

namespace app\modules\system\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * system.user - users that can use the crm system. Don't mess with the site users
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $first_name
 * @property string $middle_name
 * @property string $second_name
 * @property string $phone
 * @property string $password_hash
 * @property string $auth_key
 * @property string $chat_agent_id
 * @property integer $office_id
 * @property integer $role_id
 *
 * @property Office $office
 * @property Role $role
 */

class User extends ActiveRecord implements IdentityInterface
{
    public static function getSchemaName()
    {
        return 'system';
    }

    public static function tableName()
    {
        return self::getSchemaName() . '.user';
    }

    public function rules()
    {
        return [
            [['username', 'email', 'first_name', 'middle_name', 'second_name', 'phone'], 'string'],
            [['office_id', 'role_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id',
            'username' => \Yii::t('app', 'Login'),
            'email' => \Yii::t('app', 'Email'),
            'first_name' => \Yii::t('app', 'First name'),
            'middle_name' => \Yii::t('app', 'Middle name'),
            'second_name' => \Yii::t('app', 'Second name'),
            'phone' => \Yii::t('app', 'Phone'),
            'office_id' => \Yii::t('app', 'Office'),
            'role_id' => \Yii::t('app', 'Role'),
        ];
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @return \yii\db\ActiveQuery
    */
    public function getOffice()
    {
        return $this->hasOne(Office::className(), ['id' =>'office_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' =>'role_id']);
    }


    public function getFullName()
    {
        return $this->second_name . ' ' . $this->first_name . ' ' . $this->middle_name . ' (' . $this->username . ')';
    }

    public static function getCurrentUserOfficeId()
    {
        return self::find(\Yii::$app->user->id)->one()->office_id;
    }

    public static function getCurrentUserRoleId()
    {
        return self::find(\Yii::$app->user->id)->one()->role_id;
    }
}