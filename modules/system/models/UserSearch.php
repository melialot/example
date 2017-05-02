<?php
namespace app\modules\system\models;


use app\common\models\BasicSearchModel;
use yii\helpers\ArrayHelper;

class UserSearch extends BasicSearchModel
{

    public $modelClass = 'app\modules\system\models\User';

}