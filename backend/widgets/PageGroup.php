<?php

/**
 * @link https://github.com/t2cms/sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace startpl\t2cms\acf\backend\widgets;

use yii\helpers\Html;
use startpl\t2cms\acf\backend\useCases\GroupAssign;
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
class PageGroup extends \yii\base\Widget
{
    public $model = null;
    
    private $assignModel = null;    
    

    public function run(): string 
    {
        parent::run();
        $view = $this->getView();
        \startpl\t2cms\acf\backend\assets\AssetBundle::register($view);
        
        $domain_id = \t2cms\sitemanager\components\Domains::getEditorDomainId();
        $language_id = \t2cms\sitemanager\components\Languages::getEditorLangaugeId();
        
        $view->registerJsVar(
            'ACF_URL', 
            \yii\helpers\Url::to([
                '/module/acf/ajax', 
                'domain' => $domain_id, 
                'language' => $language_id
            ])
        );
        
        return $this->renderSection();
    }
    
    public function init() 
    {
        parent::init();
        
        $this->assignModel = GroupAssign::getAssignModel($this->model);
    }
    
    private function renderSection(): string
    {
        $group_id = ($this->assignModel->src_id === $this->model->id)
            ? $this->assignModel->group_id : null;
        
        $section  = GroupSelect::render('group_id', 'ACF Grpoup for category', $group_id);
        
        return $section;
    }

}
