<?php

namespace app\controllers;

use yii\filters\auth\QueryParamAuth;
use app\components\HeaderAuth;

class BaseAPIController extends \yii\rest\Controller
{
    /**
     * Add authentification using behaviors
     *
     * @todo move it in base class
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authentificator'] = [
            //'class' => QueryParamAuth::className(),
            'class' => HeaderAuth::className(),
        ];
        return $behaviors;
    }
}
