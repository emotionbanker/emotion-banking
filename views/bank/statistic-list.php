<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Bank */

$this->title = 'Statistik';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-view">
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <?php foreach ($list as $bank): ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $bank->b_id;?>" aria-expanded="false" aria-controls="collapseOne">
                        <?php echo $bank->bezeichnung; ?><br/>
                    </a>
                </h4>
            </div>
            <div id="collapse<?php echo $bank->b_id;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <h3><?php echo $bank->bezeichnung?></h3>
                    <?php

                    $searchModel = new \app\models\search\Statistic($bank->b_id);
                    $dataProvider = $searchModel->search();
                    ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            [
                                'label' => 'Personengruppe',
                                'attribute' => 'bezeichnung',
                                'width' => '20%'
                            ],
                            [
                                'label' => 'Anz. Codes',
                                'attribute' => 'tic_count',
                                'pageSummary' => true,
                                'width' => '20%'
                            ],
                            [
                                'label' => 'Komplett',
                                'attribute' => 'bused',
                                'pageSummary' => true,
                                'width' => '20%'
                            ],
                            [
                                'label' => 'nur 50 oder mehr',
                                'attribute' => 'bused50',
                                'pageSummary' => true,
                                'width' => '20%'
                            ],
                            [
                                'label' => 'Gesamt in Auswertung',
                                'attribute' => 'busedtot',
                                'pageSummary' => true,
                                'width' => '20%'
                            ],
                        ],
                        'showPageSummary' => true
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
