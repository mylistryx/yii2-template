<?php

use app\components\migrations\CoreMigration;

class m241009_112031_identity extends CoreMigration
{
    private string $tableName = 'identity';

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable($this->tableName, [
            'id' => $this->string(36)->notNull(),
            'email' => $this->string(64)->notNull()->unique(),
            'password_hash' => $this->string(64)->notNull(),
            'auth_key' => $this->string(64)->notNull()->unique(),
            'current_status' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('id', $this->tableName, 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable($this->tableName);
    }
}
