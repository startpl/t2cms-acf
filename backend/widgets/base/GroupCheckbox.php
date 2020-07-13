<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace startpl\t2cms\acf\backend\widgets\base;

use yii\helpers\Html;

/**
 * Description of GroupSelect
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class GroupCheckbox 
{
    public static function render(string $fieldName, string $label, $selection = null): string
    {        
        $field  = Html::beginTag('div', ['class' => 'form-group']);
        $field .= Html::checkbox(
            "ACF[settings][{$fieldName}]", 
            $selection,
            [
                'id' => 'acf_'.$fieldName
            ]
        );
        $field .= Html::label($label, 'acf_'.$fieldName, ['class' => 'control-label']);
        $field .= Html::endTag('div');
        
        return $field;
    }
    
}
