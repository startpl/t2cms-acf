<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace startpl\t2cms\acf\common\traits;

use t2cms\base\factories\ContentApproaches;
use yii\helpers\ArrayHelper;

/**
 * Description of ContentValueApproachesTrait
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
trait FieldValueTrait
{
    public static function getSuitableId(int $id, int $srcId, int $srcType, $domain_id = null, $language_id = null): ?int
    {
        $approaches = ContentApproaches::getApproaches($domain_id, $language_id);
        
        foreach($approaches as $approach){
            if($result = static::isExistsId($id, $srcId, $srcType, $approach['domain_id'], $approach['language_id'])){
                return $result;
            }
        }
        
        return null;
    }
    
    public static function getAllSuitableId(int $srcId, int $srcType, $domain_id = null, $language_id = null): ?array
    {
        $approaches = ContentApproaches::getApproaches($domain_id, $language_id); 
        
        $result = [];
        foreach($approaches as $approach) {
            $result += ArrayHelper::map(
                static::getAllExistsId($srcId, $srcType, $approach['domain_id'], $approach['language_id'], array_keys($result)), 
                'field_id',
                'id');
        }
        
        return array_values($result);
    }

    protected static function isExistsId(int $id, $srcId, $srcType, $domain_id, $language_id): ?int
    {        
        $model = static::find()
            ->select('id')
            ->where(['field_id' => $id, 'src_id' => $srcId, 'src_type' => $srcType])
            ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
            ->one();
        
        return $model !== null? $model->id : null;
    }
    
    protected static function getAllExistsId($srcId, $srcType, $domain_id = null, $language_id = null, $exclude = []): ?array
    {
        return static::find()
            ->select('id, field_id')
            ->where(['src_id' => $srcId, 'src_type' => $srcType])
            ->andWhere(['domain_id' => $domain_id, 'language_id' => $language_id])
            ->andFilterWhere(['NOT IN', 'src_id', $exclude])
            ->all();
    }
}
