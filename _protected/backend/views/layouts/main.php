<?php
use backend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use kartik\nav\NavX;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
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
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => Yii::t('app', Yii::$app->name),
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-default navbar-fixed-top',
                ],
            ]);

            // display Account and Users to admin+ roles
            if (Yii::$app->user->can('admin'))
            {
                $menuItems[] = [
                    'label' => Yii::t('app', 'Users'),
                    'items' => [
                        [
                            'label' => Yii::t('backend', 'User List'),
                            'url' => ['/user']
                        ],
                        [
                            'label' => Yii::t('backend', 'Create new user'),
                            'url' => ['/user']
                        ],
                        [
                            'label' => Yii::t('backend', 'User profiles'),
                            'items' => [
                                [
                                    'label' => Yii::t('backend', 'Profile list'),
                                    'url' => ['/profile']
                                ],
                                [
                                    'label' => Yii::t('backend', 'Create new profile'),
                                    'url' => ['/profile/create']
                                ],
                            ]
                        ],
                    ]
                ];
            }

            if (Yii::$app->user->can('editor')) {
                $menuItems[] = [
                    'label' => Yii::t('backend', 'Products'),
                    'items' => [
                        [
                            'label' => 'Product list',
                            'url' => ['/product']
                        ],
                        [
                            'label' => 'Create product',
                            'url' => ['/product/create']
                        ],
                        [
                            'label' => 'Product categories',
                            'items' => [
                                [
                                    'label' => 'Category list',
                                    'url' => ['/product-category']
                                ],
                                [
                                    'label' => 'Create new category',
                                    'url' => ['/product-category/create']
                                ],
                            ]
                        ],
                        [
                            'label' => 'Colors',
                            'items' => [
                                [
                                    'label' => 'Color list',
                                    'url' => ['/color']
                                ],
                                [
                                    'label' => 'Create new color',
                                    'url' => ['/color/create']
                                ],
                            ]
                        ],
                    ],
                ];
                $menuItems[] = [
                    'label' => Yii::t('backend', 'Purchase orders'),
                    'items' => [
                        [
                            'label' => 'PO list',
                            'url' => ['/purchase-order']
                        ],
                        [
                            'label' => 'Create PO',
                            'url' => ['/purchase-order/create']
                        ],
                    ],
                ];
                $menuItems[] = [
                    'label' => Yii::t('backend', 'Suppliers'),
                    'items' => [
                        [
                            'label' => 'Supplier list',
                            'url' => ['/supplier']
                        ],
                        [
                            'label' => 'Add new supplier',
                            'url' => ['/supplier/create']
                        ],
                    ],
                ];
            }
            
            // display Login page to guests of the site
            if (Yii::$app->user->isGuest) 
            {
                $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
            }
            // display Logout to all logged in users
            else 
            {
                $menuItems[] = [
                    'label' => Yii::t('app', 'Logout'). ' (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }

            echo NavX::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            
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
        <p class="pull-left">&copy; <?= Yii::t('app', Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>

    <?    
    $this->registerJs('

        // Обработчик события для удаления загруженных файлов
        $(".removeFile").on("click", function(e) {
            e.preventDefault();
            // console.log("clicked on RemoveFile link with id # " + $(this).attr("href"));
            // получим значение id модели файла, которую мы хотим удалить
            var id = this.dataset.id;
            console.log("The id is " + id);

            $.ajax({
                url: "/backend/product-picture/delete-file",
                method: "post",
                context: this,
                dataType: "json",
                data: {id: id},
            }).done(function(data) {
                console.log(data);
                console.log($(this));
                if (data) {
                    console.log("The file with id " + id + " was deleted successfully!");
                    $(this).closest("tr").remove();
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                alert("Error! Check console for details!");
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
                    
        });

    ', $this::POS_END);
    ?>
</body>
</html>
<?php $this->endPage() ?>
