<?php

use yii\db\Migration;

class m160801_115356_create_table_image extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('gallery_image', [
            'id' => 'pk',
            'path' => 'text NOT NULL DEFAULT ""',
            'description' => 'text NOT NULL DEFAULT ""',
            'user_id' => 'integer',
            'average_rating' => 'double DEFAULT 0',
            'created_date' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_date' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ], $tableOptions);

        $this->createIndex('idx-gallery_image-user_id', 'gallery_image', 'user_id');
    }

    public function safeDown()
    {
        $this->dropTable('gallery_image');

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
