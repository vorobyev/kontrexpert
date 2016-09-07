<?php


use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Tabs;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Контрагенты' ;

echo "<h3>".$this->title."</h3>";


echo GridView::widget([
    'dataProvider' => $provider,
    'layout'=>'{pager}{errors}{items}',
    'emptyText'=>"Контрагенты не найдены...",
    'options'=> [
        'style'=>'max-height:500px; overflow-y:scroll;'
    ],
    'columns' => [
        [        
            'attribute' => 'active',
            'format' => 'raw',
            'label' => '',
            'value' => function($data){
                $content=Html::a('Выбрать', Url::to(["site/clients",'kontrid'=>$data->id],true),['class'=>'btn btn-info']);
                return $content;
            }
        ],
        [        
            'attribute' => 'name',
            'format' => 'text',
            'label' => 'Сокр. наименование'
        ]
  
      

        
    ],
]);

?>

        

        
    
