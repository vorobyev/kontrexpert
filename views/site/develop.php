<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Разработка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <b>[1.0.5] - 06.12.2016 </b>
    </p>
    <p style='text-indent:10px'>
        Исправления:<br>
    <ul>
        <li>Изменение механизма автозаполнения данных по контрагенту при его создании. Старый сервис слетел. На этом сервисе существует ограничение - 10000 запросов в день</li> 
    </ul>
    </p>
    <hr/> 


    <p>
        <b>[1.0.4] - 30.11.2016 </b>
    </p>
    <p style='text-indent:10px'>
        Исправления:<br>
    <ul>
        <li>Отображение последних созданных договоров на странице договоров контрагентов в количестве 6 штук</li> 
    </ul>
    </p>
    <hr/>     
    
    <p>
        <b>[1.0.3] - 22.11.2016 </b>
    </p>
    <p style='text-indent:10px'>
        Исправления:<br>
    <ul>
        <li>Добавлена новая печатная форма договора ПК и изменена старая СОУТ</li> 
    </ul>
    </p>
    <hr/> 
	
	
    <p>
        <b>[1.0.2] - 28.10.2016 </b>
    </p>
    <p style='text-indent:10px'>
        Исправления:<br>
    <ul>
        <li>В реестре контрагентов добавлена колонка договоров и поле поиска по ним</li> 
    </ul>
    </p>
    <hr/>    
    
    <p>
        <b>[1.0.1] - 27.09.2016 </b>
    </p>
    <p style='text-indent:10px'>
        Исправления:<br>
    <ul>
        <li>При синхронизации с 1С поиск контрагентов происходит только по ИНН (если есть контрагент с таким же ИНН, то он не задублируется)</li> 
    </ul>
    </p>
    <hr/>
    
    <p>
        <b>[1.0.0] - 15.09.2016</b>
    </p>
    <hr/>

</div>
