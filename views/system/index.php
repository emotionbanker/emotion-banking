<?php
/* @var $this yii\web\View */
$this->title = 'Statistik';
?>

<h4>Fragen</h4>
<?php echo \app\models\Question::find()->count() ?> Fragen insgesamt, davon <br/>
<?php echo \app\models\Question::find()->andFilterWhere(['display' => 'text'])->count() ?> Textfragen<br/>
<?php echo \app\models\Question::find()->andFilterWhere(['display' => 'radio'])->count() ?> Auswahlfragen<br/>
<?php echo \app\models\Question::find()->andFilterWhere(['display' => 'multi'])->count() ?> Mehrfachauswahlfragen<br/>

<h4>Banken</h4>


<?php echo \app\models\Bank::find()->count() ?> Banken insgesamt, in<br/>
<?php echo \app\models\Bank::find()->distinct('klasse')->count() ?> verschiedenen Bankenklassen<br/>

<h4>Benutzergruppen</h4>


<?php echo \app\models\Group::find()->count() ?> Benutzergruppen insgesamt<br/>

<h4>Zugangscodes</h4>
<?php echo \app\models\Code::find()->count() ?> Verschiedene Zugangscodes, davon<br/>
<?php echo \app\models\Code::find()->andFilterWhere(['used'=>1])->count() ?> bereits verwendet<br/>