<?php

namespace app\models;

use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "mail_message".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $sender
 * @property int $time_sent
 * @property int $time_read
 * @property int $time_archived
 * @property string $subject
 * @property string $message
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'sender'], 'required'],
            [['uid', 'time_sent', 'time_read', 'time_archived'], 'integer'],
            [['subject', 'message'], 'string'],
            [['sender'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'sender' => 'Sender',
            'time_sent' => 'Time Sent',
            'time_read' => 'Time Read',
            'time_archived' => 'Time Archived',
            'subject' => 'Subject',
            'message' => 'Message',
        ];
    }

    /**
     * Mark message as read
     *
     * @throws Exception
     */
    public function inRead()
    {
        if (is_null($this->time_read)) {
            $this->time_read = time();
            if (!$this->save()){
                throw new Exception('Message ' . $this->id . ' can\'t be updated with new status');
            }
        }
    }

    /**
     * Mark message as archived
     *
     * @throws Exception
     */
    public function toArchive()
    {
        if (is_null($this->time_archived)) {
            $this->time_archived = time();
            if (!$this->save()){
                throw new Exception('Message ' . $this->id . ' can\'t be moved ti archive');
            }
        }
    }
}
