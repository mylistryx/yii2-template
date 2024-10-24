<?php

namespace app\components\migrations;

use yii\db\ColumnSchemaBuilder;
use yii\db\Migration;

class CoreMigration extends Migration
{
    public function uuid(): ColumnSchemaBuilder
    {
        return $this->string(36);
    }

    public function uuidPk(): ColumnSchemaBuilder
    {
        return $this->uuid()->append('PRIMARY KEY');
    }
}