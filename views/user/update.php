<?php
/**
 * @var string $title
 * @var \app\modules\system\models\User $model
 * @var array $relatedData
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->registerJsFile(
    'js/user_card.js',
    ['depends'=>'app\assets\AppAsset']
);

$controller = Yii::$app->controller->id;
?>
<h2><a href="/<?=$controller?>/list"><?=$title?></a></h2>

    <?php
    $form = ActiveForm::begin(['layout' => 'horizontal', 'enableClientValidation' => false]);
    $offices = \yii\helpers\ArrayHelper::map($relatedData['officeModel'], 'id', 'code');
    ?>
    <?=Html::hiddenInput('id', $model->id, ['id' => 'user_id'])?>
    <?=$form->field($model, 'is_active')->checkbox()?>
    <?=$form->field($model, 'username')->textInput()?>
    <?=$form->field($model, 'email')->textInput()?>
    <?=$form->field($model, 'second_name')->textInput()?>
    <?=$form->field($model, 'first_name')->textInput()?>
    <?=$form->field($model, 'middle_name')->textInput()?>
    <?=$form->field($model, 'day_of_birth')->widget(\yii\jui\DatePicker::classname(), ['dateFormat' => 'yyyy-MM-dd'])?>
    <?=$form->field($model, 'is_male')->radioList(['0' => \Yii::t('app', 'Female'), '1' => \Yii::t('app', 'Male')])?>
    <?=$form->field($model, 'phone')->textInput()?>
    <?=$form->field($model, 'country')->textInput()?>
    <?=$form->field($model, 'region')->textInput()?>
    <?=$form->field($model, 'city')->textInput()?>
    <?=$form->field($model, 'address')->textInput()?>
    <?=$form->field($model, 'post_index')->textInput()?>
    <?=$form->field($model, 'comment')->textInput()?>
    <?=$form->field($model, 'chat_hash')->textInput()?>
    <?php
    if (!empty($model->created_by)) {
        echo $form->field($model, 'created_at')->textInput(['disabled'=>true]);
        echo $form->field($model->creator, 'fullname')
            ->textInput(['disabled' => true])
            ->label($model->getAttributeLabel('created_by'));
    }
    ?>
    <?php
    if (!empty($model->updated_by)) {
        echo $form->field($model, 'updated_at')->textInput(['disabled'=>true]);
        echo $form->field($model->updater, 'fullname')
            ->textInput(['disabled' => true])
            ->label($model->getAttributeLabel('updated_by'));
    }
    ?>
    <?=
    Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> '
        . \Yii::t('app', 'Save'), ['class' => 'btn btn-primary']);
    ActiveForm::end();
    ?>



