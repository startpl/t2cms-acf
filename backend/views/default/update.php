<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model startpl\t2cms\acf\common\AcfField */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fields'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acf-field-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'groups' => $groups,
        'model'  => $model,
    ]) ?>

</div>
