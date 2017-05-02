<?php
namespace app\common\traits;

trait OfficeBehaviorTrait {
    public function getOfficeBehavior()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'office_id',
                ],
                'value' => function ($event) {
                    return \app\modules\system\models\User::getCurrentUserOfficeId();
                },
            ]
        ]);
    }
}