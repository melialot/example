<?php

namespace app\common\components\rbac;

use yii\rbac\Rule;
use yii\helpers\ArrayHelper;
use app\modules\system\models\User;
use app\modules\system\models\Role;

class UserRoleRule extends Rule
{
    public $name = 'userRole';
    public function execute($user, $item, $params)
    {
        $user = ArrayHelper::getValue($params, 'user', User::findOne($user));
        if ($user) {
            $role = $user->role_id;
            switch ($item->name) {
                case 'admin':
                    return $role == Role::ROLE_ADMIN;
                    break;
                case 'support':
                    return $role == Role::ROLE_ADMIN || $role == Role::ROLE_SUPPORT;
                    break;
            }
        }
        return false;
    }
}