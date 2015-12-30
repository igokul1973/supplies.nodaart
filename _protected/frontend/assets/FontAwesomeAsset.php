<?php
/**
 * -----------------------------------------------------------------------------
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * -----------------------------------------------------------------------------
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use Yii;

// set @themes alias so we do not have to update baseUrl every time we change themes
Yii::setAlias('@themes', Yii::$app->view->theme->baseUrl);

class FontAwesomeAsset extends AssetBundle 
{
    public $basePath = '@webroot'; 
    public $baseUrl = '@themes';

    public $css = [ 
        'font-awesome-4.5.0/css/font-awesome.css', 
    ];
    public $publishOptions = [
        'only' => [
            'fonts/',
            'css/',
        ]
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}