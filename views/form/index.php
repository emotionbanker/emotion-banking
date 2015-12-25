<?php

use yii\helpers\Html;
//use app\models\search\QuestionSearch;
use kartik\grid\GridView;
use app\helpers\InputHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FormSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fragebögen';
$this->params['breadcrumbs'][] = $this->title;
$pageSize = Yii::$app->session->get('pageSize',Yii::$app->params['defaultPageSize']);
?>
<div class="form-index">
    <p>
        <?= Html::a('Neue fragebögen', ['create'], ['class' => 'btn btn-success']) ?>
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
            'f_id',
			[
				'attribute' => 'f_klasse',
				'filterType'=>GridView::FILTER_SELECT2,
				'filter'=>InputHelper::getDropdownOptions('app\models\Bank','klasse', 'klasse'),
				'filterWidgetOptions'=>[
					'pluginOptions'=>['allowClear'=>true],
				],
				'value'=>function ($model, $key, $index, $widget) {
					 $bank = app\models\Bank::findOne(['klasse' => $model->f_klasse]);
					return $bank ? $bank->klasse : '';
				},
				'filterInputOptions'=>['placeholder'=>'Bitte wählen Sie'],
				'format'=>'raw'
			],
			[
				'attribute' => 'f_p_id',
				'filterType'=>GridView::FILTER_SELECT2,
				'filter'=>InputHelper::getDropdownOptions('app\models\Group','p_id', 'bezeichnung'),
				'filterWidgetOptions'=>[
					'pluginOptions'=>['allowClear'=>true],
				],
				'value'=>function ($model, $key, $index, $widget) {
					$group =  \app\models\Group::findOne($model->f_p_id);
					return $group ? $group->bezeichnung : $model->f_p_id;
				},
				'filterInputOptions'=>['placeholder'=>'Bitte wählen Sie'],
				'format'=>'raw'
			],
			[
				'attribute' => 'reihenfolge',
				'value'=>function ($model, $key, $index, $widget) {
					return mb_substr($model->reihenfolge, 0, 100) . '...';
				},
			],

            [
				'class' => 'yii\grid\ActionColumn',
				'buttons' => [
					'view' => function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
							'title' => Yii::t('yii', 'View'),
							'data-pjax' => '0',
							'target' => '_blank'
						]);
					},
                    'delete' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => Yii::t('yii', 'Löschen'),
                            'data-confirm' => Yii::t('yii', 'Wollen Sie diese Fragebogen #' . $model->f_id . ' wirklich löschen?'),
                            'data-method' => 'post',
                        ]);
                    }
				]
			],
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title">Fragebögen list</h3>',
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
