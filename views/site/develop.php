<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Разработка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h1><?= Html::encode($this->title) ?></h1>
    
    
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
