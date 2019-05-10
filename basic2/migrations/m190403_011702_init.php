<?php

use yii\db\Migration;

class m190403_011702_init extends Migration
{
    public function up()
    {
        $this->createTable('adminuser',[
            'id'=>$this->primaryKey(),
            'name'=>$this->string(10)->notNull()->comment('管理员名称'),
            'password'=>$this->string(12)->notNull()->comment('密码'),
        ]);
        $this->createTable('tag',[
            'id'=>$this->primaryKey(),
            'name'=>$this->string()->notNull()->comment('标签名称'),
        ]);
        $this->createTable('tag_article_link',[
            'id'=>$this->primaryKey(),
            'article_id'=>$this->integer()->notNull()->comment('文章关联ID'),
            'tag_id'=>$this->integer()->notNull()->comment('标签关联ID'),
        ]);
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('名称'),
        ]);
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'title' => $this->string(30)->notNull()->comment('标题'),
            'content' => $this->text()->notNull()->comment('内容'),
            'category_id' => $this->integer()->notNull()->comment('分类ID'),
            'created_at' => $this->integer()->notNull()->defaultValue(0)->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->defaultValue(0)->comment('修改时间'),
            'is_deleted' => $this->boolean()->notNull()->defaultValue(0)->comment('是否被删除'),
        ]);
        $this->addForeignKey('tag_article_link_article','tag_article_link','article_id','article','id');
        $this->addForeignKey('tag_article_link_tag','tag_article_link','tag_id','tag','id');
        $this->addForeignKey('article_category', 'article', 'category_id', 'category', 'id');
    }

    public function down()
    {
        $this->dropTable('article');
        $this->dropTable('category');
        $this->dropTable('tag_article_link');
        $this->dropTable('tag');
        $this->dropTable('adminuser');
    }
}
