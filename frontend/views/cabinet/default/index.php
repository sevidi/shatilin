<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Cabinet';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
   <div class="cabinet-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Hello! <?= Yii::$app->user->identity->username ?></p>

    <h2>Attach profile</h2>
    <?= yii\authclient\widgets\AuthChoice::widget([
        'baseAuthUrl' => ['cabinet/network/attach'],
    ]); ?>
  </div>
</div>