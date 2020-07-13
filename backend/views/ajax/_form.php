<?php

use yii\helpers\Html;
use startpl\t2cms\acf\common\models\AcfField;

/* @var $this yii\web\View */
/* @var $data array startpl\t2cms\acf\backend\AcfField */
?>
<div class="wr_acf_fields">
    <?=Html::hiddenInput("ACF[group]", $groupId);?>
    
    <?php if(count($data) === 0):?>
        <?= yii\bootstrap\Alert::widget([
            'options' => [ 'class' => 'alert-danger' ], 
            'body' => \Yii::t('acf', 'The group is empty')
        ]); ?>
    <?php else:?>
        <?php foreach($data as $field):?>
        <?php
            $inputOptions = [
                'class' => $field->type != AcfField::TYPE_CHECKBOX? 'form-control' : 'ps-checkbox',
                'id'    => 'acfField-' . $field->id
            ];
            
            $inputName = "ACF[fields][{$field->name}]";
        ?>
        <div class="form-group">
            <label class="control-label" for="<?=$inputOptions['id']?>"><?=$field->name?></label>
            <?php switch($field->type){
                case AcfField::TYPE_SELECT:
                    echo Html::dropDownList(
                        $inputName, 
                        $field->value->value, 
                        explode(PHP_EOL, $field->data), 
                        array_merge(
                            $inputOptions,
                            [
                                'multiple' => ($field->settings? 'multiple' : '')
                            ]
                        )
                    );
                    break;
                case AcfField::TYPE_TEXTAREA:
                    if($field->settings) {
                        echo \vova07\imperavi\Widget::widget([
                            'name' => $inputName,
                            'value' => $field->value->value,
                            'settings' => [
                                'lang' => 'ru',
                                'minHeight' => 200,
                                'plugins' => [
                                    'fullscreen',
                                ],
                                'buttons' => [
                                    'html',
                                    'formatting',
                                    'bold',
                                    'italic',
                                    'deleted',
                                    'unorderedlist',
                                    'orderedlist',
                                    'outdent',
                                    'indent',
                                    'image',
                                    'file',
                                    'link',
                                    'alignment',
                                    'horizontalrule'
                                ],
                            ],
                        ]);
                    } else {
                        echo Html::textarea($inputName, $field->value->value, $inputOptions);
                    }
                    break;
                case AcfField::TYPE_FILE:
                    echo \mihaildev\elfinder\InputFile::widget(
                        array_merge([
                            'name'          => $inputName,
                            'value'         => $field->value->value,
                            'controller'    => '/elfinder',
                            'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                            'options'       => ['class' => 'form-control'],
                            'buttonOptions' => ['class' => 'btn btn-default'],
                            'multiple'      => false,

                        ],
                        $inputOptions
                        )
                    );
                    break;
                case AcfField::TYPE_CHECKBOX:
                    if($field->value->value === null) {
                        $field->value->value = $field->settings? 'on' : 'off';
                    }
                    echo Html::hiddenInput($inputName, $field->value->value, [
                        'id' => '_acfField-'.$field->id
                    ]);
                    echo Html::checkbox(
                        'acf-checkbox_'.$field->id, 
                        $field->value->value === 'on',
                        array_merge(
                            $inputOptions,
                            [
                                'data' => [
                                    'id' => $field->id
                                ]
                            ]
                        )
                    );
                    break;
                case AcfField::TYPE_CHECKGROUP:
                    echo Html::checkboxList(
                            $inputName, 
                            $field->value->value, 
                            explode(PHP_EOL, $field->data), 
                            array_merge(
                                $inputOptions,
                                [
                                    'multiple' => 'multiple',
                                    'class' => 'checkbox_group'
                                ]
                            )
                        );
                    break;
                case AcfField::TYPE_RADIOGROUP:
                    echo Html::radioList(
                            $inputName, 
                            $field->value->value, 
                            explode(PHP_EOL, $field->data), 
                            array_merge(
                                $inputOptions,
                                [
                                    'class' => 'radio_group'
                                ]
                            )
                        );
                    break;
                default:
                    echo Html::input(AcfField::getType($field->type), $inputName, $field->value->value, $inputOptions);
            }
            ?>
        </div>
        <?php endforeach;?>
    <?php endif;?>
</div>

<?php 
$this->registerJs(
<<<JS
$('.ps-checkbox').change(function(){
    const value   = $(this).prop('checked')? 'on' : 'off';
    const fieldId = $(this).data('id');
    
    $('#_acfField-'+fieldId).val(value);
});
JS
);
$this->registerCss(
<<<CSS
   .radio_group > label, .checkbox_group > label {
        display: block;
    } 
CSS
);