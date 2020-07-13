<?php

namespace startpl\t2cms\acf\common\models;

use Yii;

/**
 * This is the model class for table "{{%acf_group}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 *
 * @property AcfField[] $acfFields
 */
class AcfGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%acf_group}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('acf', 'Name'),
            'description' => Yii::t('acf', 'Description'),
        ];
    }

    /**
     * Gets query for [[AcfFields]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAcfFields()
    {
        return $this->hasMany(AcfField::className(), ['group_id' => 'id']);
    }
}
