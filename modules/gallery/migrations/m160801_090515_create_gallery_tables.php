<?php

use yii\db\Migration;

class m160801_090515_create_gallery_tables extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
           $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%images}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'title' => $this->string()->notNull()->defaultValue(''),
            'path' => $this->string()->notNull()->defaultValue('')            
        ], $tableOptions);
 
        //$this->createIndex('idx-images-title', '{{%images}}', 'title');
    }

    public function down()
    {
        $this->dropTable('{{%images}}');

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
