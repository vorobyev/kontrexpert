<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Organization */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Контрагенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', Url::toRoute(['site/clients', 'kontrid' => $model->id]), ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', Url::toRoute(['site2/delete', 'id' => $model->id]), [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить этого контрагента?',
                'method' => 'post',
            ],
        ]) ?>
        <?= "<br/>"."<br/>".Html::a('Перейти к банковским счетам ->>', Url::toRoute(['site/clients', 'kontrid' => $model->id,'accounts'=>'1'])) ?>
        <?= "<br/>".Html::a('Перейти к договорам ->>', Url::toRoute(['site/clients', 'kontrid' => $model->id,'contracts'=>'1'])) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [        
                'attribute' => 'name',
                'format' => 'ntext',
                'label' => 'Сокр. наименование'
            ],
            [        
                'attribute' => 'fullName',
                'format' => 'ntext',
                'label' => 'Наименование'
            ],
			[        
                'attribute' => 'name1c',
                'format' => 'ntext',
                'label' => 'Наименование для 1С'
            ],
            [        
                'attribute' => 'address',
                'format' => 'ntext',
                'label' => 'Юр. адрес'
            ],
			[        
                'attribute' => 'addressfact',
                'format' => 'ntext',
                'label' => 'Факт. адрес'
            ],
            [        
                'attribute' => 'inn',
                'format' => 'text',
                'label' => 'ИНН'
            ],
            [        
                'attribute' => 'kpp',
                'format' => 'text',
                'label' => 'КПП'
            ],
            [        
                'attribute' => 'ogrn',
                'format' => 'text',
                'label' => 'ОГРН'
            ],
            [        
                'attribute' => 'okpo',
                'format' => 'text',
                'label' => 'ОКПО'
            ],
            [        
                'attribute' => 'rukovod',
                'format' => 'ntext',
                'label' => 'Руководитель'
            ],
            [        
                'attribute' => 'phone',
                'format' => 'text',
                'label' => 'Телефон'
            ],
            [        
                'attribute' => 'email',
                'format' => 'text',
                'label' => 'E-mail'
            ],
            [        
                'attribute' => 'dateReg',
                'format' => 'text',
                'label' => 'Дата регистрации в системе'
            ]
        ],
    ]) ?>

</div>
