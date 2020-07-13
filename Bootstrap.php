<?php

/**
 * @link https://github.com/t2cms/sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace startpl\t2cms\acf;

use startpl\t2cms\acf\backend\BackendBootstrap;
use t2cms\module\helpers\ModuleHelper;

/**
 * Modulegithub.com/t2cms/sitemanager
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */

class Bootstrap implements \yii\base\BootstrapInterface
{   
    public function bootstrap($app) 
    {
        if(!ModuleHelper::isActive('t2cms-acf')) return false;
        
        if($app->id === 'app-backend') {
            BackendBootstrap::bootstrap($app);
        }
    }
}