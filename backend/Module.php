<?php

/**
 * @link https://github.com/t2cms/t2cms-core
 * @copyright Copyright (c) 2020 Koperdog
 * @license https://github.com/startpl/t2cms-core/blob/master/LICENSE
 */

namespace startpl\t2cms\acf\backend;

/**
 * Advanced Custom Fields module
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class Module extends \yii\base\Module
{
    const MODULE_NAME = "acf";
    
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'startpl\t2cms\acf\backend\controllers';
}
