<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model startpl\t2cms\acf\common\AcfField */

$this->title = Yii::t('acf', 'Create Field');
$this->params['breadcrumbs'][] = ['label' => Yii::t('acf', 'Fields'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acf-field-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'groups' => $groups,
        'model'  => $model,
    ]) ?>

</div>
