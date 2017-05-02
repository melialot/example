<?php

namespace app\common\components\rbac;

use yii\rbac\Rule;
use yii\helpers\ArrayHelper;
use app\modules\system\models\Office;
use app\modules\system\models\User;

class UserOfficeRule extends Rule
{
    public $name = 'userOffice';
    public function execute($user, $item, $params)
    {
        $user = ArrayHelper::getValue($params, 'user', User::findOne($user));
        if ($user && isset ($user->office_id)) {
            $office = $user->office_id;
            switch ($item->name) {
                case 'ru':
                    return $office == Office::OFFICE_RU;
                    break;
                case 'eu':
                    return $office == Office::OFFICE_EU;
                    break;
                default:
                    return false;
                    break;
            }

        }
        return false;
    }
}