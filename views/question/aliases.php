<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\QuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fragenalias (Frage '. $question->fr_id. ')';
$this->params['breadcrumbs'][] = [
	'url' => '/question/index',
	'label' => 'Fragen'
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-index">

	<h4>Originaltext: <em><?php echo $question->frage ?></em></h4>

	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
			[
				'label' => 'Alternativtexte',
				'attribute' => 'al_id',
				'value'=>function ($model, $key, $index, $widget) {
					return '<strong>' . $model->a_fr_id . '/' . $model->al_id . ':</strong> <em>' .$model->alias . '</em>';
				},
				'format' => 'raw'
			],
            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{delete}',
				'buttons' => [
					'delete' => function($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute('/question/' . $model->a_fr_id . '/delete-alias/'  . $model->al_id), [
							'title' => Yii::t('yii', 'Löschen'),
							'data-confirm' => Yii::t('yii', 'Sind sie sicher, dass sie diesen Eintrag löschen wollen?'),
							'data-method' => 'post',
							'data-pjax' => '0',
						]);
					}
				]
			],
        ],
    ]);

	$model = new \app\models\QuestionAlias();
	$model->alias = $question->frage;
	$model->a_fr_id = $question->fr_id;
	?>
	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'a_fr_id')->hiddenInput() ?>
	<h4>Neue Alternativtexte:</h4>
	<?= $form->field($model, 'al_id')->textInput() ?>
	<?= $form->field($model, 'alias')->textarea(['rows' => 6]) ?>

	<div class="form-group">
		<?= Html::submitButton(Yii::t('yii','Schaffen') , ['class' => 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
