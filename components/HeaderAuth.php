<?php
/**
 * Created by PhpStorm.
 * User: Buzyka
 * Date: 05-Nov-17
 * Time: 16:10
 */

namespace app\components;

use yii\filters\auth\AuthMethod;

/**
 * HeaderAuth is an action filter that supports the authentication based on the access token passed through a header.
 */
class HeaderAuth extends AuthMethod
{
    /**
     * @var string the parameter name for passing the access token
     */
    public $tokenHeader = 'X-MailBox-access-token';

    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        $accessToken = $request->getHeaders()->get($this->tokenHeader);
        if (is_string($accessToken)) {
            $identity = $user->loginByAccessToken($accessToken, get_class($this));
            if ($identity !== null) {
                return $identity;
            }
        }
        if ($accessToken !== null) {
            $this->handleFailure($response);
        }

        return null;
    }
}