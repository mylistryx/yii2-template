<?php
/**
 * @var View $this
 * @var LoginForm $model
 */

use app\forms\LoginForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->title = 'Login';

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-login col-4 offset-4">
    <div class="card">
        <div class="card-header">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <?php
            $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
            <div class="d-grid">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php
            ActiveForm::end(); ?>
        </div>
    </div>
</div>
