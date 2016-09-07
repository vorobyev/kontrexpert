<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Organization */

$this->title = $model->kontrAccount ;
$this->params['breadcrumbs'][] = ['label' => 'Контрагенты', 'url' => Url::toRoute(['site2/index']), ['class' => 'btn btn-primary']];
$this->params['breadcrumbs'][] = ['label' => $model->client->name, 'url' => Url::toRoute(['site2/view', 'id' => $model->client->id]), ['class' => 'btn btn-primary']];
$this->params['breadcrumbs'][] = ['label' => "Счета", 'url' => Url::toRoute(['site/clients', 'kontrid' => $model->client->id,'accounts'=>'1']), ['class' => 'btn btn-primary']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', Url::toRoute(['site/clients', 'kontrid' => $model->idKontr, 'accounts'=>'1','accid'=>$model->id]), ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', Url::toRoute(['site/deleteacc', 'id' => $model->id,'kontrid' => $model->idKontr]), [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить этот счет?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [        
                'attribute' => 'kontrAccount',
                'format' => 'ntext',
                'label' => 'Расч. счет'
            ],
            [        
                'attribute' => 'bankName',
                'format' => 'ntext',
                'label' => 'Наименование банка'
            ],
            [        
                'attribute' => 'bik',
                'format' => 'ntext',
                'label' => 'БИК'
            ],
            [        
                'attribute' => 'korrAccount',
                'format' => 'text',
                'label' => 'Корр. счет'
            ],
            [        
                'attribute' => 'city',
                'format' => 'text',
                'label' => 'Город'
            ],
            [        
                'attribute' => 'address',
                'format' => 'text',
                'label' => 'Адрес банка'
            ]
        ],
    ]) ?>

</div>
