<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\models\HistoryContracts;

/* @var $this yii\web\View */
/* @var $model app\models\Organization */

$this->title = "№".$model->numberContract." от ".$model->dateContract; 
$this->params['breadcrumbs'][] = ['label' => 'Контрагенты', 'url' => Url::toRoute(['site2/index']), ['class' => 'btn btn-primary']];
$this->params['breadcrumbs'][] = ['label' => $model->client->name, 'url' => Url::toRoute(['site2/view', 'id' => $model->client->id]), ['class' => 'btn btn-primary']];
$this->params['breadcrumbs'][] = ['label' => "Договоры", 'url' => Url::toRoute(['site/clients', 'kontrid' => $model->client->id,'contracts'=>'1']), ['class' => 'btn btn-primary']];
$this->params['breadcrumbs'][] = $this->title;

$summ = "";
$volume = "";
$modelHistory = HistoryContracts::find()->where(['idContr'=>$model->id])->orderBy('id DESC')->one();
if ($modelHistory == NULL) {
    $summ = "";
    $volume = "";
} else {
    $summ = $modelHistory->summ;
    $volume = $modelHistory->volumeJob;   
}


?>
<div class="organization-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', Url::toRoute(['site/clients', 'kontrid' => $model->idKontr, 'contracts'=>'1','contrid'=>$model->id]), ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', Url::toRoute(['site/deletecontr', 'id' => $model->id,'kontrid' => $model->idKontr]), [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить этот договор?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [        
                'attribute' => 'dateContract',
                'format' => 'datetime',
                'label' => 'Дата договора'
            ],
            [        
                'attribute' => 'numberContract',
                'format' => 'ntext',
                'label' => 'Номер договора'
            ],
			[        
                'attribute' => 'subj',
                'format' => 'ntext',
                'label' => 'Предмет договора'
            ],
            [        
                    'format' => 'raw',
                    'label' => 'Объем выполняемых работ',
                    'value' => $volume
            ],
            [        
                    'format' => 'raw',
                    'label' => 'Сумма договора (руб)',
                    'value' => $summ
            ],
            [        
                'attribute' => 'comments',
                'format' => 'ntext',
                'label' => 'Комментарий'
            ]
        ],
    ]) ?>

</div>
