<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `mail_message`.
 */
class m171103_154402_create_message_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('message', [
            'id'        => $this->primaryKey(),
            'uid'       => Schema::TYPE_INTEGER . ' NOT NULL',
            'sender'    => Schema::TYPE_STRING . '(255) NOT NULL',
            'time_sent' => Schema::TYPE_INTEGER . ' NOT NULL',
            'time_read' => Schema::TYPE_INTEGER . ' NULL',
            'time_archived' => Schema::TYPE_INTEGER . ' NULL',
            'subject'   => Schema::TYPE_TEXT,
            'message'   => Schema::TYPE_TEXT
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('message');
    }
}
