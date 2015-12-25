<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BankSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Banken';
$this->params['breadcrumbs'][] = $this->title;
$pageSize = Yii::$app->session->get('pageSize',Yii::$app->params['defaultPageSize']);
?>
<div class="bank-index">
    <p>
        <?= Html::a('Neue Banken', ['create'], ['class' => 'btn btn-success']) ?>
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
            'b_id',
            'bezeichnung',
            'klasse',

            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{codes} {update} {delete} {lock} {statistic}',
				'buttons' => [
					'codes' => function($url, $model, $key) {
						return Html::a('<i class="fa fa-barcode"></i>', Url::toRoute('/bank/' . $model->b_id . '/codes'), [
							'title' => Yii::t('yii', 'Zugangscodes'), 'data-pjax' => 0,
                        ]);
					},
                    'update' => function($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('yii', 'Bearbeiten'),
                                'data-confirm' => Yii::t('yii', 'Wollen Sie diese Bank ' . $model->b_id . ' - ' . $model->bezeichnung . ' bearbeiten?')
                            ]);
                        },
                    'delete' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => Yii::t('yii', 'Löschen'),
                            'data-confirm' => Yii::t('yii', 'Wollen Sie diese Bank ' . $model->b_id . ' - ' . $model->bezeichnung . ' wirklich löschen?'),
                            'data-method' => 'post',
                        ]);
                    },
					'lock' => function($url, $model, $key) {
						if (! $model->isLocked()) {
							$icon = 'fa-lock';
							$text = 'sperren';
							$color = 'red';
						} else {
							$icon = 'fa-unlock';
							$text = 'sperren';
							$color = 'green';
						}
						return Html::a('<i style="color:'.$color.'" class="fa ' . $icon . '"></i>', Url::toRoute('/bank/' . $model->b_id . '/lock'), [
							'title' => Yii::t('yii', $text),
						]);
					},
					'statistic' => function($url, $model, $key) {
						return Html::a('<i class="fa fa-area-chart"></i>', Url::toRoute('/bank/' . $model->b_id . '/statistic'), [
							'title' => Yii::t('yii', 'Statistik'),
						]);
					}
				]
			],
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title">Banken</h3>',
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
        ]
    ]);
    ?>
    <?php \yii\widgets\Pjax::end(); ?>

</div>
