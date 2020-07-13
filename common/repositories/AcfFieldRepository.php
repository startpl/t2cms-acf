<?php

/**
 * @link https://github.com/startpl/t2cms-core
 * @copyright Copyright (c) 2020 Koperdog
 * @license https://github.com/startpl/t2cms-core/blob/master/LICENSE
 */

namespace startpl\t2cms\acf\common\repositories;

use startpl\t2cms\acf\common\models\AcfField;
use startpl\t2cms\acf\common\models\AcfFieldValue;

/**
 * Description of AcfGoupRepository
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class AcfFieldRepository 
{
    public static function get(int $id, int $srcId, int $srcType, $domain_id = null, $language_id = null): AcfField
    {
        $model = AcfField::find()
            ->with(['value' => function($query) use ($id, $srcId, $srcType, $domain_id, $language_id){
                $query->andWhere(['id' => AcfFieldValue::getSuitableId($id, $srcId, $srcType, $domain_id, $language_id)]);
            }])
            ->andWhere(['acf_field.id' => $id])
            ->one();        
            
        if(!$model){
            throw new \DomainException("Field with id: {$id} does not exists");
        }
        
        return $model;
    }
    
    public static function getByName
    (
        string $name, 
        int $srcId, 
        int $srcType, 
        $domain_id = null, 
        $language_id = null
    ): AcfField 
    {
        $model = AcfField::find()
            ->with(['value' => function($query) use ($srcId, $srcType, $domain_id, $language_id){
                $query->andWhere(['id' => AcfFieldValue::getAllSuitableId($srcId, $srcType, $domain_id, $language_id)]);
            }])
            ->andWhere(['acf_field.name' => $name])
            ->one();
        
        if(!$model = AcfField::findOne($id)){
            throw new \DomainException("Field with name: {$name} does not exists");
        }
        
        return $model;
    }
    
    public static function getByNameAndGroup
    (
        string $name, 
        int $groupId,
        int $srcId, 
        int $srcType, 
        $domain_id = null, 
        $language_id = null
    ): AcfField 
    {
        
        
        $model = AcfField::find()
            ->with(['value' => function($query) use ($srcId, $srcType, $domain_id, $language_id){
                $query->andWhere(['id' => AcfFieldValue::getAllSuitableId($srcId, $srcType, $domain_id, $language_id)]);
            }])
            ->andWhere([
                'acf_field.name' => $name,
                'acf_field.group_id' => $groupId,
            ])
            ->one();
        
        if(!$model){
            throw new \DomainException("Field with name: {$name} and group: {$groupId} does not exists");
        }
        
        return $model;
    }
    
    public static function getFieldByNameAndGroup(string $name, int $groupId): ?AcfField
    {     
        if(!$model = AcfField::find()->where(['name' => $name, 'group_id' => $groupId])->one()) {
            throw new \DomainException("Field with name: {$name} and group: {$groupId} does not exists");
        }
        
        return $model;
    }
    
    public static function getAll($domain_id = null, $language_id = null): ?array
    {
        return AcfField::find()->all();
    }
    
    public static function getAllByGroup(
        int $groupId, 
        int $srcId, 
        int $srcType, 
        int $domain_id = null, 
        int $language_id = null
    ): ?array 
    {           
        return AcfField::find()
            ->with(['value' => function($query) use ($srcId, $srcType, $domain_id, $language_id){
                $query->andWhere(['id' => AcfFieldValue::getAllSuitableId($srcId, $srcType, $domain_id, $language_id)]);
            }])
            ->where(['acf_field.group_id' => $groupId])
            ->all();
    }
        
    public function save(\yii\base\Model $model): bool
    {
        if(!$model->save()){
            throw new \RuntimeException("Error save");
        }
        
        return true;
    }
    
    public function delete(AcfField $model): bool
    {
        if(!$model->delete()){
            throw new RuntimeException("Error delete");
        }
        
        return true;
    }
    
    public function saveValue(AcfFieldValue $model, $domain_id = null, $language_id = null): bool
    {
        if(is_array($model->value)) {
            $model->value = json_encode($model->value);
        }
    
        
        if(($model->domain_id != $domain_id || $model->language_id != $language_id) && $model->getDirtyAttributes())
        {
            return $this->copyValue($model, $domain_id, $language_id);
        }
        
        return $this->save($model);
    }
    
    private function copyValue(\yii\db\ActiveRecord $model, $domain_id, $language_id)
    {
        $newContent = new AcfFieldValue();
        $newContent->attributes = $model->attributes;
        
        $newContent->domain_id   = $domain_id;
        $newContent->language_id = $language_id;
        
        return $this->save($newContent);
    }
}
