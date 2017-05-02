<?php
/**
 * @var string $title
 * @var \app\modules\system\models\User $model
 * @var array $relatedData
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$module = Yii::$app->controller->module->id;
$controller = Yii::$app->controller->id;
?>
<h2><a href="/<?=$module?>/<?=$controller?>/list"><?=$title?></a></h2>

<div>
    <?php
    $form = ActiveForm::begin(['layout' => 'horizontal', 'enableClientValidation' => false]);
    ?>
    <?=$form->field($model, 'username')->textInput()?>
    <?=$form->field($model, 'email')->textInput()?>
    <?=$form->field($model, 'second_name')->textInput()?>
    <?=$form->field($model, 'first_name')->textInput()?>
    <?=$form->field($model, 'middle_name')->textInput()?>
    <?=$form->field($model, 'phone')->textInput()?>
    <?=$form->field($model, 'office_id')->dropDownList($relatedData['offices'], [])?>
    <?=$form->field($model, 'role_id')->dropDownList($relatedData['roles'], [])?>
    <?=
    Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> '
        . \Yii::t('app', 'Save'), ['class' => 'btn btn-primary']);
    ActiveForm::end();
    ?>
</div>