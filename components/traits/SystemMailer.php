<?php

namespace app\components\traits;

use app\components\exceptions\MailerException;
use Yii;

trait SystemMailer
{
    public function sendSystemMail(string $to, string $subject, string $template, array $params = []): void
    {
        if (!Yii::$app->mailer
            ->compose($template, $params)
            ->setSubject($subject)
            ->setFrom([Yii::$app->params['system.senderEmail'] => Yii::$app->params['app.companyName']])
            ->setTo($to)
            ->send()) {
            throw new MailerException();
        }
    }
}