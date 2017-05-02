<?php

namespace app\modules\system;

class SystemModule extends \yii\base\Module
{
    public function init()
    {
        parent::init();

        \Yii::configure($this, require (__DIR__ . '/config/config.php'));
    }

}