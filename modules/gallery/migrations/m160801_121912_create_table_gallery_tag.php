<?php

use yii\db\Migration;

class m160801_121912_create_table_gallery_tag extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('gallery_tag', [
            'id' => 'pk',
            'name' => 'text NOT NULL'
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('gallery_tag');

        return true;
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
