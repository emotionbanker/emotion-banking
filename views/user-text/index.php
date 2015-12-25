<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\helpers\InputHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserTextSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

if ($type == 'start') {
	$this->title = 'Individuelle Begrüßungstexte';
} else {
	$this->title = 'Individuelle Schlusstexte';
}
$this->params['breadcrumbs'][] = $this->title;
$pageSize = Yii::$app->session->get('pageSize',Yii::$app->params['defaultPageSize']);
?>
<div class="user-text-index">

    <p>
        <?= Html::a('Neuer Benutzertext', ['user-text/create/' . $type], ['class' => 'btn btn-success']) ?>
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

            'ut_id',
			[
				'attribute' => 'p_id',
				'filterType'=>GridView::FILTER_SELECT2,
				'filter' => InputHelper::getDropdownOptions('app\models\Group','p_id', 'bezeichnung', true, true),
				'filterWidgetOptions'=>[
					'pluginOptions'=>['allowClear'=>true],
				],
				'value'=>function ($model, $key, $index, $widget) {
					if (! $model->p_id) return 'Alle';
					$group =  \app\models\Group::findOne($model->p_id);
					return $group ? $group->bezeichnung : $model->p_id;
				},
				'filterInputOptions'=>['placeholder'=>'Bitte wählen Sie'],
				'format'=>'raw'
			],
			[
				'attribute' => 'b_id',
				'filterType'=>GridView::FILTER_SELECT2,
				'filter'=>InputHelper::getDropdownOptions('app\models\Bank','b_id', 'bezeichnung', true, true),
				'filterWidgetOptions'=>[
					'pluginOptions'=>['allowClear'=>true],
				],
				'value'=>function ($model, $key, $index, $widget) {
					if (! $model->b_id) return 'Alle';
					$group =  \app\models\Bank::findOne($model->b_id);
					return $group ? $group->bezeichnung : $model->b_id;
				},
				'filterInputOptions'=>['placeholder'=>'Bitte wählen Sie'],
				'format'=>'raw'
			],
			[
				'attribute' => 'l_id',
				'filterType'=>GridView::FILTER_SELECT2,
				'filter'=>InputHelper::getDropdownOptions('app\models\Language','l_id', 'name', true, true, true),
				'filterWidgetOptions'=>[
					'pluginOptions'=>['allowClear'=>true],
				],
				'value'=>function ($model, $key, $index, $widget) {
					if (! $model->b_id) return 'Default';
					$group =  \app\models\Language::findOne($model->l_id);
					return $group ? $group->name : $model->l_id;
				},
				'filterInputOptions'=>['placeholder'=>'Bitte wählen Sie'],
				'format'=>'raw'
			],
			[
				'attribute' => 't_id',
                'label'=>'Schlusstext',
				'value'=>function ($model, $key, $index, $widget) {
					$group =  \app\models\Text::findOne($model->t_id);
					return $group ? $group->name : $model->t_id;
				},
				'format'=>'raw'
			],
            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update} {delete}'
			],
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title">Texts</h3>',
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
            ['content'=>'']
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
