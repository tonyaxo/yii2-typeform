<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Typeform.com Extension for Yii 2</h1>
    <br>
</p>

Typeform.com yii2 integration

[![Build Status](https://travis-ci.org/tonyaxo/yii2-typeform.svg?branch=master)](https://travis-ci.org/tonyaxo/yii2-typeform)

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