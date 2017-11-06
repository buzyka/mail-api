<?php

namespace app\controllers;

use Yii;
use app\models\ApiMessage;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\web\UnprocessableEntityHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class MessageController extends \app\controllers\BaseAPIController
{
    const WAS_READ = 'read';
    const WAS_ARCHIVED = 'archived';

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $status = parent::beforeAction($action);
        ApiMessage::setMailBoxId(Yii::$app->user->id);
        return $status;
    }

    /**
     * Get list of messages from mailbox
     *
     * @param string $type
     * @return \yii\data\ActiveDataProvider
     * @throws UnprocessableEntityHttpException
     */
    public function actionList($type='active')
    {
        try {
            $response = ApiMessage::messageList($type);
        } catch (InvalidParamException $e){
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
        return $response;
    }

    /**
     * Show message
     *
     * @param int $id
     * @return ApiMessage
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionShow($id)
    {
        return $this->showMessageAndUpdateStatus($id);
    }

    /**
     * Read message
     *
     * @param int $id
     * @return ApiMessage
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionRead($id)
    {
        return $this->showMessageAndUpdateStatus($id, self::WAS_READ);
    }

    /**
     * Archive message
     *
     * @param int $id
     * @return ApiMessage
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionToArchive($id)
    {
        return $this->showMessageAndUpdateStatus($id, self::WAS_ARCHIVED);
    }

    /**
     * Get message object and update status if it need
     *
     * @param int $id
     * @param null $newStatus can be self::WAS_READ, self::WAS_ARCHIVED or null
     * @return ApiMessage
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    private function showMessageAndUpdateStatus($id, $newStatus=null)
    {
        if (is_null($message = ApiMessage::messageShow($id))){
            throw new NotFoundHttpException('Message id: ' . $id . ' was not found in this mailbox');
        }
        try {
            switch ($newStatus) {
                case self::WAS_READ:
                    $message->inRead();
                    break;
                case self::WAS_ARCHIVED:
                    $message->toArchive();
                    break;
            }
        } catch (Exception $e){
            throw new ServerErrorHttpException($e->getMessage());
        }
        return $message;
    }
}
