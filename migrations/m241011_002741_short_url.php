<?php

use app\components\migrations\CoreMigration;
use app\enums\Tables;

/**
 * Class m241011_002741_short_url
 */
class m241011_002741_short_url extends CoreMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable(Tables::SHORT_URL->value, [
            'id' => $this->uuidPk(),
            'url' => $this->string(2048)->notNull(),
            'short_url' => $this->string(36)->notNull()->unique()->append('COLLATE latin1_general_cs'),
            'created_at' => $this->dateTime()->notNull(),
            'created_by' => $this->uuid()->notNull(),
        ]);

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
