<?php
/**
 * @var View $this
 * @var IdentityToken $confirmationToken
 * @var Identity $identity
 */

use app\models\Identity;
use app\models\IdentityToken;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$url = Url::toRoute(['/signup/confirm', 'token' => $confirmationToken->token], true);
echo Html::a($url, $url, ['target' => '_blank']);