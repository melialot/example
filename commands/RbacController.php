<?php

namespace app\commands;

use yii\console\Controller;
use \Yii;
use app\common\components\rbac\UserRoleRule;
use app\common\components\rbac\UserOfficeRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();

        //разграничения прав по ролям
        $roleRule = new UserRoleRule();
        $auth->add($roleRule);

        $admin = $auth->createRole('admin');
        $admin->ruleName = $roleRule->name;
        $auth->add($admin);

        $support = $auth->createRole('support');
        $support->ruleName = $roleRule->name;
        $auth->add($support);

        //разграничения прав по офисам
        $officeRule = new UserOfficeRule();
        $auth->add($officeRule);

        $ru = $auth->createRole('ru');
        $ru->ruleName = $officeRule->name;
        $auth->add($ru);

        $eu = $auth->createRole('en');
        $eu->ruleName = $officeRule->name;
        $auth->add($eu);
    }
}