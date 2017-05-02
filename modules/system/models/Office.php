<?php

namespace app\modules\system\models;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $code
 * @property  string $name
*/

class Office extends ActiveRecord
{
    const OFFICE_RU = 1;
    const OFFICE_EU = 2;

    public static function getSchemaName()
    {
        return 'system';
    }

    public static function tableName()
    {
        return self::getSchemaName() . '.office';
    }

}