<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use startpl\t2cms\acf\common\models\AcfField;

/* @var $this yii\web\View */
/* @var $model startpl\t2cms\acf\backend\AcfField */
/* @var $form yii\widgets\ActiveForm */

$needDataTypes = [
    AcfField::TYPE_SELECT,
    AcfField::TYPE_CHECKGROUP,
    AcfField::TYPE_RADIOGROUP
];

$settingTypes = [
    AcfField::TYPE_TEXTAREA => [
        'label' => \Yii::t('acf', 'WYSIWYG Editor')
    ],
    AcfField::TYPE_CHECKBOX => [
        'label' => \Yii::t('acf', 'Checked')
    ],
    AcfField::TYPE_SELECT => [
        'label' => \Yii::t('acf', 'Multiple')
    ],
    AcfField::TYPE_CHECKGROUP => [
        'label' => \Yii::t('acf', 'Multiple')
    ],
];

$this->registerJsVar('settingTypes', $settingTypes);
$this->registerJsVar('needDataTypes', $needDataTypes);
?>

<div class="acf-field-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'group_id')->dropDownList($groups)?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(AcfField::getTypes()) ?>
    
    <?= $form->field($model, 'data', [
        'options' => [
            'class' => (in_array($model->type, $needDataTypes))? '' : 'hide',
            'id' => 'field-acffield-data'
            ]
        ])
        ->hint(\Yii::t('acf', 'Each item on a new line'))
        ->textarea(['rows' => 5]);?>

    <?= $form->field($model, 'settings', [
            'options' => [
                'class' => (key_exists($model->type, $settingTypes))? '' : 'hide',
                'id' => 'field-acffield-settings'
            ]
    ])
    ->checkbox(['label' => $settingTypes[$model->type]['label']]); // hack for replace label text?>
    
    <div class="form-group">
        <?= Html::submitButton(Yii::t('t2cms', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
$js = <<<JS
    $('#acffield-type').change(function() {
        prepareField(+$(this).val());
    });
    
function prepareField(type) {
    
    const fieldSetting = $('#field-acffield-settings');
        
    if(needDataTypes.indexOf(+type) != -1) {
        $('#field-acffield-data').removeClass('hide')
    } else {
        $('#field-acffield-data').addClass('hide')
    }
            
    if(settingTypes.hasOwnProperty(+type)) {
        const label  = $('#field-acffield-settings label');
        const search = $('#field-acffield-settings label').text();
        const result = label.html().replace(search, settingTypes[+type]['label']);
        $('#field-acffield-settings label').html(result);
        
        fieldSetting.removeClass('hide')
    } else {
        fieldSetting.addClass('hide')
    }
}
        
JS;

$this->registerJs($js);
?>