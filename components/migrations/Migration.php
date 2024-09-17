<?php

namespace app\components\migrations;

use yii\db\ColumnSchemaBuilder;

/**
 * WIP! Don`t use!
 */
class Migration extends \yii\db\Migration
{
    public function uuidPk(): ColumnSchemaBuilder
    {
        return $this->string(36)->notNull();
    }

    public function uuid(
        $allowNull = false,
        $referenceTable = null,
        $referenceColumn = null,
        $onUpdate = false,
        $onDelete = false,
    ): ColumnSchemaBuilder {
        $column = $this->string(36);
        if ($allowNull) {
            $column->null();
        }

        return $column;
    }
}