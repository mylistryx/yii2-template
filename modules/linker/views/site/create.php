<?php

use app\modules\linker\forms\CreateShortUrlForm;
use kartik\widgets\DatePicker;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var CreateShortUrlForm $model
 */
$this->title = 'Create short URL';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="create-short-url col-6 offset-3">
    <?php
    $form = ActiveForm::begin(['id' => 'create-short-url']); ?>
    <?= $form->field($model, 'url')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'maxViews')->textInput() ?>
    <?= $form->field($model, 'expiresDate')->widget(DatePicker::class, [
        'language' => 'ru',
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
        ],
    ]) ?>
    <div class="d-grid">
        <?= Html::submitButton('Create short URL', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php
    ActiveForm::end(); ?>
</div>