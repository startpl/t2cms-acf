<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace startpl\t2cms\acf\backend\useCases;

use startpl\t2cms\acf\common\models\AcfFieldValue;
use startpl\t2cms\acf\common\repositories\AcfFieldRepository;

/**
 * Description of GroupAssign
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class FieldValue extends \yii\base\Component
{
    private $fieldRepository;
     
    public function __construct(AcfFieldRepository $fieldRepository, $config = array()) {
        parent::__construct($config);
        
        $this->fieldRepository = $fieldRepository;
    }
    
    public function save($model, $domain_id = null, $language_id = null): bool 
    {
        $fields  = \Yii::$app->request->post('ACF')['fields'];
        $groupId = (int)\Yii::$app->request->post('ACF')['group'];
                        
        if(!$groupId) return false;
        
        foreach($fields as $name => $value) {
            $this->saveField($model, $name, $value, $groupId, $domain_id, $language_id);
        }
        
        return true;
    }
    
    public function saveField($model, $name, $value, $groupId, $domain_id = null, $language_id = null): bool
    {        
        try {
            $fieldId = AcfFieldRepository::getFieldByNameAndGroup($name, $groupId)->id;
            
            $field = AcfFieldRepository::get($fieldId, $model->id, $model::SOURCE_TYPE, $domain_id, $language_id);
            
            if($field->value === null) {
                $this->createFieldValue($fieldId, $model->id, $model::SOURCE_TYPE, $value);
            } else {
                $field->value->value = $value;
                $this->fieldRepository->saveValue($field->value, $domain_id, $language_id);
            }
        } catch (\Exception $e) {
            return false;
        }
        
        return true;
    }
    
    private function createFieldValue($fieldId, $srcId, $srcType, $value): AcfFieldValue
    {
        $model = new AcfFieldValue([
            'field_id' => $fieldId,
            'src_id' => $srcId,
            'src_type' => $srcType,
            'value' => $value,
            'domain_id' => null,
            'language_id' => null
        ]);
        
        $this->fieldRepository->saveValue($model);
        
        return $model;
    }
    
    
//    public function save(AcfField $model, array $data, $domain_id = null, $language_id = null): bool
//    {
//        
//        $transaction = \Yii::$app->db->beginTransaction();
//        try{
//            if($model->getDirtyAttributes(['parent_id']) && ($model->id != $model->parent_id)){
//                if(empty($model->parent_id)) $model->parent_id = 1;
//                $this->repository->appendTo($model);
//            }
//            else{
//                $this->repository->save($model);
//            }
//            
//            $this->repository->saveContent($model->categoryContent, $domain_id, $language_id);
//            
//            $transaction->commit();
//        } catch(\Exception $e){
//            $transaction->rollBack();
//            return false;
//        }
//        
//        return true;
//    }
}
