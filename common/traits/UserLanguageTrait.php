<?php
namespace app\common\traits;

trait userLanguageTrait {

    public function setUserLanguage()
    {
        if (\Yii::$app->getUser()->can('ru')) {
            \Yii::$app->language = 'ru-RU';
        } else {
            \Yii::$app->language = 'ru-EN';
        }
    }
}