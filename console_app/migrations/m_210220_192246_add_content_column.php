<?php

namespace console\migrations; 

use myframe\console\base\Migration;

class m_210220_192246_add_content_column extends Migration
{
   public function up()
   {
       return $this->addColumn('book', 'content', "VARCHAR(255)");
   }

   public function down()
   {
       return $this->dropColumn('book', 'content');
   }
}
