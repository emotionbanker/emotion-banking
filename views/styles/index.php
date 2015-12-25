<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BankSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Styles';
$this->params['breadcrumbs'][] = $this->title;
$pageSize = Yii::$app->session->get('pageSize',Yii::$app->params['defaultPageSize']);
?>
<div class="bank-index">
    <h4>
        Der Standard-Style ist: <strong><?=  $defaultStyle ?></strong> &nbsp;&nbsp;&nbsp;<?= Html::a('Standard-Style ändern', ['default'], ['class' => 'btn btn-primary']) ?>
        <p style="float: right;">
            <?= Html::a('Neue Style', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <div class="clearfix"></div>
    </h4>
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
                'attribute' => 's_id',
                'format' => 'raw'
            ],
            [
                'label' => 'Bankenname',
                'attribute' => 'bankName',
                'format'=>'raw'
            ],
            [
                'label' => 'Gruppenname',
                'attribute' => 'groupName',
                'format' => 'raw'
            ],
            [
                'label' => 'Style',
                'attribute' => 'style',
                'format' => 'raw'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ]
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title">Styles</h3>',
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
