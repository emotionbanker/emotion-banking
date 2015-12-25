<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\LanguageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sprachen';
$this->params['breadcrumbs'][] = $this->title;
$pageSize = Yii::$app->session->get('pageSize',Yii::$app->params['defaultPageSize']);
?>
<div class="language-index">
    <p>
        <?= Html::a('Neue Sprache', ['create'], ['class' => 'btn btn-success']) ?>
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
            'l_id',
            'short',
            'name',
            [
                'label' => 'Label',
                'attribute' => 'label',
                'value'=>function ($model, $key, $index, $widget) {
                        if($model->label == ''){
                            return "Default";
                        }else{
                            return $model->label;
                        }
                    },
                'format' => 'raw'
            ],
            [
                'label' => 'Message',
                'attribute' => 'message',
                'value'=>function ($model, $key, $index, $widget) {
                        if($model->message == ''){
                            return "Default";
                        }else{
                            return $model->message;
                        }
                    },
                'format' => 'raw'
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{translations} {view} {update} {delete}',
                'buttons' => [
                    'translations' => function($url, $model, $key) {
                            return Html::a('<i class="fa fa-barcode"></i>', Url::toRoute('/translation/index?TranslationSearch[t_l_id]=' . $model->l_id), [
                                'title' => Yii::t('yii', 'Übersetzungen'), 'data-pjax' => 0,
                            ]);
                        }
                ]
            ],
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title">Sprachen</h3>',
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
