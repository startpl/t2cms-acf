<?php

/**
 * @link https://github.com/t2cms/sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace startpl\t2cms\acf\backend\assets;

/**
 * AssetBundle
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class AssetBundle extends \yii\web\AssetBundle
{
    /**
     * @inherit
     */
    public $sourcePath = __DIR__;
    
    /**
     * @inherit
     */
    public $css = [
        'css/style.css',
    ];
    
    /**
     * @inherit
     */
    public $js = [
        'js/acf.js',
    ];
    
    /**
     * @inherit
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        't2cms\T2Asset'
    ];
}
