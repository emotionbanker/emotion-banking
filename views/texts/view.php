<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Text */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-view">


    <p>
        <?= Html::a('Aktualisieren', ['update', 'id' => $model->t_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Löschen', ['delete', 'id' => $model->t_id], [
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
            't_id',
            'name',
            'text:raw',
        ],
    ]) ?>

</div>
