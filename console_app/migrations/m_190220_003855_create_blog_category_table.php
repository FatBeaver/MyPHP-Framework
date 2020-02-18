<?php

use myframe\console\base\Migration;

class m_190220_003855_create_blog_category_table extends Migration
{
   public function up()
   {
        return $this->createTable('blog_category', [
           'id' => $this->bigInt(11, true)->notNull()->autoIncrement(),
           //Перечислите имена колонок с их типом данных
           $this->primaryKey('id')
        ]);
   }

   public function down()
   {
       return $this->dropTable('blog_category');
   }
}
