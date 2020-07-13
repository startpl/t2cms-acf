<?php

/**
 * @link https://github.com/startpl/t2cms-module
 * @copyright Copyright (c) 2020 Koperdog
 * @license https://github.com/startpl/t2cms-module/blob/master/LICENSE
 */

namespace startpl\t2cms\acf;

use t2cms\module\interfaces\IModuleInstall;
use startpl\t2cms\acf\backend\migrations\ACFMigration;

/**
 * Module install class
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class ModuleInstall implements IModuleInstall
{    
    public function install(): bool
    {
        $migration = new ACFMigration();
        
        return $migration->safeUp();
    }
    
    public function uninstall(): bool
    {
        $migration = new ACFMigration();
        
        return $migration->safeDown();
    }
    
    public function activate(): bool
    {
        // do something during activating
        return true;
    }
    
    public function deactivate(): bool
    {
        // do something during deactivating
        return true;
    }
    
    public function update(): bool
    {
        // do something for update Module
        return true;
    }
}