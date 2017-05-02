<?php

namespace app\models;

use app\common\models\BasicSearchModel;
use yii\helpers\ArrayHelper;

class UserSearch extends BasicSearchModel
{
    public $modelClass = 'app\models\User';
}