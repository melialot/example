<?php

namespace app\controllers;

use app\modules\system\models\Office;
use yii\db\ActiveRecord;
use yii\web\ForbiddenHttpException;
use app\modules\system\models\User as SysmtemUser;

class UserController extends BaseController
{
    public $modelClass = 'app\models\User';
    public $searchClass = 'app\models\UserSearch';
    public $title = 'Users';

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (
            !(\Yii::$app->getUser()->can('admin')
                || \Yii::$app->getUser()->can('support')
                || \Yii::$app->getUser()->can('sales')
            )
            ) {
                throw new ForbiddenHttpException('Access denied');
            }
            return true;
        }

        return false;
    }

    public function getRelatedData($id = null)
    {
        $officeModel = Office::find()->all();
        return [
            'officeModel' => $officeModel,
        ];
    }
}