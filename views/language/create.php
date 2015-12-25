<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Language */

$this->title = 'Neue Sprache';
$this->params['breadcrumbs'][] = ['label' => 'Sprachen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="language-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
