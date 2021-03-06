<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Question */

$this->title = $model->tr_id;
$this->params['breadcrumbs'][] = ['label' => 'Übersetzung', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-view">

    <p>
        <?= Html::a('Aktualisieren', ['update', 'id' => $model->tr_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Löschen', ['delete', 'id' => $model->tr_id], [
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
            'tr_id',
            'frage:ntext',
            'antworten:ntext',
        ],
    ]) ?>

</div>
