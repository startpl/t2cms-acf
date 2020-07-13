<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace startpl\t2cms\acf\backend\factories;

/**
 * Description of FieldServiceFactory
 *
 * @author Koperdog <koperdog.dev@gmail.com>
 */
class FieldValueServiceFactory 
{
    public static function getService(): \startpl\t2cms\acf\backend\useCases\FieldValue
    {
        return \Yii::createObject(\startpl\t2cms\acf\backend\useCases\FieldValue::className());
    }
}
