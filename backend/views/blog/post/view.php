<?php

use kartik\file\FileInput;
use core\entities\Blog\Post\Post;
use core\helpers\PostHelper;
use yii\bootstrap\ActiveForm;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $post core\entities\Blog\Post\Post */
/* @var $modificationsProvider yii\data\ActiveDataProvider */

$this->title = $post->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if ($post->isActive()): ?>
            <?= Html::a('Draft', ['draft', 'id' => $post->id], ['class' => 'btn btn-primary', 'data-method' => 'post']) ?>
        <?php else: ?>
            <?= Html::a('Activate', ['activate', 'id' => $post->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
        <?php endif; ?>
        <?= Html::a('Update', ['update', 'id' => $post->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $post->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-header with-border">Common</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $post,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'status',
                        'value' => PostHelper::statusLabel($post->status),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'user_id',
                        'value' => ArrayHelper::getValue($post, 'user.username'),
                    ],
                    'viewed',
                    'title',
                    [
                        'attribute' => 'category_id',
                        'value' => ArrayHelper::getValue($post, 'category.name'),
                    ],
                    [
                        'label' => 'Tags',
                        'value' => implode(', ', ArrayHelper::getColumn($post->tags, 'name')),
                    ],
                ],
            ]) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">Photo</div>
        <div class="box-body">
            <?php if ($post->photo): ?>
                <?= Html::a(Html::img($post->getThumbFileUrl('photo', 'thumb')), $post->getUploadedFileUrl('photo'), [
                    'class' => 'thumbnail',
                    'target' => '_blank'
                ]) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">Description</div>
        <div class="box-body">
            <?= Yii::$app->formatter->asNtext($post->description) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">Content</div>
        <div class="box-body">
            <?= Yii::$app->formatter->asNtext($post->content) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">SEO</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $post,
                'attributes' => [
                    [
                        'attribute' => 'meta.title',
                        'value' => $post->meta->title,
                    ],
                    [
                        'attribute' => 'meta.description',
                        'value' => $post->meta->description,
                    ],
                    [
                        'attribute' => 'meta.keywords',
                        'value' => $post->meta->keywords,
                    ],
                ],
            ]) ?>
        </div>
    </div>

</div>

