<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace startpl\t2cms\acf\backend\useCases;

use \yii\base\Model;
use startpl\t2cms\acf\common\models\AcfGroupAssign;
use \startpl\t2cms\acf\common\repositories\AcfGroupAssignRepository;
use startpl\t2cmsblog\models\Category;

/**
 * Description of GroupAssign
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class GroupAssign 
{ 
    public static function assign(Model $srcModel) {
        $data = array_filter(\Yii::$app->request->post('ACF')['settings']);
                
        if(!$data) return false;
              
        try {
            $model = self::getOwnAssignModel($srcModel);
            self::loadModel($model, $data, $srcModel::SOURCE_TYPE);
            AcfGroupAssignRepository::save($model);
        } catch (\Exception $e) {
            // nothing to do
        }
    }
    
    public static function get($srcModel): ?AcfGroupAssign
    {
        $srcId  = $srcModel->id;
        $srcType = $srcModel::SOURCE_TYPE;
        $srcNode = $srcModel::NODE_TYPE;
        try {
            if(!$own = self::getOwn($srcId, $srcType)) {
                foreach($srcModel->getParents() as $parent) {
                    if(!is_object($parent)) continue;
                    if($model = self::getOwn($parent->id, $parent::SOURCE_TYPE)) {
                        if($srcNode === 'NODE') {
                            $isSuitable = (bool)$model->apply_subcategories;
                        } else {
                            $isSuitable = (bool)$model->apply_subcategories_group_pages;
                        }
                        
                        if($isSuitable) {
                            return $model;
                        }
                    }
                }
            } else {
                return $own;
            }
        } catch (\DomainException $e) {
            return null;
        }
        
        return null;
    }
    
    public static function getOwn(int $srcid, int $srcType): ?AcfGroupAssign
    {
        try {
            $model = AcfGroupAssignRepository::get($srcid, $srcType);
        } catch (\DomainException $e) {
            return null;
        }
        
        return $model;
    }
    
    private static function loadModel(Model $model, array $data, int $type = null): void
    {
        if($type === Category::SOURCE_TYPE) {
            $model->apply_subcategories = (bool) isset($data['apply_subcategories']);
            $model->group_for_pages = !empty($data['group_for_pages'])? $data['group_for_pages'] : null;
            $model->apply_subcategories_group_pages = (bool) isset($data['apply_subcategories_group_pages']);
        }
        
        $model->group_id = !empty($data['group_id'])? $data['group_id'] : null;
    }
    
    public static function getOwnAssignModel($srcModel): ?AcfGroupAssign
    {
        if(!$srcModel) {
            return new AcfGroupAssign([
                'apply_subcategories' => false,
                'group_for_pages' => null,
                'apply_subcategories_group_pages' => false,
                'group_id' => null
            ]);
        }
        
        if(!$model = self::getOwn($srcModel->id, $srcModel::SOURCE_TYPE)) {
            return new AcfGroupAssign([
                'src_id' => $srcModel->id,
                'src_type' => $srcModel::SOURCE_TYPE,
                'apply_subcategories' => false,
                'group_for_pages' => null,
                'apply_subcategories_group_pages' => false,
                'group_id' => null
            ]);
        }
        
        return $model;
    }
    
    public static function getAssignModel($srcModel): ?AcfGroupAssign
    {
        if(!$srcModel) {
            return new AcfGroupAssign([
                'apply_subcategories' => false,
                'group_for_pages' => null,
                'apply_subcategories_group_pages' => false,
                'group_id' => null
            ]);
        }
        
        if(!$model = self::get($srcModel)) {
            return new AcfGroupAssign([
                'src_id' => $srcModel->id,
                'src_type' => $srcModel::SOURCE_TYPE,
                'apply_subcategories' => false,
                'group_for_pages' => null,
                'apply_subcategories_group_pages' => false,
                'group_id' => null
            ]);
        }
        
        return $model;
    }
}
