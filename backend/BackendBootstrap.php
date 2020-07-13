<?php

/**
 * @link https://github.com/t2cms/sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/startpl/t2cms-core/sitemanager/blob/master/LICENSE
 */

namespace startpl\t2cms\acf\backend;

use yii\helpers\Html;
use startpl\t2cmsblog\interfaces\IEventRepository;
use startpl\t2cmsblog\hooks\{
    CategoryForm,
    PageForm
};
use startpl\t2cms\acf\backend\factories\FieldValueServiceFactory;

/**
 * Modulegithub.com/t2cms/sitemanager
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */

class BackendBootstrap
{        
    const MODULE_NAME = "acf";
    
    public static function bootstrap($app) 
    {
        self::registerTranslations($app);
        
        self::hookBlogUpdate();
        if(preg_match('/^\/?blog\/(default)\/(update|create)\/?/i', trim($app->request->pathInfo, '/'))) {
            self::hookCategoryUpdate();
        } else if (
            preg_match('/^\/?blog\/(pages)\/(update|create)\/?/i', trim($app->request->pathInfo, '/'))
        ) {
            self::hookPageUpdate();
        }
    }
    
    protected static function hookBlogUpdate()
    {    
        \yii\base\Event::on('\startpl\t2cmsblog\interfaces\IEventRepository', IEventRepository::EVENT_SAVE, function($event){
            $domain_id = \t2cms\sitemanager\components\Domains::getEditorDomainId();
            $language_id = \t2cms\sitemanager\components\Languages::getEditorLangaugeId();
                        
            useCases\GroupAssign::assign($event->model);
            FieldValueServiceFactory::getService()->save($event->model, $domain_id, $language_id);
        });
    }
    
    protected static function hookCategoryUpdate()
    {
        \yii\base\Event::on('\startpl\t2cmsblog\interfaces\IEventRepository', IEventRepository::EVENT_SHOW, function($event){
            $model = $event->model;
            
            if($model !== null) {
                $assign = useCases\GroupAssign::getAssignModel($event->model);
//                debug($assign);
                $data = [
                    'srcType' => $model::SOURCE_TYPE,
                    'srcId'   => $model->id,
                    'groupId' => $assign->group_id
                ];
            }
            
            CategoryForm::addSection(
                \Yii::t('acf', 'Advanced Custom Fields'),
                Html::tag('div', '', [
                    'id' => 'acf_container', 
                    'data' => $data
                ])
            );
            
            CategoryForm::addSectionToMain(
                \Yii::t('acf', 'Advanced Custom Fields'), 
                \startpl\t2cms\acf\backend\widgets\CategoryGroup::widget(['model' => $model])
            );
            
        });
    }
    
    
    
    protected static function hookPageUpdate()
    {
        \yii\base\Event::on('\startpl\t2cmsblog\interfaces\IEventRepository', IEventRepository::EVENT_SHOW, function($event){
            $model = $event->model;
            if($model !== null) {
                $assign = useCases\GroupAssign::getAssignModel($event->model);
                
                $data = [
                    'srcType' => $model::SOURCE_TYPE,
                    'srcId'   => $model->id,
                    'groupId' => ($assign->src_id == $model->id? $assign->group_id : $assign->group_for_pages)
                ];
            }
            
            PageForm::addSection(
                \Yii::t('acf', 'Advanced Custom Fields'),
                Html::tag('div', '', [
                    'id' => 'acf_container', 
                    'data' => $data
                ])
            );
            PageForm::addSectionToMain(
                \Yii::t('acf', 'Advanced Custom Fields'), 
                \startpl\t2cms\acf\backend\widgets\PageGroup::widget(['model' => $model])
            );
            
        });
    }
    
    private static function registerTranslations($app)
    {
        if (!isset($app->i18n->translations[self::MODULE_NAME . '*'])) {
            
            $app->i18n->translations[self::MODULE_NAME . '*'] = [
                'class'    => \yii\i18n\PhpMessageSource::class,
                'basePath' => dirname(__DIR__) . '/messages',
                'fileMap'  => [
                    self::MODULE_NAME . "/error" => "error.php", 
                ],
            ];
        }
    }
}