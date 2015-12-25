<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use app\helpers\InputHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\QuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Übersetzungen';
$this->params['breadcrumbs'][] = $this->title;
$pageSize = Yii::$app->session->get('pageSize',Yii::$app->params['defaultPageSize']);
?>
<div class="question-index">
    <p>
        <?= Html::a('Neue Übersetzung', ['translation/create'], ['class' => 'btn btn-success']) ?>
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
            [
                'label' => 'ID',
                'attribute' => 'tr_id',
                'format' => 'raw'
            ],
            [
                'label' => 'Sprache',
                'attribute' => 't_l_id',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>InputHelper::getDropdownOptions('app\models\Language','l_id', 'name'),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'value'=>function ($model, $key, $index, $widget) {
                        $lang =  \app\models\Language::findOne($model->t_l_id);
                        return $lang ? $lang->name : $model->t_l_id;
                    },
                'filterInputOptions'=>['placeholder'=>'Bitte wählen Sie'],
                'format'=>'raw'
            ],
            [
                'label' => 'Frage ID',
                'attribute' => 't_fr_id',
                'format' => 'raw'
            ],
            [
                'label' => 'Frage',
                'attribute' => 'questionOriginal',
                'format'=>'raw'
            ],
            [
                'label' => 'Übersetzung',
                'attribute' => 'frage',
                'format' => 'raw'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>',Url::toRoute('/translation/update?id=' . $model->tr_id), [
                                'title' => Yii::t('yii', 'Bearbiten'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                        },
                    'delete' => function($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute('/translation/delete?id=' . $model->tr_id), [
                                'title' => Yii::t('yii', 'Löschen'),
                                'data-confirm' => Yii::t('yii', 'Sind sie sicher, dass sie diesen Eintrag löschen wollen?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                            ]);
                        }
                ]
            ]
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
