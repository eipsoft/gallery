<?php

use yii\db\Migration;

class m160801_122021_create_table_gallery_image_tag extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('gallery_image_tag', [
            'id' => 'pk',
            'image_id' => 'integer',
            'user_id' => 'integer'
        ], $tableOptions);

        $this->createIndex('idx-gallery_image_tag-user_id', 'gallery_image_tag', 'user_id');
        $this->createIndex('idx-gallery_image_tag-image_id', 'gallery_image_tag', 'image_id');

        $this->addForeignKey('fk-gallery_image_tag-image_id', 'gallery_image_tag', 'image_id', 'gallery_images', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('gallery_image_tag');

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
