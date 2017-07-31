<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post`.
 */
class m170605_145115_create_post_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->comment('标题'),
            'img' => $this->string()->comment('图片'),
            'views' => $this->integer()->comment('访问量'),
            'order' => $this->smallInteger()->comment('序号'),
            'status' => $this->boolean()->defaultValue(1)->comment('状态'),
            'content' => $this->text()->comment('内容'),
            'created_at' => $this->integer()->comment('创建时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%post}}');
    }
}
