<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace startpl\t2cms\acf\backend\widgets\base;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use startpl\t2cms\acf\common\repositories\AcfGroupRepository;

/**
 * Description of GroupSelect
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class GroupSelect 
{
    public static function render(string $fieldName, string $label, $selection = null): string
    {
        $items = ArrayHelper::map(AcfGroupRepository::getAll(), 'id', 'name');
        
        $select  = Html::beginTag('div', ['class' => 'form-group']);
        $select .= Html::label($label, 'acf_'.$fieldName, ['class' => 'control-label']);
        $select .= Html::dropDownList(
            "ACF[settings][{$fieldName}]", 
            $selection, 
            $items, 
            [
                'prompt' => \Yii::t('t2cms', 'Please select'),
                'class' => 'form-control', 
                'id' => 'acf_'.$fieldName
            ]
        );
        $select .= Html::endTag('div');
        
        return $select;
    }
    
}
