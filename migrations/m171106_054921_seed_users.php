<?php

use yii\db\Migration;

/**
 * Class m171106_054921_seed_users
 */
class m171106_054921_seed_users extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $userIds = \Yii::$app->db->createCommand('SELECT DISTINCT uid FROM message')->queryAll();
        $seedData = [];
        foreach ($userIds as $userId){
            $uid = $userId['uid'];
            $seedData[] = [
                'id' => $uid,
                'username' => 'user' . $uid,
                'password' => 'password' . $uid,
                'auth_key' => 'auth' . $uid . 'key',
                'access_token' => 'accessToken' . $uid,
            ];
        }

        $affectedRows = \Yii::$app->db->createCommand()->batchInsert(
            'user',
            [
                'id',
                'username',
                'password',
                'auth_key',
                'access_token',
            ],
            $seedData
        )->execute();

        if (!$affectedRows){
            return false;
        }


    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        \Yii::$app->db->createCommand()->delete('user')->execute();
    }
}
