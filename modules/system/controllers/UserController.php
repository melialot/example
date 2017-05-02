<?php

namespace app\modules\system\controllers;

use app\controllers\BaseController;
use app\modules\system\models\Office;
use app\modules\system\models\Role;
use yii\web\ForbiddenHttpException;


class UserController extends BaseController
{
    public $modelClass = 'app\modules\system\models\User';
    public $searchClass = 'app\modules\system\models\UserSearch';
    public $title = 'System users';

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (!\Yii::$app->getUser()->can('admin')) {
                throw new ForbiddenHttpException('Access denied');
            }
            return true;
        }

        return false;
    }


    public function getRelatedData($id = null)
    {
        $offices = \yii\helpers\ArrayHelper::map(Office::find()->all(), 'id', 'code');
        $roles = \yii\helpers\ArrayHelper::map(Role::find()->all(), 'id', 'role');
        return [
            'offices' => $offices,
            'roles' => $roles,
        ];
    }
}