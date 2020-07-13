<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model startpl\t2cms\acf\common\AcfGroup */

$this->title = Yii::t('acf', 'Create Field Group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('acf', 'Field Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acf-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
