<?php

namespace app\modules\counterparty;

use Yii;
use yii\base\Module;

class CounterpartyModule extends Module {
    public function init(): void
    {
        parent::init();
        Yii::configure($this, require __DIR__ . '/config.php');
    }
}