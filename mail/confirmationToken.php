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

?>

Dear <?=$identity->email?>, follow <?= Html::a($url, $url) ?>
