<?php

namespace kolyunya\yii2\filters;

use Yii;
use yii\base\ActionFilter;

class HttpAuthorization extends ActionFilter
{

    public $users;

    public function beforeAction ( $action )
    {

        if ( ! self::authenticationTokenReceived() )
        {
            self::sendAuthenticationRequest();
            return false;
        }

        if ( ! $this->validateAuthenticationToken() )
        {
            self::sendAuthenticationRequest();
            return false;
        }

        return true;

    }

    private function validateAuthenticationToken()
    {

        $tokenReceived = Yii::$app->request->headers->get('Authorization');
        $tokenReceived = str_replace('Basic ','',$tokenReceived);

        if ( ! isset($this->users) )
        {
            $this->users = Yii::$app->params['users'];
        }

        foreach ( $this->users as $username => $password )
        {
            $token = self::makeAuthenticationToken($username,$password);
            if ( $tokenReceived === $token )
            {
                return true;
            }
        }

        return false;

    }

    private static function authenticationTokenReceived()
    {
        $authenticationTokenReceived = Yii::$app->request->headers->has('Authorization');
        return $authenticationTokenReceived;
    }

    private static function sendAuthenticationRequest()
    {
        Yii::$app->response->setStatusCode(401,'Not Authorized');
        Yii::$app->response->headers->set('WWW-Authenticate','Basic realm="Relaxound"');
        Yii::$app->response->send();
    }

    private static function makeAuthenticationToken ( $username , $password )
    {
        $tokenDecoded = "$username:$password";
        $tokenEncoded = base64_encode($tokenDecoded);
        return $tokenEncoded;
    }

}
