<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $post core\entities\Blog\Post\Post */
/* @var $post core\forms\manage\Blog\Post\PostForm */

$this->title = 'Update Post: ' . $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $post->title, 'url' => ['view', 'id' => $post->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
