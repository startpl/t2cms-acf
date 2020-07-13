<?php

/**
 * @link https://github.com/t2cms/sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace startpl\t2cms\acf\backend\widgets;

use yii\helpers\Html;
use startpl\t2cms\acf\common\models\AcfGroupAssign;
use startpl\t2cms\acf\common\repositories\AcfGroupAssignRepository;
use \startpl\t2cms\acf\backend\widgets\base\{
    GroupSelect,
    GroupCheckbox
};

/**
 * Widget domains list, changes admin domain for controll content
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class AcfContainer extends \yii\base\Widget
{
    public $model = null;
    
    private $assignModel = null;    
    

    public function run(): string 
    {
        parent::run();
        $view = $this->getView();
        \startpl\t2cms\acf\backend\assets\AssetBundle::register($view);
        
        return $this->renderSection();
    }
    
    public function init() {
        parent::init();
        
        $this->assignModel = \startpl\t2cms\acf\backend\useCases\GroupAssign::getAssignModel($this->model);
    }
    
    private function renderSection(): string
    {
        $section  = GroupSelect::render('group_id', 'ACF Grpoup for category', $this->assignModel->group_id);
        $section .= GroupCheckbox::render('apply_subcategories', 'Apply for subcategories', $this->assignModel->apply_subcategories);
        $section .= Html::tag('hr');
        $section .= GroupSelect::render('group_for_pages', 'Pages ACF Group', $this->assignModel->group_for_pages);
        $section .= GroupCheckbox::render('apply_subcategories_group_pages', 'Apply for subcategories', $this->assignModel->apply_subcategories_group_pages);
        return $section;
    }
}
