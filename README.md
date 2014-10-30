# Yii2 HTTP authorization filter.

## Usage example

Users credentials are represented as an associative array which may be defined in two different ways. You may either specify the `users` property of the filter or the application parameter `Yii::$app->params['users']`.

~~~php
public function behaviors()
{
    return
    [
        [
            'class' => 'kolyunya\yii2\filters\HttpAuthorization',
            'users' =>
            [
                'user-1' => 'password-1',
                'user-2' => 'password-2'
            ]
        ]
    ];
}
~~~