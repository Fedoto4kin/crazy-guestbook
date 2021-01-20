<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model common\models\Comment */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$formatter = \Yii::$app->formatter;

$this->title = 'Add new comment';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-add-comment content-container">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        You may add your comment, after moderation it will be shown on Home page
    </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'subject') ?>

                <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
