<?php

use yii\db\Migration;

class m190423_095324_init extends Migration
{
    public function up()
    {
        $this->createTable('article',[
            'id'=>$this->primaryKey()->comment('文章ID'),
            'title'=>$this->string(15)->notNull()->comment('标题'),
            'content'=>$this->text()->notNull()->comment('文章内容'),
            'category_id'=>$this->integer(2)->notNull()->comment('分类ID'),
            'status'=>$this->integer(2)->notNull()->comment('文章状态'),
            'create_at'=>$this->integer()->notNull()->comment('创建时间'),
            'update_at'=>$this->integer()->notNull()->comment('更新时间'),
        ]);

        $this->createTable('category',[
            'id'=>$this->primaryKey()->notNull()->comment('分类ID'),
            'name'=>$this->string(15)->notNull()->comment('分类名称'),
        ]);

        $this->createTable('tag',[
            'id'=>$this->primaryKey()->comment('标签ID'),
            'name'=>$this->string(10)->notNull()->comment('标签名称'),
        ]);

        $this->createTable('article_tag_link',[
            'id'=>$this->primaryKey()->notNull()->comment('文章标签关联ID'),
            'article_id'=>$this->integer(2)->notNull()->comment('文章ID'),
            'tag_id'=>$this->integer(2)->notNull()->comment('标签ID'),
        ]);

        $this->addForeignKey('article_category','article','category_id','category','id');
        $this->addForeignKey('article_tag_link_article','article_tag_link','article_id','article','id');
        $this->addForeignKey('article_tag_link_tag','article_tag_link','tag_id','tag','id');
    }

    public function down()
    {

        $this->dropTable('article_tag_link');
        $this->dropTable('tag');
        $this->dropTable('article');
        $this->dropTable('category');



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
