<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\helpers\InputHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Bank */

$this->title = 'Zugangscodes für Bank:' . $model->b_id;
$this->params['bankName'] = $model->b_id;
$this->params['userGroups'] = ArrayHelper::map(\app\models\Group::find()->orderBy('bezeichnung')->all(),'p_id','bezeichnung');
$this->params['breadcrumbs'][] = ['label' => 'Banken', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$pageSize = Yii::$app->session->get('pageSize', Yii::$app->params['defaultPageSize']);
?>
<div class="bank-view">
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
			'label' => 'Code',
			'attribute' => 'code',
			'value'=>function ($model, $key, $index, $widget) {
				return $this->params['bankName'] . str_pad($model->z_p_id, 3, '0', STR_PAD_LEFT) . $model->code;
			},
			'format' => 'raw'
		],
		[
			'label' => 'Benutzergruppe',
			'attribute' => 'z_p_id',
			'filterType'=>GridView::FILTER_SELECT2,
			'filter'=>InputHelper::getDropdownOptions('app\models\Group','p_id', 'bezeichnung'),
			'filterWidgetOptions'=>[
				'pluginOptions'=>['allowClear'=>true],
			],
			'filterInputOptions'=>['placeholder'=>'Bitte wählen Sie'],
			'value'=>function ($model, $key, $index, $widget) {
				return isset($this->params['userGroups'][$model->z_p_id]) ? $this->params['userGroups'][$model->z_p_id] : '' ;
			},
			'format' => 'raw'
		],
		[
			'label' => 'Status',
			'attribute' => 'status',
			'filterType'=>GridView::FILTER_SELECT2,
			'filter'=>[0=> 'noch nicht verwendet', 1 => 'füllt gerade aus/noch nicht komplett ausgefüllt', 2 => 'fertig ausgefüllt'],
			'filterWidgetOptions'=>[
				'pluginOptions'=>['allowClear'=>true],
			],
			'filterInputOptions'=>['placeholder'=>'Bitte wählen Sie'],
			'value'=>function ($model, $key, $index, $widget) {
                if($model->status == 0){
                    return 'noch nicht verwendet';
                }else{
                    if($model->used == 1){
                        return 'fertig ausgefüllt';
                    }else{
                        return 'füllt gerade aus/noch nicht komplett ausgefüllt';
                    }
                }
			},
			'format' => 'raw'
		],
        [
            'label' => 'Filling Date',
            'attribute' => 'fillingDate',
            'format' => 'raw',
            'filter'=>false
        ],
        [
            'label' => 'Duration',
            'attribute' => 'duration',
            'format'=>'raw',
            'filter'=>false
        ],
		[
			'class' => 'yii\grid\ActionColumn',
			'template' => '{delete}',
			'buttons' => [
				'delete' => function($url, $model, $key) {
					return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute('/bank/' . $model->z_b_id . '/delete-code/' . $model->z_id), [
						'title' => Yii::t('yii', 'Löschen'),
						'data-confirm' => Yii::t('yii', 'Wollen Sie dieser Zugangscode ' . $this->params['bankName'] . str_pad($model->z_p_id, 3, '0', STR_PAD_LEFT) . $model->code . ' wirklich löschen?'),
						'data-method' => 'post',
						'data-pjax' => '0',
					]);
				}
			]
		],
	],
        'panel' => [
            'heading'=>'<h3 class="panel-title">Codes</h3>',
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
    ]);
?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
