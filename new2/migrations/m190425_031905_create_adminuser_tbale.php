<?php

use yii\db\Migration;

class m190425_031905_create_adminuser_tbale extends Migration
{
    public function up()
    {
        $this->createTable('adminuser',[
            'id' => $this->primaryKey()->comment('用户ID'),
            'username' => $this->string(10)->notNull()->comment('用户名'),
            'password' => $this->string(60)->notNull()->comment('密码'),
            'email' => $this->string(20)->notNull()->comment('邮箱'),

        ]);
    }

    public function down()
    {
        $this->dropTable('adminuser');
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
