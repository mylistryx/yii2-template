<?php
/**
 * @var View $this
 * @var IdentityToken $passwordResetToken
 * @var Identity $identity
 */

use app\models\Identity;
use app\models\IdentityToken;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$url = Url::toRoute(['/password/reset', 'token' => $passwordResetToken->token], true);
echo Html::a($url, $url, ['target' => '_blank']);