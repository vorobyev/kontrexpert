<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Описанная выше ошибка произошла при обработке Вашего запроса сервером.
    </p>
    <p>
        Пожалуйста, обратитесь к администратору системы или измените свой запрос.
    </p>

</div>
