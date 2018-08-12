yii2-typeform
=============
Typeform.com yii2 integration

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist tonyaxo/yii2-typeform "*"
```

or add

```
"tonyaxo/yii2-typeform": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
// SiteController.php
public function actions()
{
    return [
        'index' => [
            'class' => 'tonyaxo\yii2typeform\AuthAction',
            'successCallback' => [$this, 'onAuthSuccess'],
        ],
    ];
}
```

```php
// auth-view.php
<?= \tonyaxo\yii2typeform\widgets\Auth::widget([
        'baseAuthUrl' => ['/authorize/index'],
        'linkOptions' => [
                'class' => 'btn btn-info'
        ]
]);
```

```php
// user.php
class MyTypeForm extends EmbeddedTypeForm
{
    const BASE_FORM_URL = 'https://myaccount.typeform.com/to/';

    public $type = EmbeddedTypeForm::TYPE_POPUP;

    /**
     * @param mixed $id
     */
    public function setFormId(?string $id): void
    {
        if ($id !== null) {
            $this->setUrl(self::BASE_FORM_URL . $id);
        }
    }
}
```