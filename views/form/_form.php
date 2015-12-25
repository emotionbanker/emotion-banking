<?php

use app\assets\MultipleSelectAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\multiselect\MultiSelect;
use kartik\grid\GridView;
use app\models\search\QuestionSearch;
use app\assets\QuestionAddAsset;
QuestionAddAsset::register($this);
MultipleSelectAsset::register($this);


$searchModel = new QuestionSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

/* @var $this yii\web\View */
/* @var $model app\models\Form */
/* @var $form yii\widgets\ActiveForm */
$classes = ['' => 'Bitte wählen Sie'] + ArrayHelper::map(app\models\Bank::find()->orderBy('klasse')->all(),'klasse', 'klasse');
//$banks = ['' => 'Bitte wählen Sie'] + ArrayHelper::map(app\models\Bank::find()->orderBy('klasse')->all(),'bezeichnung', 'klasse');
$groups = ['' => 'Bitte wählen Sie'] + ArrayHelper::map(app\models\Group::find()->orderBy('bezeichnung')->all(),'p_id', 'bezeichnung');
$pageSize = Yii::$app->session->get('pageSize',Yii::$app->params['defaultPageSize']);


?>
<div class="form-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--<?= $form->field($model, 'f_klasse')->dropDownList($classes) ?>-->

    <div class="form-group <?php if(isset($model->errors['f_klasse'])) : ?> has-error <?php endif;?>">
        <label for="">Klasse</label>
        <?= MultiSelect::widget([
            'data' => $classes,
            'name' => 'Form[f_klasse]',
            'clientOptions' => [
                'maxHeight' => 300,
                'enableCaseInsensitiveFiltering' => true,
                'buttonWidth' => '400px'
            ],
            'options' => [
                'multiple' => false,
                'nonSelectedValue' => 0,
                'onchange' => $model->isNewRecord ? '' : 'this.form.submit();',
            ],
            'value' => $model->f_klasse
        ]); ?>
        <div class="help-block"><?php if(isset($model->errors['f_klasse'])) echo $model->errors['f_klasse'][0]; ?> </div>
    </div>

    <?= $form->field($model, 'f_p_id')->dropDownList($groups) ?>

    <?php echo Html::button('Fragenliste einblenden', ['id'=>'addQuestion', 'data'=>['toggle'=>"modal", 'target'=>'#myModal'], 'class'=>'btn btn-primary']) ?>
    <div class="help-block"></div>

    <?= $form->field($model, 'reihenfolge')->textarea(['rows' => 20]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Anlegen' : 'Aktualisieren', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= $model->isNewRecord ? '' : Html::button('Anzeigen', ['class' => 'btn btn-success', 'onclick' => 'window.open("' . Url::toRoute('/form/view?id=' . $model->f_id ). '"); return false;']) ?>
        <?= $model->isNewRecord ? '' : Html::button('URL generieren', ['id'=>'generateURL', 'data'=>['toggle'=>"modal", 'target'=>'#selectBank'], 'class'=>'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="width:80%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">Modal title</h4>
				</div>
				<div class="modal-body">
					<?php \yii\widgets\Pjax::begin(); ?>
					<?= GridView::widget([
						'dataProvider' => $dataProvider,
						'filterModel' => $searchModel,
                        'pager'=>array(
                            //'class'=>'CLinkPager',
                            //'pageSize' => 50,
                            'firstPageLabel'=>'Erste',
                            'lastPageLabel'=>'Letzte',
                            //'header'=>'',

                        ),
                        'columns' => [
							[
								'label' => 'Neu',
								'attribute' => 'fr_add',
								'value'=>function ($model) {
									return Html::button('Neu', ['data'=>['question'=>$model->fr_id], 'class'=>'btn btn-warning question-add', 'style'=>'font-family: Courier']);
								},
								'format' => 'raw'
							],
                            [
                                'label' => 'ID',
                                'attribute' => 'fr_id',
                                'value'=>function ($model, $key, $index, $widget) {
                                        return $model->fr_id;
                                    },
                                'format' => 'raw'
                            ],
							[
								'attribute' => 'frage',
								'value'=>function ($model, $key, $index, $widget) {
									return $model->frage . '<br/><em>' . $model->antworten .'</em>';
								},
								'format' => 'raw'
							],
							[
								'label' => 'Art',
								'attribute' => 'display',
								'filterType'=>GridView::FILTER_SELECT2,
								'filter'=> ['' => 'Alle Arten'] + app\models\Question::$types,
								'filterWidgetOptions'=>[
									'pluginOptions'=>[
										'allowClear'=>true
									],
								],
								'filterInputOptions'=>['placeholder'=>''],
								'format'=>'raw'
							],
						],
                        'panel' => [
                            'heading'=>'<h3 class="panel-title">die Fragen</h3>',
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
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" id="reinfolge-save" class="btn btn-primary" data-dismiss="modal">Save changes</button>
				</div>
			</div>
		</div>
	</div>

    <div class="modal modal-lg fade" style="width:100%" id="selectBank" tabindex="-2" role="dialog" aria-labelledby="selectBankLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:900px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Select Bank Name</h4>
                </div>
                <div class="modal-body">
                    <?php
                        if($model->f_klasse){
                            $banken = ArrayHelper::map(app\models\Bank::find()->where(['klasse' => $model->f_klasse])->orderBy('bezeichnung')->all(),'b_id', 'bezeichnung');
                            echo $form->field($model, 'bank')->dropDownList($banken);
                        }
                    ?>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="hidden" id="questionnaireURL" value="<?= Url::toRoute('/site/questionnaire/bezeichnung/' . $model->f_p_id. '/default') ?>">
                    <?= Html::button('URL generieren', ['class' => 'btn btn-info', 'id' => 'openURL']); ?>
                </div>
            </div>
        </div>
    </div>

    <style>
        label {
            display: block;
        }
        .dropdown-menu > li > a {
            padding: 8px 30px;
        }
    </style>

</div>
