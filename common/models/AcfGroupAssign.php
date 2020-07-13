<?php

namespace startpl\t2cms\acf\common\models;

use Yii;

/**
 * This is the model class for table "{{%acf_group_assign}}".
 *
 * @property int $id
 * @property int $group_id
 * @property int $src_id
 * @property int $src_type
 * @property int|null $apply_subcategories
 * @property int|null $group_for_pages
 * @property int|null $apply_subcategories_group_pages
 *
 * @property AcfGroup $group
 */
class AcfGroupAssign extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%acf_group_assign}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['src_id', 'src_type'], 'required'],
            [['group_id', 'src_id', 'src_type', 'group_for_pages'], 'integer'],
            [['apply_subcategories', 'apply_subcategories_group_pages'], 'boolean'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcfGroup::className(), 'targetAttribute' => ['group_id' => 'id']],
        ];
    }

    /**
     * Gets query for [[Group]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(AcfGroup::className(), ['id' => 'group_id']);
    }
}
