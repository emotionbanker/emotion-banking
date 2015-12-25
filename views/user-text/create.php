<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UserText */

$this->title = 'Neuer Benutzertext';
$this->params['breadcrumbs'][] = ['label' => 'User Texts', 'url' => ['user-text/index/' . $type]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-text-create">

    <?= $this->render('_form', [
        'model' => $model,
		'type' => $type
    ]) ?>

</div>
