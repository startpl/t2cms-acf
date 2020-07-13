<?php

/**
 * @link https://github.com/startpl/t2cms-core
 * @copyright Copyright (c) 2020 Koperdog
 * @license https://github.com/startpl/t2cms-core/blob/master/LICENSE
 */

namespace startpl\t2cms\acf\common\repositories;

use startpl\t2cms\acf\common\models\AcfGroupAssign;

/**
 * Description of AcfGroupAssignRepository
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class AcfGroupAssignRepository 
{
    
//    public static function get(int $srcId, int $srcType): ?AcfGroupAssign
//    {   
//        $own = AcfGroupAssign::find()->where(['src_id' => $srcId, 'src_type' => $srcType])->one();
//        
//        if($own === null) {
//           
//        }
//        
//        if(!$model = AcfGroupAssign::find()->where(['src_id' => $srcId, 'src_type' => $srcType])->one()) {
//            throw new \DomainException("Group Assignments for src: ${$srcId} with type: ${srcType} does not exist");
//        }
//        
//        return $model; 
//    }
    
    public static function get(int $srcId, int $srcType): ?AcfGroupAssign
    {   
        if(!$model = AcfGroupAssign::find()->where(['src_id' => $srcId, 'src_type' => $srcType])->one()) {
            throw new \DomainException("Group Assignments for src: ${$srcId} with type: ${srcType} does not exist");
        }
        
        return $model; 
    }
    
    public static function save(AcfGroupAssign $model): ?bool
    {
        if(!$model->save()) {
            throw new \RuntimeException('Error save model');
        }
        
        return true;
    }
}
