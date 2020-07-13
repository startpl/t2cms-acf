<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model startpl\t2cms\acf\common\models\AcfGroup */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('acf', 'Field Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acf-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
