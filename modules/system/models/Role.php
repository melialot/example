<?php

namespace app\modules\system\models;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $role_eu
 * @property string $role_ru
 */

class Role extends ActiveRecord
{
    const ROLE_ADMIN = 1;
    const ROLE_SUPPORT = 2;

    public static function getSchemaName()
    {
        return 'system';
    }

    public static function tableName()
    {
        return self::getSchemaName() . '.role';
    }

    public function getRole()
    {
        if (\Yii::$app->user->can('ru')) {
            return $this->role_ru;
        }
        return $this->role_eu;
    }

}