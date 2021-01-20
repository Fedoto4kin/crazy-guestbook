<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Comment;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true, 'readonly'=> true]) ?>

    <?= $form->field($model, 'created_at')->textInput(['maxlength' => true, 'readonly'=> true]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['maxlength' => true, 'readonly'=> true]) ?>

    <?= $form->field($model, 'status')->dropDownList([
                           Comment::STATUS_HIDE  => Comment::getStatus(Comment::STATUS_HIDE),
                           Comment::STATUS_SHOW  => Comment::getStatus(Comment::STATUS_SHOW),

        ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
