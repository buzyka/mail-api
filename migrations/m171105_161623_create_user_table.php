<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `user`.
 */
class m171105_161623_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => Schema::TYPE_STRING . '(100) NOT NULL',
            'password' => Schema::TYPE_STRING . '(255) NOT NULL',
            'auth_key' => Schema::TYPE_STRING . '(255) NOT NULL',
            'access_token' => Schema::TYPE_STRING . '(255) NOT NULL',
        ], $tableOptions);

        $this->createIndex('uniq_user_name', 'user', 'username', true);
        $this->createIndex('uniq_auth_key', 'user', 'auth_key', true);
        $this->createIndex('uniq_access_token', 'user', 'access_token', true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
