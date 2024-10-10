<?php
/**
 * @var View $this
 * @var SignupForm $model
 */

use app\forms\SignupForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->title = 'Request signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup col-4 offset-4">
    <div class="card">
        <div class="card-header">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <?php
            $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'password')->passwordInput() ?>

            <div class="d-grid">
                <?= Html::submitButton('Request signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php
            ActiveForm::end() ?>
        </div>
    </div>
</div>
