<?php

use yii\db\Migration;

class m190425_080240_add_aid_to_article extends Migration
{
    public function up()
    {
        $this->addColumn('article','aid',$this->integer());
    }

    public function down()
    {
        $this->dropColumn('post','aid');
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
