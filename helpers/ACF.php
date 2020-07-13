<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace startpl\t2cms\acf\helpers;

use startpl\t2cms\acf\common\repositories\AcfFieldRepository;
use startpl\t2cms\acf\common\repositories\AcfGroupAssignRepository;

/**
 * Helper class for get ACF values
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class ACF 
{
    /**
     * Get field value
     * 
     * @param string $name Field name
     * @param int $srcId SOURCE ID
     * @param int $srcType SOURCE TYPE (have to be constant)
     * @return mixed
     */
    public static function get(string $name, $srcModel)
    {
        try {
            $groupId = \startpl\t2cms\acf\backend\useCases\GroupAssign::get($srcModel)->group_id;
            $model = AcfFieldRepository::getByNameAndGroup($name, $groupId, $srcModel->id, $srcModel::SOURCE_TYPE);
            
            return $model->value->value;
        } catch (\DomainException $e) {
            return null;
        }
    }
    
    /**
     * Get all field values
     * 
     * @param int $srcId SOURCE_ID
     * @param int $srcType SOURCE_TYPE (have to be constant)
     * @return array|null
     */
    public static function getFields($srcModel): ?array
    {
        try {
            $groupId = \startpl\t2cms\acf\backend\useCases\GroupAssign::get($srcModel)->group_id;
            $model = AcfFieldRepository::getAllByGroup($groupId, $srcModel->id, $srcModel::SOURCE_TYPE);
            
            return \yii\helpers\ArrayHelper::map($model, 'name', 'value.value');
        } catch (\DomainException $e) {
            return null;
        }
    }
}
