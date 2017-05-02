<?php
/* @var string $title*/
/* @var \yii\data\ActiveDataProvider $data */
use kartik\grid\GridView;
use kartik\helpers\Html;

$module = Yii::$app->controller->module->id;
$controller = Yii::$app->controller->id;
?>
<h2><a href="/<?=$module?>/<?=$controller?>/list"><?=$title?></a></h2>

<?php
$buttons = [
    'delete' => function ($key) {
        return '<a><span class="glyphicon glyphicon-trash delete-sysusers" name="' . $key . '"></span></a>';
    }
];

    echo GridView::widget([
        'dataProvider' => $data,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'username',
            'email',
            'second_name',
            'first_name',
            'middle_name',
            'phone',
            [
                'attribute' => 'office_id',
                'content' => function($model, $key, $index, $column) {
                    if (!empty($model->office_id)) {
                        return $model->office->code;
                    }
                    return '';
                }
            ],
            [
                'attribute' => 'role_id',
                'content' => function($model, $key, $index, $column) {
                    if (!empty($model->role_id)) {
                        return $model->role->role;
                    }
                    return '';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function($action, $model, $key, $index) {
                    $module = Yii::$app->controller->module->id;
                    $controller = Yii::$app->controller->id;
                    return '/' . $module . '/' . $controller. '/' . $action . '/' . $key;
                },
                'buttons' => [
                    'delete' => function ($url, $model) {
                        $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-trash"]);
                        $options = [
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            'data-pjax' => '0',
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'class' => "delete-sysuser"
                        ];
                        return Html::a($icon, $url, $options);
                    }
                ],
                'template' => '{update} {delete}'
            ],
        ]
    ]);
?>

<p class="pull-left">
    <a href="<?='/' . $module . '/' . $controller. '/'?>update/0"><span class="glyphicon glyphicon-plus btn btn-success"></span></a>
</p>
