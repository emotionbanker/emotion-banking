<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\GroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Groups';
$this->params['breadcrumbs'][] = $this->title;
$pageSize = Yii::$app->session->get('pageSize',Yii::$app->params['defaultPageSize']);
?>
<div class="group-index">
    <p>
        <?= Html::a('Neue Gruppe', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \yii\widgets\Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager'=>array(
            'firstPageLabel'=>'Erste',
            'lastPageLabel'=>'Letzte',
        ),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'p_id',
            'bezeichnung',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'update' => function($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('yii', 'Bearbeiten'),
                                'data-confirm' => Yii::t('yii', 'Wollen Sie diese Benutzergruppe ' . $model->p_id . ' - ' . $model->bezeichnung . ' bearbeiten?')
                            ]);
                        },
                    'delete' => function($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('yii', 'Löschen'),
                                'data-confirm' => Yii::t('yii', 'Wollen Sie diese Benutzergruppe ' . $model->p_id . ' - ' . $model->bezeichnung . ' wirklich löschen?'),
                                'data-method' => 'post',
                            ]);
                        }
                ]
            ],
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title">Benutzergruppen</h3>',
            'type'=>'default',
            'before'=> '',
            'after'=>'<div class="pull-right">Items per page ' . Html::dropDownList(
                    'pageSize',
                    $pageSize,
                    Yii::$app->params['pageSizeOptions'],
                    array('class'=>'change-pageSize', 'onchange' => '$.pjax.reload({container: "#w1", data:{ pageSize: $(this).val() }});')
                ).'</div><div class="clearfix"></div>',
            'footer'=>''
        ],
        'toolbar' => [
            ['content'=>''
            ]
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
