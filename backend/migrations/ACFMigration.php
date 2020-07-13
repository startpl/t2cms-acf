<?php

namespace startpl\t2cms\acf\backend\migrations;

/**
 * Class m200416_042612_acf
 */
class ACFMigration implements \yii\db\MigrationInterface 
{
    use \yii\db\SchemaBuilderTrait;
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        try {
            
            \Yii::$app->db->createCommand()->createTable('{{%acf_group}}', [
                'id'   => $this->primaryKey(),
                'name' => $this->string(100)->notNull(),
                'description' => $this->string(255)
            ])->execute();
            
            \Yii::$app->db->createCommand()->insert('{{%acf_group}}', [
                'name' => 'Default',
                'description' => 'default group'
            ])->execute();

            \Yii::$app->db->createCommand()->createTable('{{%acf_group_assign}}', [
                'id'   => $this->primaryKey(),
                'group_id' => $this->integer(),
                'src_id' => $this->integer()->notNull(),
                'src_type' => $this->integer()->notNull(),
                'apply_subcategories' => $this->boolean(),
                'group_for_pages' => $this->integer(),
                'apply_subcategories_group_pages' => $this->boolean(),
            ])->execute();
            \Yii::$app->db->createCommand()->createTable('{{%acf_field}}', [
                'id'       => $this->primaryKey(),
                'name'     => $this->string(100)->notNull(),
                'type'     => $this->integer(2)->notNull(),
                'group_id' => $this->integer()->notNull(),
                'data'     => $this->text(),
                'settings' => $this->boolean(),
            ])->execute();

            \Yii::$app->db->createCommand()->createTable('{{%acf_field_value}}', [
                'id'          => $this->primaryKey(),
                'field_id'    => $this->integer()->notNull(),
                'value'       => $this->text(),
                'src_type'    => $this->string(50)->notNull(),
                'src_id'      => $this->integer()->notNull(),
                'domain_id'   => $this->integer(),
                'language_id' => $this->integer()
            ])->execute();
            
            \Yii::$app->db->createCommand()
            ->addForeignKey('fk-acf_field-group_id', '{{%acf_field}}', 'group_id', '{{%acf_group}}', 'id', 'CASCADE')
            ->execute();

            \Yii::$app->db->createCommand()
            ->addForeignKey('fk-acf_field_value-field_id', '{{%acf_field_value}}', 'field_id', '{{%acf_field}}', 'id', 'CASCADE')
            ->execute();
            
            \Yii::$app->db->createCommand()
            ->addForeignKey('fk-acf_field_value-domain_id', '{{%acf_field_value}}', 'domain_id', '{{%domain}}', 'id', 'CASCADE')
            ->execute();
            
            \Yii::$app->db->createCommand()
            ->addForeignKey('fk-acf_field_value-language_id', '{{%acf_field_value}}', 'language_id', '{{%language}}', 'id', 'CASCADE')
            ->execute();

            \Yii::$app->db->createCommand()
            ->addForeignKey('fk-acf_group_assign-group_id', '{{%acf_group_assign}}', 'group_id', '{{%acf_group}}', 'id', 'CASCADE')
            ->execute();
            
        } catch (\Exception $e) {
            \Yii::$app->session->setFlash('error/info', $e->getMessage());
            return false;
        }
        
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        try {
            \Yii::$app->db->createCommand()->dropTable('{{%acf_group_assign}}')->execute();
            \Yii::$app->db->createCommand()->dropTable('{{%acf_field_value}}')->execute();
            \Yii::$app->db->createCommand()->dropTable('{{%acf_field}}')->execute();
            \Yii::$app->db->createCommand()->dropTable('{{%acf_group}}')->execute();
        } catch (\Exception $e) {
            \Yii::$app->session->setFlash('error/info', $e->getMessage());
            return false;
        }
        
        return true;
    }

    public function down(): bool {
        
    }

    public function up(): bool {
        
    }

    protected function getDb(): \yii\db\Connection {
        return \Yii::$app->db;
    }

}
