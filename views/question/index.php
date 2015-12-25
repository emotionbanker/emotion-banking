<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\QuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fragen';
$this->params['breadcrumbs'][] = $this->title;
$pageSize = Yii::$app->session->get('pageSize',Yii::$app->params['defaultPageSize']);
?>
<div class="question-index">
    <p>
        <?= Html::a('Neue frage', ['create'], ['class' => 'btn btn-success']) ?>
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
				'attribute' => 'fr_id',
				'value'=>function ($model, $key, $index, $widget) {
					$count = $model->getAliasesCount();
					$additional = '';
					if ($count) {
						$additional = '<small>(+' . $count . ')</small>';
					}
					return $model->fr_id . ' ' . $additional;
				},
				'format' => 'raw'
			],
            'frage:ntext',
            [
				'label' => 'Art',
				'attribute' => 'display',
				'filterType'=>GridView::FILTER_SELECT2,
				'filter'=>['' => 'Alle Arten'] + app\models\Question::$types,
				'filterWidgetOptions'=>[
					'pluginOptions'=>['allowClear'=>true],
				],
				'filterInputOptions'=>['placeholder'=>''],
				'format'=>'raw'
			],
            'suche:ntext',
            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{alias} {update} {delete}',
				'buttons' => [
					'alias' => function($url, $model, $key) {
						return Html::a('<i class="fa fa-files-o"></i>', Url::toRoute('/question/' . $model->fr_id . '/aliases'), [
							'title' => Yii::t('yii', 'Alternativen'),
						]);
					},
                    'update' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => Yii::t('yii', 'Bearbeiten'),
                            'data-confirm' => Yii::t('yii', 'Wollen Sie diese Frage #' . $model->fr_id . ' - ' . $model->frage . ' bearbeiten?')
                        ]);
                    },
                    'delete' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => Yii::t('yii', 'Löschen'),
                            'data-confirm' => Yii::t('yii', 'Wollen Sie diese Frage #' . $model->fr_id . ' - ' . $model->frage . ' wirklich löschen?'),
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
