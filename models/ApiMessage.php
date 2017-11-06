<?php
/**
 * Created by PhpStorm.
 * User: Buzyka
 * Date: 06-Nov-17
 * Time: 9:35
 */

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\InvalidParamException;
use yii\base\InvalidCallException;

/**
 * Class MailBox
 *
 * @package app\models
 * @property bool $wasRead
 * @property bool $wasArchived
 */
class ApiMessage extends \app\models\Message
{
    const MESSAGE_TYPE_ARCHIVED = 'archived';
    const MESSAGE_TYPE_ACTIVE = 'active';
    const MESSAGE_TYPE_ALL = 'all';

    protected static $mailBoxId = null;

    /**
     * Sets the mailbox Id (similar to user id)
     *
     * @param int $id
     */
    public static function setMailBoxId($id)
    {
        self::$mailBoxId = $id;
    }

    /**
     * Find data in mailbox
     *
     * @return ActiveQuery the newly created [[ActiveQuery]] instance.
     * @throws InvalidCallException
     */
    public static function findInMailBox()
    {
        if (!is_null(self::$mailBoxId)) {
            return parent::find()->where(['uid' => self::$mailBoxId]);
        } else {
            throw new InvalidCallException('Undefined value MailBoxId');
        }
    }

    /**
     * Get message by id
     *
     * @param $id
     * @return ApiMessage|null
     */
    protected static function findMessage($id)
    {
        return self::findInMailBox()->andWhere(['id' => $id])->one();
    }

    /**
     * Get mailbox message list
     *
     * @param string $type
     * @return ActiveDataProvider
     * @throws InvalidParamException
     */
    public static function messageList($type)
    {
        $query = self::findInMailBox()
            ->select(
                [
                    'id',
                    'sender',
                    'subject',
                    'time_sent',
                    'time_archived',
                    'time_read'
                ]);

        switch($type){
            case self::MESSAGE_TYPE_ALL:
                break;
            case self::MESSAGE_TYPE_ACTIVE:
                $query->andWhere(['time_archived' => null]);
                break;
            case self::MESSAGE_TYPE_ARCHIVED:
                $query->andWhere(['not', ['time_archived' => null]]);
                break;
            default:
                throw new InvalidParamException('Unsupported value in Message Type parameter');
        }

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['apiListPageSize'],
            ]
        ]);

        return $provider;
    }

    public static function messageShow($id)
    {
        return self::findInMailBox()->andWhere(['id' => $id])->one();
    }

    /**
     * Customize property list for API
     *
     * This list is different from base model, because API required get just read and archived status,
     * but base class functionality wider (it provide change status time it could be useful in future but not now)
     *
     * @return array
     */
    public function fields()
    {
        $fields = parent::fields();

        unset($fields['time_sent'], $fields['time_read'], $fields['time_archived'], $fields['uid']);

        $fields['timeSent'] = 'time_sent';
        $fields['wasRead'] = 'wasRead';
        $fields['wasArchived'] = 'wasArchived';

        return $fields;
    }

    /**
     * Was Read virtual property
     *
     * @return bool
     */
    public function getWasRead()
    {
        if (!is_null($this->time_read)){
            return true;
        }
        return false;
    }

    /**
     * Was Archived virtual property
     *
     * @return bool
     */
    public function getWasArchived()
    {
        if (!is_null($this->time_archived)){
            return true;
        }
        return false;
    }
}