<?php

use app\enums\Tables;
use yii\db\Migration;

/**
 * Class m241011_002748_short_url_view
 */
class m241011_002748_short_url_view extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable(Tables::SHORT_URL_VIEW->value, [
            'id' => $this->string(36),
            'short_url_id' => $this->string(36),
            'created_at' => $this->dateTime()->notNull(),
        ]);

        $this->addPrimaryKey('id', Tables::SHORT_URL_VIEW->value, 'id');

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
