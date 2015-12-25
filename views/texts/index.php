<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TextSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Texts';
$this->params['breadcrumbs'][] = $this->title;
$pageSize = Yii::$app->session->get('pageSize',Yii::$app->params['defaultPageSize']);
?>
<div class="text-index">
    <p>
        <?= Html::a('Neue Text', ['create'], ['class' => 'btn btn-success']) ?>
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
            'name',
            'text:raw',

            ['class' => 'yii\grid\ActionColumn'],
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
