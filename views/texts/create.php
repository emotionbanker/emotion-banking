<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Text */

$this->title = 'Neue Text';
$this->params['breadcrumbs'][] = ['label' => 'Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-create">

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
