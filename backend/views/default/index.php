<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use startpl\t2cms\acf\common\models\AcfField;

/* @var $this yii\web\View */
/* @var $searchModel startpl\t2cms\acf\common\AcfFieldSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('acf', 'Acf Fields');
$this->params['breadcrumbs'][] = $this->title;

\t2cms\T2Asset::register($this);
?>
<div class="acf-field-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <ul class="nav nav-tabs mb-40">
        <li class="active"><a><?=\Yii::t('acf', 'Fields')?></a></li>
        <li><?=Html::a(\Yii::t('acf', 'Groups'), ['group/index'])?></li>
    </ul>

    <p>
        <?= Html::a(Yii::t('acf', 'Create Field'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    
    <div class="row">
        <div class="col-md-2">            
            <ul class="nav nav-pills nav-stacked groups-list">
                <li 
                    <?php if(\Yii::$app->request->queryParams['AcfFieldSearch']['group_id'] == null):?>
                    class="active"
                    <?php endif;?>
                >
                    <?=Html::a(
                        \Yii::t('acf', 'All groups'), 
                        ArrayHelper::merge(
                            \Yii::$app->request->queryParams,
                            ['AcfFieldSearch' => ['group_id' => null]]
                        )
                    )?>
                </li>
                <?php foreach($groups as $id => $group):?>
                <li 
                    <?php if(\Yii::$app->request->queryParams['AcfFieldSearch']['group_id'] == $id):?>
                    class="active"
                    <?php endif;?>
                >
                    <?=Html::a(
                        $group, 
                        ArrayHelper::merge(
                            \Yii::$app->request->queryParams,
                            ['AcfFieldSearch' => ['group_id' => $id]]
                        )
                    )?>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="col-md-10">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'name',
                    [
                        'attribute' => 'type',
                        'label' => \Yii::t('acf', 'Type'),
                        'format' => 'text',
                        'value' => function($model, $key, $index) use ($groups){
                            return AcfField::getType($model->type);
                        }
                    ],
                    [
                        'attribute' => 'group_id',
                        'label' => \Yii::t('acf', 'Group Name'),
                        'filter' => $groups,
                        'format' => 'text',
                        'value' => function($model, $key, $index) use ($groups){
                            return $groups[$model->group_id];
                        }
                    ],

                    [
                        'header' => \Yii::t('app', 'Controls'),
                        'class'  => 'yii\grid\ActionColumn'
                    ],
                ],
            ]); ?>
        </div>
    </div>
    <?php Pjax::end(); ?>

</div>
