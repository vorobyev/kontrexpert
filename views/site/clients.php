<?php


use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;
use yii\bootstrap\Tabs;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\jui\DatePicker;
use app\models\HistoryContracts;
use app\models\PaymentsContracts;
use app\models\Organization;
use app\models\Contracts;
use app\models\Accounts;
use app\models\TimeHelper;
use kartik\popover\PopoverX;
use yii\data\ActiveDataProvider;


if (isset(Yii::$app->request->get()['kontrid'])){
    $kontr = true;
}
else {
    $kontr = false;
}

if (isset(Yii::$app->request->get()['print'])){
    $print = true;
    $print_id = Yii::$app->request->get()['print'];
}
else {
    $print = false;
}

if (isset(Yii::$app->request->get()['accounts'])){
    $acc = true;
}
else {
    $acc = false;
}

if (isset(Yii::$app->request->get()['contracts'])){
    $contracts = true;
}
else {
    $contracts = false;
}

$this->params['breadcrumbs'][] = ['label' => 'Контрагенты', 'url' => ['site2/index']];

if ($kontr) {
    $this->title = 'Изменение контрагента '.$model->name; 
    $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['site2/view','id'=>$model->id]];
    $this->params['breadcrumbs'][] = "Изменение";
} else {
    $this->title = 'Создание нового контрагента';
    $this->params['breadcrumbs'][] = 'Создание';
}

echo "<h3>".$this->title."</h3>";
$tab1="";
$tab2="";
$tab3="";
?>
<?php
if ($acc) {
    if ((isset(Yii::$app->request->get()['accid'])) &&($modelacc!=null)){
        $accid=Yii::$app->request->get()['accid'];
    } else {
        $accid=false;
    }
    if ($accid != false) {
        Modal::begin([
            'header' => ($accid=='new')?'<h3>Создание счета ('.$model->name.'))</h3>':"<h3>Счет ".$model->name."</h3>",
            'options'=>['id'=>'modal-users'],
            'size'=>'modal-lg',
            'clientOptions'=>[
                'show'=>($accid==false)?false:true
            ],
        ]);

        $form2 = ActiveForm::begin([
            'id' => 'account-form',
            'options' => ['class' => 'form-horizontal myForm'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-6\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]);   

        echo $form2->field($modelacc, 'kontrAccount',[
                    'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}<div style='margin-left:20px'>{error}</div>",
                    'inputOptions'=>['class'=>'inputMy form-control'],
                    'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
                ])->label('Расч. счет'); 

        echo $form2->field($modelacc, 'bik',[
                       'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}<div style='margin-left:20px'>{error}</div>",
                       'inputOptions'=>['class'=>'inputMy form-control'],
                       'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
                ])->label('БИК');
       echo "<div class='myBtnInn'>";
       echo Html::button('Заполнить по БИК данные банка',['class'=>'btn btn-primary','onClick'=>'getJsonBik();'])."</div>";  
        echo $form2->field($modelacc, 'bankName',[
                       'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}<div style='margin-left:20px'>{error}</div>",
                       'inputOptions'=>['class'=>'inputMy form-control'],
                       'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
                   ])->label('Наименование банка');
        echo $form2->field($modelacc, 'korrAccount',[
                       'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}{error}",
                       'inputOptions'=>['class'=>'inputMy form-control'],
                       'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
                   ])->label('Корр. счет');
        echo $form2->field($modelacc, 'city',[
                       'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}{error}",
                       'inputOptions'=>['class'=>'inputMy form-control'],
                       'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
                   ])->label('Город');
        echo $form2->field($modelacc, 'address',[
                       'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}{error}",
                       'inputOptions'=>['class'=>'inputMy form-control'],
                       'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
                   ])->label('Адрес');
        echo Html::submitButton(($accid!='new')?'Записать':'Добавить счет',['class'=>'btn btn-success']);
           ActiveForm::end();    
           Modal::end();
    }
    $tab2=$tab2.Html::a('Создать счет', Url::to(['site/clients','kontrid'=>Yii::$app->request->get()['kontrid'],'accounts'=>1,'accid'=>'new']), ['class' => 'btn btn-success'])."<br/><br/>";
    $tab2=$tab2.GridView::widget([
            'options'=>[
                'style'=>'width:100%'
            ],
            'rowOptions' => function ($model, $key, $index, $grid)
                {
                      return ['style' => 'font-size:9pt;'];
                },
            'dataProvider' => $accProvider,
            'layout'=>'{pager}{errors}{items}',
            'emptyText'=>"Счета не найдены...",
            'columns' => [
                [        
                    'attribute' => 'kontrAccount',
                    'format' => 'text',
                    'label' => 'Расч. счет'
                ],
                [ 
                    'attribute' => 'bik',
                    'format' => 'text',
                    'label' => 'БИК'
                ],
                [        
                    'attribute' => 'bankName',
                    'format' => 'text',
                    'label' => 'Наименование банка'
                ],
                [        
                    'attribute' => 'city',
                    'format' => 'text',
                    'label' => 'Город'
                ],
                [
                    'contentOptions'=>['style'=>'font-size:11pt;'],
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '<div style="text-align:center">{new_action3} {new_action2} {new_action1}</div>',
                    'buttons' => [
                       'new_action2' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-pencil"></span>',Url::toRoute(['site/clients', 'kontrid' => $model->idKontr,'accounts' => '1','accid'=>$model->id]),[
                                      'title' => Yii::t('app', 'Изменить')
                                  ]);

                      },
                      'new_action1' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['site/deleteacc', 'id' => $model->id,'kontrid' => $model->idKontr]), [
                                      'title' => Yii::t('app', 'Удалить'),
                                      'data-confirm'=>"Вы действительно хотите удалить этот счет?",
                                      'data-method' => 'post',
                                      'data-pjax' => '1']);
                      },
                      'new_action3' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::toRoute(['site/viewacc', 'id' => $model->id,'kontrid' => $model->idKontr]), [
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
        ]);


                 
                
}
?>


<?php

if ($contracts) {
    if ((isset(Yii::$app->request->get()['contrid'])) &&($modelacc!=null)){
        $contrid=Yii::$app->request->get()['contrid'];
    } else {
        $contrid=false;
    }
    if ($contrid != false) {
        Modal::begin([
            'header' => ($contrid=='new')?'<h3>Создание договора ('.$model->name.'))</h3>':"<h3>Договор ".$model->name."</h3>",
            'options'=>['id'=>'modal-users'],
            'size'=>'modal-lg',
            'clientOptions'=>[
                'show'=>($contrid==false)?false:true
            ],
        ]);

        $form3 = ActiveForm::begin([
            'id' => 'contact-form',
            'options' => ['class' => 'form-horizontal myForm'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-6\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]);   

        echo $form3->field($modelcontracts, 'dateContract',[
                    'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}<div style='margin-left:20px'>{error}</div>",
                    'inputOptions'=>['class'=>'inputMy form-control'],
                    'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
                ])->widget(DatePicker::classname(), [
    'language' => 'ru',
    'dateFormat' => 'yyyy-MM-dd',
    'options'=>[
        'class'=>'inputMy form-control',
        'style'=>'width:120px;',
        'readonly'=>'readonly'
    ]               
]) ->label('Дата договора'); 

        echo $form3->field($modelcontracts, 'numberContract',[
                       'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}<div style='margin-left:20px'>{error}</div>",
                       'inputOptions'=>['class'=>'inputMy form-control'],
                       'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
                ])->label('Номер');
        
        echo $form3->field($modelhistory, 'volumeJob',[
                       'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}<div style='margin-left:20px'>{error}</div>",
                       'inputOptions'=>['class'=>'inputMy form-control'],
                       'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
                ])->label('Объем выполняемых работ, р.м.');
        echo $form3->field($modelhistory, 'summ',[
                       'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}<div style='margin-left:20px'>{error}</div>",
                       'inputOptions'=>['class'=>'inputMy form-control'],
                       'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
                ])->label('Сумма договора, (руб)');
         echo $form3->field($modelcontracts, 'subj',[
                       'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}<div style='margin-left:20px'>{error}</div>",
                       'inputOptions'=>['class'=>'inputMy form-control'],
                       'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
                ])->label('Предмет договора'); 				
         echo $form3->field($modelcontracts, 'comments',[
                       'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}<div style='margin-left:20px'>{error}</div>",
                       'inputOptions'=>['class'=>'inputMy form-control'],
                       'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
                ])->label('Комментарий');
        
        echo Html::submitButton(($contrid!='new')?'Записать':'Добавить договор',['class'=>'btn btn-success']);
           ActiveForm::end();    
           Modal::end();
    }
	$last_contr = Contracts::find()->orderBy('id DESC')->offset(3)->limit(3)->all();
	$str = "";
	$count1 = count($last_contr);
	$i=1;
	foreach (array_reverse($last_contr) as $contr1){
		if ($i==1) {
			$str = $str."№".$contr1->numberContract." от ".$contr1->dateContract."<br/>";
		} else if ($i==$count1) {
			$str = $str." №".$contr1->numberContract." от ".$contr1->dateContract;
		} else {
			$str = $str." №".$contr1->numberContract." от ".$contr1->dateContract."<br/>";
		}
		$i=$i+1;
	}
	$tab3=$tab3."<div class='col-lg-12'><span style='color:#848484;'><div class='col-lg-12'>Последние созданные договоры</div><div style='font-size:8pt;' class='col-lg-2'>".$str."</div></span>";
    	//x2
        $last_contr = Contracts::find()->orderBy('id DESC')->limit(3)->all();
	$str = "";
	$count1 = count($last_contr);
	$i=1;
	foreach (array_reverse($last_contr) as $contr1){
		if ($i==1) {
			$str = $str."№".$contr1->numberContract." от ".$contr1->dateContract."<br/>";
		} else if ($i==$count1) {
			$str = $str." <span style='color:black'><b>№".$contr1->numberContract." от ".$contr1->dateContract."</b></span>";
		} else {
			$str = $str." №".$contr1->numberContract." от ".$contr1->dateContract."<br/>";
		}
		$i=$i+1;
	}
	$tab3=$tab3."<div class='col-lg-2'><span style='color:#848484;'><div style='font-size:8pt;'>".$str."</div></span><br/></div></div>";
    
        
        $tab3=$tab3.Html::a('Создать договор', Url::to(['site/clients','kontrid'=>Yii::$app->request->get()['kontrid'],'contracts'=>1,'contrid'=>'new']), ['class' => 'btn btn-success'])."<br/><br/>";
    $tab3=$tab3.GridView::widget([
            'options'=>[
                'style'=>'width:100%'
            ],
            'rowOptions' => function ($model, $key, $index, $grid)
                {
                      return ['style' => 'font-size:9pt;'];
                },
            'dataProvider' => $contractsProvider,
            'layout'=>'{pager}{errors}{items}',
            'emptyText'=>"Договоры не найдены...",
            'columns' => [
                [        
                    'format' => 'raw',
                    'label' => 'Наименование',
                    'value' => function($data){

                        return "Договор №".$data->numberContract." от ".$data->dateContract;
                    }
                ],
                [        
                    'format' => 'raw',
                    'label' => 'Объем выполняемых работ, р.м.',
                    'value' => function($data){
                        $hist = HistoryContracts::find()->where(['idContr'=>$data->id])->orderBy('id DESC')->one();
                        if ($hist == NULL) {
                            return "";
                        }
                        
                        return $hist->volumeJob;
                    }
                ], 
                [        
                    'format' => 'raw',
                    'label' => 'Сумма договора, (руб)',
                    'value' => function($data){
                        $hist = HistoryContracts::find()->where(['idContr'=>$data->id])->orderBy('id DESC')->one();
                        if ($hist == NULL) {
                            return "";
                        }
                        
                        return $hist->summ;
                    }
                ], 
                [        
                    'format' => 'raw',
                    'label' => 'История изменений',
                    'value' => function($data){

                    $hist = HistoryContracts::find()->where(['idContr'=>$data->id])->orderBy('id');
                    
                    $histProvider = new ActiveDataProvider([
                    'query' => $hist, 
                    'pagination' => [
                    'pageSize' => 10,
                 ],
                   ]); 
                    
                    $str = GridView::widget([
                            'options'=>[
                                'style'=>'width:100%'
                            ],
                            'headerRowOptions'=>[
                                'style'=>'font-size:8pt;'
                            ],
                            'rowOptions' => function ($model, $key, $index, $grid)
                                {
                                      return ['style' => 'font-size:8pt;'];
                                },
                                        
                            'dataProvider' => $histProvider,
                            'layout'=>'{pager}{errors}{items}',
                            'emptyText'=>"Изменения не найдены...",
                            'columns' => [
                                [        
                                    'attribute' => 'dateContr',
                                    'format' => 'text',
                                    'label' => 'Дата изменения'
                                ],
                                [ 
                                    'attribute' => 'volumeJob',
                                    'format' => 'text',
                                    'label' => 'Объем выполняемой работы, р.м.'
                                ],
                                [        
                                    'attribute' => 'summ',
                                    'format' => 'text',
                                    'label' => 'Сумма договора, руб'
                                ],
                            ],
                        ]);


                    return PopoverX::widget([
                        'header' => "<b>История</b>",
                        'placement' => PopoverX::ALIGN_TOP_RIGHT,
                        'size'=>PopoverX::SIZE_LARGE,
                        'content' => $str,
                        'toggleButton'=>['label'=>"История", 'class'=>'btn btn-info','id'=>'btn'.$data->id,'onClick'=>'return false;','style'=>'margin:0 auto; display:block;']
                    ]);
                    }
                ],
                [        
                    'format' => 'raw',
                    'label' => 'Оплата',
                    'value' => function($data){

                    $paym = PaymentsContracts::find()->where(['idContr'=>$data->id])->orderBy('datePayment');
                    
                    $paymProvider = new ActiveDataProvider([
                    'query' => $paym, 
                    'pagination' => [
                    'pageSize' => 10,
                 ],
                   ]); 
                    
                    $payments = PaymentsContracts::find()->where(['idContr'=>$data->id])->all();
                    $pay = 0;
                    foreach($payments as $payment) {
                        if (isset($payment->summ)){
                            $pay+=(float)$payment->summ;
                        }
                    }
                    $history = HistoryContracts::find()->where(['idContr'=>$data->id])->orderBy('id DESC')->one();
                    if (isset($history->summ)) {
                        $credit = (float)$history->summ - $pay;
                    } else {
                        $credit = - $pay;
                    }
                    
                    $str = GridView::widget([
                            'options'=>[
                                'style'=>'width:100%;max-height:180px; overflow-y: scroll;',
                    
                            ],
                            'headerRowOptions'=>[
                                'style'=>'font-size:8pt;'
                            ],
                            'rowOptions' => function ($model, $key, $index, $grid)
                                {
                                      return ['style' => 'font-size:8pt;'];
                                },
                                        
                            'dataProvider' => $paymProvider,
                            'layout'=>'{pager}{errors}{items}',
                            'emptyText'=>"Оплаты не найдены...",
                            'columns' => [
                                [        
                                    'attribute' => 'datePayment',
                                    'format' => 'text',
                                    'label' => 'Дата оплаты'
                                ],
                                [ 
                                    'attribute' => 'summ',
                                    'format' => 'text',
                                    'label' => 'Сумма, (руб)'
                                ],
                            [
                                'contentOptions'=>['style'=>'font-size:9pt;'],
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '<div style="text-align:center">{new_action1}</div>',
                                'buttons' => [
                                  'new_action1' => function ($url, $model) {
                                      return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['site/deletepay', 'id' => $model->id,'kontrid'=>Yii::$app->request->get()['kontrid']]), [
                                                  'title' => Yii::t('app', 'Удалить'),
                                                  'data-confirm'=>"Вы действительно хотите удалить эту оплату?",
                                                  'data-method' => 'post',
                                                  'data-pjax' => '1']);
                                  },


                                ],


                                'urlCreator' => function ($action, $model, $key, $index) {
                                  if ($action === 'new_action1') {
                                      $url = $model->id;
                                      return $url;
                                  }
                                }
                            ],     
                                
                            ],
                        ])."Итого оплата: <font style='color:green'>".(string)$pay."</font> &nbsp;&nbsp;&nbsp; Долг по договору: <font style='color:red'>".(string)$credit.'</font><h4>Добавление оплаты</h4><div style="margin-bottom:8px;"><label style="display:inline-block; width:110px">Дата оплаты &nbsp;</label>'.DatePicker::widget([
                            'name' => 'datePay'.$data->id,
                                'language' => 'ru',
                                'dateFormat' => 'yyyy-MM-dd',
                                'options'=>[
                                    'class'=>'inputMy form-control',
                                    'style'=>'width:120px;',
                                    'readonly'=>'readonly'
                                ]              
                            ]).'</div><div style="margin-bottom:8px;"><label style="display:inline-block; width:110px">Сумма, (руб) &nbsp;</label>'.Html::input('text','sumPay'.$data->id,"",['class'=>'form-control','style'=>'width:160px;display:inline'])."</div>".Html::button("Внести оплату",['class'=>'btn btn-primary','id'=>'btn'.$data->id,'onclick'=>'addPayment(this.id);']);


                    return PopoverX::widget([
                        'header' => "<b>Оплаты</b>",
                        'placement' => PopoverX::ALIGN_LEFT,
                        'size'=>PopoverX::SIZE_LARGE,
                        'content' => $str,
                        'toggleButton'=>['label'=>"Оплаты", 'class'=>'btn btn-info','id'=>'btn'.$data->id,'onClick'=>'return false;','style'=>'margin:0 auto; display:block;']
                    ]);
                    }
                ],       
                [
                    'contentOptions'=>['style'=>'font-size:11pt;'],
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '<div style="text-align:center">{new_action3} {new_action2} {new_action1} {new_action4}</div>',
                    'buttons' => [
                       'new_action2' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-pencil"></span>',Url::toRoute(['site/clients', 'kontrid' => $model->idKontr,'contracts' => '1','contrid'=>$model->id]),[
                                      'title' => Yii::t('app', 'Изменить')
                                  ]);

                      },
                      'new_action1' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['site/deletecontr', 'id' => $model->id,'kontrid'=>Yii::$app->request->get()['kontrid']]), [
                                      'title' => Yii::t('app', 'Удалить'),
                                      'data-confirm'=>"Вы действительно хотите удалить этот договор?",
                                      'data-method' => 'post',
                                      'data-pjax' => '1']);
                      },
                      'new_action3' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::toRoute(['site/viewcontr', 'id' => $model->id,'kontrid' => $model->idKontr]), [
                                      'title' => Yii::t('app', 'Просмотреть')
                          ]);
                      },
                       'new_action4' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-print"></span>', Url::toRoute(['site/clients', 'kontrid' => $model->idKontr,'contracts' => '1','print'=>$model->id]), [
                                      'title' => Yii::t('app', 'Печатная форма')
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
        ]);
                
                
    if ($print) {
            Modal::begin([
                    'header' => "<h2 align='center'>Вывод печатной формы документа</h2>",
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
                'header' => "<h2 align='center'>Вывод печатной формы договора</h2>",
                'options'=>['id'=>'modal-print'],
                'size'=>'modal-lg',
                'clientOptions'=>[
                    'show'=>true
                ],
            ]);
                $form = ActiveForm::begin([
                    'id' => 'print-form',
                    'method'=>'post',
                    'options' => ['class' => 'form-horizontal myForm'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-1 control-label'],
                    ],
                ]); 
                
                    $kontr = Organization::findOne(Yii::$app->request->get()['kontrid']);
                    $contr = Contracts::findOne($print_id);
                    $hist = HistoryContracts::find()->where(['idContr'=>$print_id])->orderBy('id DESC')->one();
                    $acc1 = Accounts::find()->where(['idKontr'=>Yii::$app->request->get()['kontrid']])->orderBy('id DESC')->one();
                    
                    $dolzh = explode(" ",mb_strtolower($kontr->rukovod));
                    $count = count($dolzh);
                    $dolzh2 = "";
                    for ($i=0;$i<$count-3;$i++) {
                        if ($i!=0){
                            $dolzh2.=" ".$dolzh[$i];
                        } else {
                            $dolzh2.=mb_convert_case($dolzh[$i],MB_CASE_TITLE);
                        }
                    }
                    $dolzh3 = "";
                    for ($i=0;$i<$count-3;$i++) {
                        if ($i!=0){
                            $dolzh3.=" ".$dolzh[$i];
                        } else {
                            $dolzh3.=$dolzh[$i];
                        }
                    }
                    $rukov = "";
                    for ($i=$count-3;$i<=$count-1;$i++) {
                        if ($i!=$count-3){
                            $rukov.=" ".$dolzh[$i];
                        } else {
                            $rukov.=$dolzh[$i];
                        }
                    }
                    $rukov = mb_convert_case($rukov,MB_CASE_TITLE);
                    $rukovInitArr = explode(" ",$rukov);
                    $rukovInit = mb_substr($rukovInitArr[1],0,1).".".mb_substr($rukovInitArr[2],0,1).". ".$rukovInitArr[0];
                    $dateContr = TimeHelper::create((string)$contr->dateContract)->longDate();
                    $sum = $hist->summ." (".num_propis((int)$hist->summ).")";
                    
                    $rekvisits = "";
                    if (($kontr->address!=null)&&($kontr->address!="")){
                            $rekvisits.= "Адрес юридический: ".$kontr->address.chr(13).chr(10);
                    }
                    if (($kontr->addressreg!=null)&&($kontr->addressreg!="")){
                            $rekvisits.= "Адрес регистрации: ".$kontr->addressreg.chr(13).chr(10);
                    }                    
                    if (($kontr->addressfact!=null)&&($kontr->addressfact!="")&&($kontr->addressfact!=$kontr->address)){
                            $rekvisits.= "Адрес фактический: ".$kontr->addressfact.chr(13).chr(10);
                    }
                    $rekvisits.= "ИНН ".$kontr->inn.chr(13).chr(10);
                    if (($kontr->kpp!="")&&($kontr->kpp!=NULL)) {
                        $rekvisits.= "КПП ".$kontr->kpp.chr(13).chr(10);
                    }
                    if (($kontr->ogrn!="")&&($kontr->ogrn!=NULL)) {
                        $rekvisits.= "ОГРН ".$kontr->ogrn.chr(13).chr(10);
                    }
                    if ($acc1!=NULL) {
                        $rekvisits.= "р/с ".$acc1->kontrAccount.chr(13).chr(10);
                        $rekvisits.= $acc1->bankName.chr(13).chr(10);
                        $rekvisits.= "к/с ".$acc1->korrAccount.chr(13).chr(10);
                        $rekvisits.= "БИК ".$acc1->bik.chr(13).chr(10);
                    }
                    if ($kontr->phone!="") {
                        $rekvisits.= "Тел.: ".$kontr->phone.chr(13).chr(10);
                    }
                    if ($kontr->okpo!="") {
                        $rekvisits.= "ОКПО ".$kontr->okpo.chr(13).chr(10);
                    }
                    if ($kontr->email!="") {
                        $rekvisits.= "E-mail: ".$kontr->email.chr(13).chr(10);
                    }
                    $prilozh = date("d.m.Y", strtotime($contr->dateContract))."г. № ".$contr->numberContract;
                    echo "<b>Вид договора:</b> ".Html::dropDownList('formdog',"",['0'=>'СОУТ','1'=>'ПК'],['class'=>'form-control','style'=>'margin-bottom:10px','onChange'=>'changeForm();']); 
                    echo "<b>Полное наименование:</b><br/> ".Html::input('text','fullname',(strlen($kontr->inn) == 10)?$kontr->fullName:$kontr->rukovod,['class'=>'form-control','style'=>'margin-bottom:10px;width:85%;display:inline-block;'])."<span style='font-size:18pt;'>&nbsp;".Html::a('<span class="glyphicon glyphicon-download" style="top:6px"></span>', "", [
                                      'title' => Yii::t('app', 'в нижний регистр'),
                                    'onclick'=>'toLower("1"); return false;'
                          ])."&nbsp;".Html::a("<span class='glyphicon glyphicon-upload' style='top:6px'></span>", "", [
                                      'title' => Yii::t('app', 'В ВЕРХНИЙ РЕГИСТР'),
                                    'onclick'=>'toUpper("1"); return false;'
                          ])."</span><br/>";
                    echo "<b>Наименование:</b> <br/>".Html::input('text','name',$kontr->name,['class'=>'form-control','style'=>'margin-bottom:10px;width:85%;display:inline-block;'])."<span style='font-size:18pt;'>&nbsp;".Html::a('<span class="glyphicon glyphicon-download" style="top:6px"></span>', "", [
                                      'title' => Yii::t('app', 'в нижний регистр'),
                                    'onclick'=>'toLower("2"); return false;'
                          ])."&nbsp;".Html::a("<span class='glyphicon glyphicon-upload' style='top:6px'></span>", "", [
                                      'title' => Yii::t('app', 'В ВЕРХНИЙ РЕГИСТР'),
                                    'onclick'=>'toUpper("2"); return false;'
                          ])."</span><br/>";
						  if (strlen($kontr->inn) == 10){
							  echo "<b>Должность руководителя:</b> ".Html::input('text','dolzh',$dolzh2,['class'=>'form-control','style'=>'margin-bottom:10px']);
						  } else {
							  echo Html::input('hidden','dolzh',"Индивидуальный предприниматель");
						  }
                    if (strlen($kontr->inn) == 10){ 
						echo "<b>Должность руководителя в родительном падеже (напр., генерального директора):</b> ".Html::input('text','dolzhrod',$dolzh3,['class'=>'form-control','style'=>'margin-bottom:10px']); 
                    } else {
						echo Html::input('hidden','dolzhrod',"предпринимателя");
					}
					echo (strlen($kontr->inn) == 10)?"<b>Руководитель действует на основании:</b> ":"<b>ИП действует на основании:</b> ";
					echo Html::input('text','osnovaniye',(strlen($kontr->inn) == 10)?"Устава":"Свидетельства",['class'=>'form-control','style'=>'margin-bottom:10px']);
                    echo "<b>ФИО руководителя:</b> ".Html::input('text','rukov',$rukov,['class'=>'form-control','style'=>'margin-bottom:10px']); 
                    echo "<b>ФИО руководителя (инициалы):</b> ".Html::input('text','rukovinit',$rukovInit,['class'=>'form-control','style'=>'margin-bottom:10px']); 
                    if (strlen($kontr->inn) == 10){
						echo "<b>ФИО руководителя в родительном падеже (напр., Иванова Ивана Ивановича):</b> ".Html::input('text','rukovrod',$rukov,['class'=>'form-control','style'=>'margin-bottom:10px']);
                    } else {
						echo Html::input('hidden','rukovrod',"");
					}
					echo "<div id='hiddVal'><b>Объем работ (прописью) в склонении (напр., на пятидесяти четырех рабочих местах):</b> ".Html::input('text','volume',num_propis((int)$hist->volumeJob),['class'=>'form-control','style'=>'margin-bottom:10px'])."</div>";
                    echo Html::input('hidden','numberContract',$contr->numberContract);
                    echo Html::input('hidden','dateContract',$dateContr);
                    echo Html::input('hidden','sum',$sum);
                    echo Html::input('hidden','rekvisits',$rekvisits);
                    echo Html::input('hidden','prilozh',$prilozh);
                    echo Html::input('hidden','volumecifer',(string)$hist->volumeJob);
                    echo Html::submitButton('Сформировать документ',['class'=>'btn btn-success','onclick'=>'$("#modal-print").modal("hide");$("#modal-print-wait").modal("show");setTimeout(\'$("#modal-print-wait").modal("hide")\',4000)']);
                ActiveForm::end();               
            Modal::end(); 
    }             

}

function num_propis($num){ // $num - цело число

# Все варианты написания чисел прописью от 0 до 999 скомпонуем в один небольшой массив
 $m=array(
  array('ноль'),
  array('-','один','два','три','четыре','пять','шесть','семь','восемь','девять'),
  array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать','пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать'),
  array('-','-','двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят','восемьдесят','девяносто'),
  array('-','сто','двести','триста','четыреста','пятьсот','шестьсот','семьсот','восемьсот','девятьсот'),
  array('-','одна','две')
 );

# Все варианты написания разрядов прописью скомпануем в один небольшой массив
 $r=array(
  array('...ллион','','а','ов'), // используется для всех неизвестно больших разрядов 
  array('тысяч','а','и',''),
  array('миллион','','а','ов'),
  array('миллиард','','а','ов'),
  array('триллион','','а','ов'),
  array('квадриллион','','а','ов'),
  array('квинтиллион','','а','ов')
  // ,array(... список можно продолжить
 );

 if($num==0)return$m[0][0]; # Если число ноль, сразу сообщить об этом и выйти
 $o=array(); # Сюда записываем все получаемые результаты преобразования

# Разложим исходное число на несколько трехзначных чисел и каждое полученное такое число обработаем отдельно
 foreach(array_reverse(str_split(str_pad($num,ceil(strlen($num)/3)*3,'0',STR_PAD_LEFT),3))as$k=>$p){
  $o[$k]=array();

# Алгоритм, преобразующий трехзначное число в строку прописью
  foreach($n=str_split($p)as$kk=>$pp)
  if(!$pp)continue;else
   switch($kk){
    case 0:$o[$k][]=$m[4][$pp];break;
    case 1:if($pp==1){$o[$k][]=$m[2][$n[2]];break 2;}else$o[$k][]=$m[3][$pp];break;
    case 2:if(($k==1)&&($pp<=2))$o[$k][]=$m[5][$pp];else$o[$k][]=$m[1][$pp];break;
   }$p*=1;if(!$r[$k])$r[$k]=reset($r);

# Алгоритм, добавляющий разряд, учитывающий окончание руского языка
  if($p&&$k)switch(true){
   case preg_match("/^[1]$|^\\d*[0,2-9][1]$/",$p):$o[$k][]=$r[$k][0].$r[$k][1];break;
   case preg_match("/^[2-4]$|\\d*[0,2-9][2-4]$/",$p):$o[$k][]=$r[$k][0].$r[$k][2];break;
   default:$o[$k][]=$r[$k][0].$r[$k][3];break;
  }$o[$k]=implode(' ',$o[$k]);
 }
 
 return implode(' ',array_reverse($o));
}

?>


   <?php $form = ActiveForm::begin([
        'id' => 'registration-form',
        'options' => ['class' => 'form-horizontal myForm'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); 
   $isIp = strlen((string)$model->inn)==12;
   ?>

        <?php $tab1=$tab1.$form->field($model, 'inn',[
                'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}{error}",
                'inputOptions'=>['class'=>'inputMy form-control'],
                'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
            ])->widget(MaskedInput::className(),['mask'=>'999999999999','options'=>['class'=>'inputMy form-control','onChange'=>'changeForm();']])->label('ИНН'); 
			//])->label('ИНН'); 
$tab1=$tab1."<div class='myBtnInn'>";
$tab1=$tab1. Html::button('Заполнить по ИНН данные контрагента',['class'=>'btn btn-primary','onClick'=>'getJsonInn();'])."</div>";
 $tab1=$tab1.$form->field($model, 'fullName',[
                'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}{error}",
                'inputOptions'=>['class'=>'inputMy form-control'],
                'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
            ])->label('Полное наименование');
$tab1=$tab1.$form->field($model, 'name',[
                'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}{error}",
                'inputOptions'=>['class'=>'inputMy form-control'],
                'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
            ])->label('Сокр. наименование');
$tab1=$tab1.$form->field($model, 'name1c',[
                'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}{error}",
                'inputOptions'=>['class'=>'inputMy form-control','onChange'=>'drawCount()'],
                'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
            ])->label('Наименование для 1С (0/30 символов)');
$tab1=$tab1.$form->field($model, 'address',[
                'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}{error}",
                'inputOptions'=>['class'=>'inputMy form-control','style'=>($isIp)?'display:none':'display:inline-block'],
                'labelOptions'=>['class'=>'labelMy col-lg-1 control-label','style'=>($isIp)?'display:none':'display:inline']
            ])->label('Юр. адрес');
$tab1=$tab1.$form->field($model, 'addressreg',[
                'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}",
                'inputOptions'=>['class'=>'inputMy form-control','style'=>'display:none','style'=>($isIp)?'display:inline-block':'display:none'],
                'labelOptions'=>['class'=>'labelMy col-lg-1 control-label','style'=>'display:none','style'=>($isIp)?'display:inline':'display:none']
            ])->label('Адрес регистрации ИП');
$tab1=$tab1.$form->field($model, 'addressfact',[
                'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}{error}",
                'inputOptions'=>['class'=>'inputMy form-control'],
                'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
            ])->label('Факт. адрес');
$tab1=$tab1.$form->field($model, 'kpp',[
                'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}{error}",
                'inputOptions'=>['class'=>'inputMy form-control','style'=>($isIp)?'display:none':'display:inline-block'],
                'labelOptions'=>['class'=>'labelMy col-lg-1 control-label','style'=>($isIp)?'display:none':'display:inline']
            ])->label('КПП');
$tab1=$tab1.$form->field($model, 'okpo',[
                'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}{error}",
                'inputOptions'=>['class'=>'inputMy form-control'],
                'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
            ])->label('ОКПО');
$tab1=$tab1.$form->field($model, 'ogrn',[
                'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}{error}",
                'inputOptions'=>['class'=>'inputMy form-control'],
                'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
            ])->label('ОГРН');
$tab1=$tab1.$form->field($model, 'email',[
                'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}{error}",
                'inputOptions'=>['class'=>'inputMy form-control'],
                'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
            ])->label('E-mail');
$tab1=$tab1.$form->field($model, 'phone',[
                'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}{error}",
                'inputOptions'=>['class'=>'inputMy form-control'],
                'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
            ])->label('Телефон');
if (!$kontr) {
    $tab1=$tab1."<hr>";
    $tab1=$tab1."<div id='red_ruk' style='display:inline;margin-left:20px'>Редактировать руководителя</div> ".Html::checkbox('myCheck',false,['style'=>'margin-left:10px;','onChange'=>'changeFocusRukov(this);'])."<br/><br/>";
    $tab1=$tab1.$form->field($model, 'rukovod2',[
                    'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}{error}",
                    'inputOptions'=>['class'=>'inputMy form-control'],
                    'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
                ])->dropDownList([],['onchange'=>'changeLabelRukov(this);'])->label('Руководитель (выбор)');
}
$tab1=$tab1.$form->field($model, 'rukovod',[
                'template' => "{hint}{beginLabel}{labelTitle}{endLabel}{input}{error}",
                'inputOptions'=>['class'=>'inputMy form-control','readonly'=>($isIp||$kontr)?false:true],
                'labelOptions'=>['class'=>'labelMy col-lg-1 control-label']
            ])->label('Руководитель');


$tab1=$tab1.Html::submitButton(($kontr)?'Записать':'Добавить контрагента',['class'=>'btn btn-success']);
if ($kontr) {
$tab1=$tab1."&nbsp;".Html::a('Удалить', Url::toRoute(['site2/delete', 'id' => $model->id]), [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить этого контрагента?',
                'method' => 'post',
            ],
]); 

}?>
  <?php 
  if ($kontr) {
    echo Nav::widget([
        'options' => ['class' => 'nav nav-tabs'],
        'items' => [
            ['label' => 'Основное', 'url' => ['/site/clients','kontrid'=>Yii::$app->request->get()['kontrid']],'active'=>($acc||$contracts)?false:true],
            ['label' => 'Банковские счета('.$kolacc.")", 'url' => ['/site/clients','kontrid'=>Yii::$app->request->get()['kontrid'],'accounts'=>'1'],'active'=>($acc)?true:false],
            ['label' => 'Договоры ('.$kolcontr.")", 'url' => ['/site/clients','kontrid'=>Yii::$app->request->get()['kontrid'],'contracts'=>'1'],'active'=>($contracts)?true:false],
        ],
    ]);
    
    echo ($acc)?"<br/>".$tab2:"";
    echo ($contracts)?"<br/>".$tab3:"";
    echo (!$contracts&&!$acc)?"<br/>".$tab1:"";
//  echo Tabs::widget([
//    'items' => [
//        [
//            'label' => 'Основное',
//            'content' => $tab1,
//            'active' => true
//        ],
//        [
//            'label' => 'Банковские счета',
//            'content' => "123"
//        ],   
//        [
//            'label' => 'Договоры',
//            'content' => "123"
//        ],    
//    ],
//]);
  } else {
      echo "<br/>".$tab1;
  }
  
  ActiveForm::end(); 
  
  ?>
        

        
    
