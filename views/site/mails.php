<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\Alert;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\grid\GridView;
use skeeks\yii2\ckeditor\CKEditorWidget;
use skeeks\yii2\ckeditor\CKEditorPresets;


$this->title = 'Рассылка писем';

$this->params['breadcrumbs'][] = ['label' => 'Контрагенты', 'url' => ['site2/index']];
$this->params['breadcrumbs'][] = $this->title;

    Modal::begin([
            'header' => "<h2 align='center'>Отправка писем</h2>",
            'options'=>['id'=>'modal-letters'],
            'size'=>'modal-lg',
            'clientOptions'=>[
                'backdrop'=>'static',
                'show'=>false,
                'keyboard'=>false
            ],
        ]);
        echo "<br/><br/><br/><br/><br/><div align='center'>Идет отправка писем выбранным контрагентам...</div><div id='letter_kol' align='center'></div><br/><h2 align='center'><img src='file-loader.gif'></h2><br/><br/><br/><br/><br/><br/>";
    Modal::end();


echo "<h3>Шаг 1: Выберите контрагентов для рассылки</h3><hr/>";
echo GridView::widget([
        'options'=>[
            'style'=>'width:60%; margin:0 auto;'
        ],
        'rowOptions' => function ($model, $key, $index, $grid)
            {
                  return ['style' => 'font-size:9pt;'];
            },
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout'=>'{pager}{errors}{items}',
        'emptyText'=>"Контрагенты не найдены...",
		
        'columns' => [
					[
				'class' => 'yii\grid\CheckboxColumn',
				'contentOptions' => ['class' => 'kv-row-select'],
				'headerOptions' => ['class' => 'kv-all-select'],
			],
            [        
                'attribute' => 'name',
                'format' => 'text',
                'label' => 'Сокр. наименование'
            ],
            [ 
                'attribute' => 'inn',
                'format' => 'text',
                'label' => 'ИНН'
            ],
            [ 
                'attribute' => 'email',
                'format' => 'text',
                'label' => 'Адрес почты'
            ]


        ],
    ]); 


echo "<h3>Шаг 2: Введите основные реквизиты рассылки</h3><hr/>";




$form = ActiveForm::begin();

echo $form->field($model, 'subj')->input(['type'=>'input'])->label('Тема сообщения') ;

echo $form->field($model, 'mess')->widget(CKEditorWidget::className(), [
        'options' => ['rows' => 6],
        'preset' => CKEditorPresets::EXTRA
    ])->label('Текст сообщения') ;


	
	
 

// echo $form->field($model, 'imageFile')->fileInput();
// echo Html::submitButton();
// ActiveForm::end();

echo "<h3>Шаг 3: Прикрепите к сообщению файлы (если необходимо)</h3><hr/>";

echo $form->field($model, 'imageFile')->widget(InputFile::className(), [
	'buttonName'      => 'Выбрать файлы',
    'language'      => 'ru',
    'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
    'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
    'options'       => ['class' => 'form-control'],
    'buttonOptions' => ['class' => 'btn btn-default'],
    'multiple'      => true
// возможность выбора нескольких файлов
])->label("Прикрепленные файлы");


ActiveForm::end();

echo "<hr/>";

echo Html::button('Отправить письма контрагентам', ['class' => 'btn btn-primary','onclick'=>'sendLaters();']);

$js = new JsExpression("$( document ).ready(function() {
    	for (var i in CKEDITOR.instances) {
		htmlText = CKEDITOR.instances[i].setData('<br/><br/><br/><hr/>С уважением, директор ООО \"Эксперт\"</br>Марина Николаевна Лапкина</br></br>Тел./ф.: (4722) 26-13-62, 42-13-62</br>г. Белгород, пр. Б. Хмельницкого, д. 133В, 4 этаж, оф. 401</br>e-mail:ekspert-bel@yandex.ru</br>www.ekspert-bel.ru');
	   }
});");
$this->registerJs($js);


/*echo Alert::widget([
                'options' => [
                        'class' => 'alert-info'
                     ],
                    'body' => 'Допустимый предел для отправки писем с yandex.mail - 500 шт. Иначе сервис почты будет считать рассылку спамом и возможность отправки почты будет заблокирована на 24 часа. При попытке отправить письмо во время блокировки, время этой блокировки обнуляется снова на 24 часа.',
                    'closeButton'=>false
                ]);*/