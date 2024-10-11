<?php

use app\enums\Tables;
use yii\db\Migration;

/**
 * Class m241011_002741_short_url
 */
class m241011_002741_short_url extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable(Tables::SHORT_URL->value, [
            'id' => $this->string(36),
            'url' => $this->string(2048)->notNull(),
            'short_url' => $this->string(36)->notNull()->unique(),
            'created_at' => $this->dateTime()->notNull(),
            'created_by' => $this->string(36)->notNull(),
        ]);

        $this->addPrimaryKey('id', Tables::SHORT_URL->value, 'id');

        $this->addForeignKey(
            'FK_ShortUrl__Identity',
            Tables::SHORT_URL->value,
            'created_by',
            Tables::IDENTITY->value,
            'id',
            'CASCADE',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable(Tables::SHORT_URL->value);
    }
}
