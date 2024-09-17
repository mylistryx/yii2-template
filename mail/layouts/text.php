<?php
/**
 * @var View $this view component instance
 * @var BaseMessage $message the message being composed
 * @var string $content main view render result
 */

use yii\mail\BaseMessage;
use yii\web\View;

$this->beginPage();
$this->beginBody();
echo $content;
$this->endBody();
$this->endPage();
