<?php

use app\components\migrations\CoreMigration;
use app\enums\Tables;

class m241009_120949_identity_token extends CoreMigration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable(Tables::IDENTITY_TOKEN->value, [
            'id' => $this->string(36)->notNull(),
            'identity_id' => $this->string(36)->notNull(),
            'token' => $this->string(64)->notNull()->unique(),
            'token_type' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
        ]);

        $this->addPrimaryKey(
            'id',
            Tables::IDENTITY_TOKEN->value,
            'id',
        );

        $this->createIndex(
            'IdentityTokenType',
            Tables::IDENTITY_TOKEN->value,
            'type',
        );

        $this->createIndex(
            'IdentityTokenCreatedAt',
            Tables::IDENTITY_TOKEN->value,
            'created_at',
        );

        $this->addForeignKey(
            'FK_IdentityToken__Identity',
            Tables::IDENTITY_TOKEN->value,
            'identity_id',
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
        $this->dropTable(Tables::IDENTITY_TOKEN->value);
    }
}