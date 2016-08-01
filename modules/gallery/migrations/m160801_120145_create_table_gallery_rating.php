<?php

use yii\db\Migration;

class m160801_120145_create_table_gallery_rating extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('gallery_rating', [
            'id' => 'pk',
            'user_id' => 'integer',
            'image_id' => 'integer',
            'value' => 'integer'
        ], $tableOptions);

        $this->createIndex('idx-gallery_rating-user_id', 'gallery_rating', 'user_id');
        $this->createIndex('idx-gallery_rating-image_id', 'gallery_rating', 'image_id');

        $this->addForeignKey('fk-gallery_rating-image_id', 'gallery_rating', 'image_id', 'gallery_images', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('gallery_rating');

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
