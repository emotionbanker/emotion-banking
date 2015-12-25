<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Group */

$this->title = 'Neue benutzergruppe erstellen';
$this->params['breadcrumbs'][] = ['label' => 'Benutzergruppen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
