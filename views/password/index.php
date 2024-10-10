<?php
/**
 * @var View $this
 * @var ChangePasswordForm $model
 */

use app\forms\password\ChangePasswordForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->title = 'Change password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="change-password col-4 offset-4">
    <div class="card">
        <div class="card-header">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <?php
            $form = ActiveForm::begin(['id' => 'change-password-form']); ?>
            <?= $form->field($model, 'oldPassword')->passwordInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'newPassword')->passwordInput() ?>
            <?= $form->field($model, 'newPasswordConfirm')->passwordInput() ?>
            <div class="d-grid2">
                <?= Html::submitButton('Change password', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php
            ActiveForm::end(); ?>
        </div>
    </div>
</div>
