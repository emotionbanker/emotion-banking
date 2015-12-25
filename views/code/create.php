<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Code */

$this->title = 'Neue zugangscodes erzeugen';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="code-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
