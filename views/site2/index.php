<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use app\models\TimeHelper;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OrganizationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Контрагенты';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="organization-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать контрагента', Url::to(['site/clients','new'=>'1']), ['class' => 'btn btn-success']) ?>
        <?= Html::a('Синхронизировать с 1С', "", ['class' => 'btn btn-info','onclick'=>'$("#modal-users").modal("show"); sync1c(); return false;']) ?>
        <?= Html::button('Вывести реестр в Excel', ['class' => 'btn btn-primary','onclick'=>'$("#modal-reestr").modal("show")']) ?>
		<?= Html::a('Рассылка писем', Url::to(['site/mails']), ['class' => 'btn btn-warning']) ?>
    </p>
    
    <?php
        Modal::begin([
                    'header' => "<h2 align='center'>Вывод реестра</h2>",
                    'options'=>['id'=>'modal-print-wait'],
                    'size'=>'modal-sm',
                    'clientOptions'=>[
                        'backdrop'=>'static',
                        'show'=>false,
                        'keyboard'=>false
                    ],
                ]);
                echo "<br/><br/><br/><br/><br/><div align='center'>Подождите, идет формирование документа</div><br/><h2 align='center'><img src='file-loader.gif'></h2><br/><br/><br/><br/><br/><br/>";
        Modal::end();
    
         Modal::begin([
            'header' => "<h2 align='center'>Вывод реестра договоров контрагентов</h2>",
            'options'=>['id'=>'modal-reestr'],
            'size'=>'modal-lg',
            'clientOptions'=>[
                'show'=>false
            ],
        ]);
        echo "<h3 align=center>Выберите поля, которые будут отображены в реестре:</h3>";
		echo '<h4 align="center">Период: с '.DatePicker::widget([
    'language' => 'ru',
    'dateFormat' => 'yyyy-MM-dd',
    'options'=>[
        'class'=>'inputMy form-control',
        'style'=>'width:120px;',
        'readonly'=>'readonly',
		'id'=>'datepick1'
    ]               
])." по ".DatePicker::widget([
    'language' => 'ru',
    'dateFormat' => 'yyyy-MM-dd',
    'options'=>[
        'class'=>'inputMy form-control',
        'style'=>'width:120px;',
        'readonly'=>'readonly',
		'id'=>'datepick2'
    ]               
])."</h4><br/>";
        echo "<div style='margin-left:300px;'>";
		
         echo Html::checkbox('contracts',true,['disabled'=>true])." Договор<br/>";
         echo Html::checkbox('kontragent',true,['disabled'=>true])." Контрагент<br/>";
		 echo Html::checkbox('subj',true)." Предмет договора<br/>";
         echo Html::checkbox('inn',true)." ИНН<br/>";
         echo Html::checkbox('kpp',false)." КПП<br/>";
         echo Html::checkbox('ogrn',false)." ОГРН<br/>";
         echo Html::checkbox('okpo',false)." ОКПО<br/>";
         echo Html::checkbox('address',false)." Юр. адрес<br/>";
         echo Html::checkbox('addressreg',false)." Адрес регистрации (для ИП)<br/>";
	 echo Html::checkbox('addressfact',false)." Факт. адрес<br/>";
         echo Html::checkbox('rukovod',false)." Руководитель<br/>";
         echo Html::checkbox('account',false)." Банковский счет<br/>";
         echo Html::checkbox('volume',true)." Объем выполняемых работ<br/>";
         echo Html::checkbox('sum',true)." Сумма договора<br/>";
         echo Html::checkbox('credit',true)." Долг контрагента<br/>";
		 echo Html::checkbox('email',true)." E-mail<br/>";
         echo Html::checkbox('comments',false)." Комментарий<br/>";
         echo Html::button('Вывести реестр в Excel', ['class' => 'btn btn-primary','onclick'=>'reestr();']);
         echo "</div>";
        Modal::end(); 
         
         
         
         
        Modal::begin([
            'header' => "<h2 align='center'>Синхронизация с 1С</h2>",
            'options'=>['id'=>'modal-users'],
            'size'=>'modal-lg',
            'clientOptions'=>[
                'backdrop'=>'static',
                'show'=>false,
                'keyboard'=>false
            ],
        ]);
        echo "<br/><br/><br/><br/><br/><div align='center'>Подождите, не выполняйте никаких действий, пока идет процесс синхронизации</div><br/><h2 align='center'><img src='file-loader.gif'></h2><br/><br/><br/><br/><br/><br/>";
    Modal::end();
    ?>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'options'=>[
            'style'=>'width:100%'
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
                'attribute' => 'address',
                'format' => 'text',
                'label' => 'Юр. адрес'
            ],

            [
                'contentOptions'=>['style'=>'font-size:11pt;'],
                'class' => 'yii\grid\ActionColumn',
                'template' => '<div style="text-align:center">{new_action3} {new_action2} {new_action1}</div>',
                'buttons' => [
                   'new_action2' => function ($url, $model) {
                      return Html::a('<span class="glyphicon glyphicon-pencil"></span>',Url::toRoute(['site/clients', 'kontrid' => $model->id]),[
                                  'title' => Yii::t('app', 'Изменить')
                              ]);

                  },
                  'new_action1' => function ($url, $model) {
                      return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['site2/delete', 'id' => $model->id]), [
                                  'title' => Yii::t('app', 'Удалить'),
                                  'data-confirm'=>"Вы действительно хотите удалить этого контрагента ?",
                                  'data-method' => 'post',
                                  'data-pjax' => '1']);
                  },
                  'new_action3' => function ($url, $model) {
                      return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::toRoute(['site2/view', 'id' => $model->id]), [
                                  'title' => Yii::t('app', 'Просмотреть')
                      ]);
                  }

                ],


                'urlCreator' => function ($action, $model, $key, $index) {
                  if ($action === 'new_action1') {
                      $url = $model->id;
                      return $url;
                  }
                }
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
