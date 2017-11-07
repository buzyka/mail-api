<?php

use yii\db\Migration;

/**
 * Class m171103_160930_seed_messages
 */
class m171103_160930_seed_messages extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $samplePath = \Yii::getAlias('@app/task/messages_sample.json');

        if (is_readable($samplePath)) {
            $seeds = json_decode(file_get_contents($samplePath), true);

            $affectedRows = \Yii::$app->db->createCommand()->batchInsert(
                'message',
                [
                    'uid',
                    'sender',
                    'subject',
                    'message',
                    'time_sent',
                ],
                $seeds['messages']
            )->execute();

            if (!$affectedRows){
                return false;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        \Yii::$app->db->createCommand()->delete('message')->execute();
        return true;
    }
}
