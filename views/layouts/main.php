<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'CMS',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            [
                'label' => 'Галерея',
                'items' => [
                    [
                        'label' => 'Фронтенд - Галерея', 
                        'url' => ['/gallery/gallery-image'],
                        'active' => (strpos($this->context->route, 'gallery/gallery-image') === 0)
                    ],
                    '<li class="divider"></li>',
                    [
                        'label' => 'Бэкенд - Рейтинги', 
                        'url' => ['/admin/gallery/gallery-rating'],
                        'active' => (strpos($this->context->route, 'admin/gallery/gallery-rating') !== false)
                    ],
                    [
                        'label' => 'Бэкенд - Изображения', 
                        'url' => ['/admin/gallery/gallery-image'],
                        'active' => (strpos($this->context->route, 'admin/gallery/gallery-image') !== false)
                    ],
                    [
                        'label' => 'Бэкенд - Теги', 
                        'url' => ['/admin/gallery/gallery-tag'],
                        'active' => (strpos($this->context->route, 'admin/gallery/gallery-tag') !== false)
                    ],
                ],
            ],
            [
                'label' => 'Блог',
                'items' => [
                    [
                        'label' => 'Фронтенд - Блог', 
                        //'url' => ['/gallery/gallery-image'],
                        //'active' => (strpos($this->context->route, 'gallery/gallery-image') === 0)
                    ],
                    '<li class="divider"></li>',
                    [
                        'label' => 'Бэкенд - Блог', 
                        //'url' => ['/admin/gallery/gallery-rating'],
                        //'active' => (strpos($this->context->route, 'admin/gallery/gallery-rating') !== false)
                    ],
                ],
            ],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/user/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
