<?php
/* @var string $title*/
/* @var \yii\data\ActiveDataProvider $data */
use kartik\grid\GridView;
use kartik\helpers\Html;

$controller = Yii::$app->controller->id;
?>
<h2><a href="/<?=$controller?>/list"><?=$title?></a></h2>

<?php
    $controller = Yii::$app->controller->id;

    echo GridView::widget([
        'dataProvider' => $data,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email',
            'second_name',
            'first_name',
            'middle_name',
            'day_of_birth',
            'phone',
            'city',
            'address',
            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function($action, $model, $key, $index) {
                    $controller = Yii::$app->controller->id;
                    return '/' . $controller. '/' . $action . '/' . $key;
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
                            'class' => "delete-user"
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
    <a href="<?='/' . $controller. '/'?>update/0"><span class="glyphicon glyphicon-plus btn btn-success"></span></a>
</p>

