<?php

use app\components\migrations\CoreMigration;
use app\enums\Tables;

/**
 * Class m241011_002748_short_url_view
 */
class m241011_002748_short_url_view extends CoreMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable(Tables::SHORT_URL_VIEW->value, [
            'id' => $this->uuidPk(),
            'short_url_id' => $this->uuid()->notNull(),
            'ip' => $this->string(16)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
        ]);

        $this->addForeignKey(
            'FK_ShortUrlView__ShortUrl',
            Tables::SHORT_URL_VIEW->value,
            'short_url_id',
            Tables::SHORT_URL->value,
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
        $this->dropTable(Tables::SHORT_URL_VIEW->value);
    }
}
