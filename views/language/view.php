<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Language */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sprachen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="language-view">

    <p>
        <?= Html::a('Ändern', ['update', 'id' => $model->l_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Löschen', ['delete', 'id' => $model->l_id], [
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
            'l_id',
            'short',
            'name',
            'label',
            'message'
        ],
    ]) ?>

</div>
