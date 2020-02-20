<?php

namespace console\migrations; 

use myframe\console\base\Migration;

class m_200220_013917_create_blog_category_table extends Migration
{  
   public function up()
   {
       return $this->createTable('blog_category', [
           'id' => "BIGINT(12) NOT NULL AUTO_INCREMENT",
           'name' => "VARCHAR(255) NOT NULL",
           //Перечислите имена колонок с их типом данных
           '' => "PRIMARY KEY(id)"
       ]);
   }

   public function down()
   {
       return $this->dropTable('blog_category');
   }
}
