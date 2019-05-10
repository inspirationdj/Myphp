<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
     echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => '首页', 'url' => ['/home/index']],
            ['label' => '联系我们', 'url' => ['/site/contact']],
            ['label' => '注册', 'url' => ['/signup/sign']],
            Yii::$app->user->isGuest ? (
                ['label' => '登录', 'url' => ['/login/denglu']]
            ): (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    '退出 (' . Yii::$app->user->identity->tg_username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);

     if(Yii::$app->user->can('admin'))
     {
         echo Nav::widget([
             'options' => ['class' => 'navbar-nav navbar-right'],
             'items' => [
                 ['label' => '管理员', 'url' => ['/adminuser/index']],
                 ['label' => '用户管理', 'url' => ['/user/index']],
                 ['label' => '文章管理', 'url' => ['/post/index']],
                 ['label'=>'分类管理',],
             ],
         ]);
     }elseif (Yii::$app->user->can('postAdmin'))
     {  echo Nav::widget([
         'options' => ['class' => 'navbar-nav navbar-right'],
         'items' => [
         ['label' => '文章管理', 'url' => ['/post/index']],
         ]
         ]);
     }

    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
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
