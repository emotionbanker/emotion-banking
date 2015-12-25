<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserText */

$this->title = $model->ut_id;
$this->params['breadcrumbs'][] = ['label' => 'User Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-text-view">

    <p>
        <?= Html::a('Aktualisieren', ['update', 'id' => $model->ut_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Löschen', ['delete', 'id' => $model->ut_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Sind sie sicher, dass sie diesen Eintrag löschen wollen?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ut_id',
            'p_id',
            'b_id',
            'l_id',
            't_id',
            'isStart',
            'isEnd',
        ],
    ]) ?>

</div>
