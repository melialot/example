<?php

namespace app\common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\system\models\User as SystemUser;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class BasicSearchModel extends Model
{
    public $id;
    public $modelClass = '';

    public function rules()
    {
        return [
            [['id'], 'integer'],
        ];
    }

    public function search()
    {
        $modelClass = $this->modelClass;
        $query = $modelClass::find();

        return $query;
    }

}