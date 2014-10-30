# Yii2 HTTP authorization filter.

## Usage example

You may specify users credentials in the `behaviors` method like this. Otherwise users credentials will be retrieved from the `Yii::$app->params['users']` array.

~~~php
public function behaviors()
{
    return
    [
        [
            'class' => 'kolyunya\yii2\filters\HttpAuthorization',
            'users' =>
            [
                'foo' => 'bar',
                'baz' => 'quux'
            ]
        ]
    ];
}
~~~