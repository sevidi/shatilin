<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model core\entities\Blog\Post\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>

    <div class="row">

        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">Common</div>
                <div class="box-body">
                    <?= $form->field($model, 'categoryId')->dropDownList($model->categoriesList(), ['prompt' => '']) ?>
                    <?= $form->field($model, 'userId')->hiddenInput(['value'=> Yii::$app->user->identity->getId()])->label(false);?>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">Tags</div>
                <div class="box-body">
                    <?= $form->field($model->tags, 'existing')->checkboxList($model->tags->tagsList()) ?>
                    <?= $form->field($model->tags, 'textNew')->textInput() ?>
                </div>
            </div>
        </div>

    </div>

    <div class="box box-default">
        <div class="box-body">

          <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
          <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
          <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">Photo</div>
        <div class="box-body">
            <?= $form->field($model, 'photo')->label(false)->widget(FileInput::class, [
                'options' => [
                    'accept' => 'image/*',
                ]
            ]) ?>
        </div>
    </div>

        <div class="box box-default">
            <div class="box-header with-border">SEO</div>
            <div class="box-body">
                <?= $form->field($model->meta, 'title')->textInput() ?>
                <?= $form->field($model->meta, 'description')->textarea(['rows' => 2]) ?>
                <?= $form->field($model->meta, 'keywords')->textInput() ?>
            </div>
        </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
