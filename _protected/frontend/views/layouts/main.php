<?php
use frontend\assets\AppAsset;
use frontend\assets\FontAwesomeAsset;
use frontend\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
FontAwesomeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <? $this->beginBody() ?>
    <div class="container-fluid main-container">
        <div class="row">
            <div id="top-menu" class="col-xs-21 col-xs-offset-3 col-sm-22 col-sm-offset-1 col-md-20 col-md-offset-2">
                <nav class="navbar navbar-default">
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="" id="top-navbar-collapse">
                        <!-- <form class="navbar-form navbar-left" role="search">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Search"></div>
                            <button type="submit" class="btn btn-default">Submit</button>
                        </form> -->
                        <ul class="nav navbar-nav">
                            <li id="facebook-icon" class="active">
                                <a href="#">
                                    <!-- <img src="images/icons/facebook_icon.png" height="20"/>
                                    <span class="sr-only">(current)</span>
                                    -->
                                    <span>
                                        <i class="fa fa-facebook"></i>
                                    </span>
                                </a>
                            </li>
                            <li id="twitter-icon">
                                <a href="#">
                                <!-- <img src="images/icons/twitter_icon.png" height="20"/>
                                -->
                                <span>
                                    <i class="fa fa-twitter"></i>
                                </span>
                                </a>
                            </li>
                            <li id="google-plus-icon">
                                <a href="#">
                                    <!-- <img src="images/icons/google_plus_icon.png" height="20"/>
                                    -->
                                    <span>
                                        <i class="fa fa-google-plus"></i>
                                    </span>
                                </a>
                            </li>
                            <li id="user-icon" class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <span aria-hidden="true">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#">Action</a>
                                    </li>
                                    <li>
                                        <a href="#">Another action</a>
                                    </li>
                                    <li>
                                        <a href="#">Something else here</a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="#">Separated link</a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="#">One more separated link</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <!-- <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        </button>
                        -->
                        <a class="navbar-brand" href="/">
                            <? $logo_img = Yii::getAlias('@web') . '/themes/noda/images/noda_logo.png'; ?>
                            <?= Html::img($logo_img) ?>
                        </a>
                    </div>
                </nav>
            </div>
        </div>
        <div class="row">
            <div id="logo-mobile" class="col-xs-6 visible-xs-block">
                <?= Html::img($logo_img) ?>
            </div>
            <div id="company-address" class="col-xs-12 col-xs-offset-5 col-sm-8 col-sm-offset-14 text-right">
                <div class="row">
                    <div class="col-sm-24">
                        <span>
                            <i class="fa fa-phone"></i>
                        </span>
                        <span>1-888-000-0000</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-24">
                        <span>Call request</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="side-menu" class="col-xs-24 col-sm-7 col-sm-offset-1 col-md-6 col-md-offset-2">
                <nav class="navbar navbar-default" role="navigation">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle pull-left" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <!-- <a class="navbar-brand" href="#">Brand</a>
                    -->
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active">
                            <a href="#">Earrings</a>
                        </li>
                        <li>
                            <a href="#">Necklaces</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                Rings <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#">Action</a>
                                </li>
                                <li>
                                    <a href="#">Another action</a>
                                </li>
                                <li>
                                    <a href="#">Something else here</a>
                                </li>
                                <li>
                                    <a href="#">Separated link</a>
                                </li>
                                <li>
                                    <a href="#">One more separated link</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="#">Sets</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                Broaches <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#">Action</a>
                                </li>
                                <li>
                                    <a href="#">Another action</a>
                                </li>
                                <li>
                                    <a href="#">Something else here</a>
                                </li>
                                <li>
                                    <a href="#">Separated link</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search"></div>
                    <button type="submit" class="btn btn-warning">Submit</button>
                </form>
                <!-- /.navbar-collapse --> </nav>
            </div>
            <div id="main-content" class="col-xs-24 col-sm-15 col-md-14 col-md-offset-0">
                <?= $content; ?>
            </div>
        </div>
        <div class="row footer">
            <div class="col-xs-6 col-xs-offset-10">
                Copyright &copy; <?= date('Y'); ?> NodaArt Inc.
            </div>
        </div>
    </div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->
endPage() ?>