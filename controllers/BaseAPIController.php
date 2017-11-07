<?php

namespace app\controllers;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use app\components\HeaderAuth;

/**
 * Base controller API should be inherited by all APIs controllers.
 *
 * This Controller is implementing authentication and could be extended in future
 *
 * @package app\controllers
 */
abstract class BaseAPIController extends \yii\rest\Controller
{
    /**
     * Add authentification using behaviors
     *
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authentificator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HeaderAuth::className(),
                QueryParamAuth::className(),
            ],
        ];
        return $behaviors;
    }
}
