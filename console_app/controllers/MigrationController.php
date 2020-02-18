<?php

namespace console\controllers;

use myframe\console\base\ConsoleController;
use PDOException;

class MigrationController extends ConsoleController
{   
    /**
     * Создает файл миграции
     */
    public function actionCreate($userCommand)
    {   
        // Генерирование названия класса миграции
        $migrationClass = 'm_' . date('dmy_His') . '_' . $userCommand;
        // Команда пользователя разбитая на части
        $arrChankCommands = explode('_', $userCommand);
        // Тип команды (Создание таблицы или Добавление колонки)
        $typeCommand = array_shift($arrChankCommands);
        // Имя создаваемой таблицы или же добавляемой колонки
        $props = implode('_', array_slice($arrChankCommands, 0, -1));
        
        if ($typeCommand === 'create') {
            $this->newTableFile($migrationClass, $props);
        } 
        if ($typeCommand === 'add') {
            $this->addColumnFile($migrationClass, $props);
        }
    }

    /**
     * Выполнение миграций (действий в файлах миграций)
     */
    public function actionUp()
    {

    }

    /**
     * Инициализация таблицы Migrations
     */
    public function actionInit()
    {   
        try {
            $start = microtime(true);
            $initMigrateSql = "CREATE TABLE migrations (
                `version` VARCHAR(255) NOT NULL,
                apply_time INT(11),
                PRIMARY KEY (`version`)
            )"; 
            $this->pdo->exec($initMigrateSql);
            
            $time = time();
            $baseMigrateStr = "INSERT INTO migrations (
                `version`, 
                apply_time
            ) VALUES (
                'migration0000_base',
                $time
            )";
            $this->pdo->exec($baseMigrateStr);
            $time = round((microtime(true) - $start), 3);
        } catch(PDOException $e) {
            exit(PHP_EOL . "Ошибка: " . $e->getMessage() . PHP_EOL . PHP_EOL);
        }

        echo PHP_EOL;
        echo 'Миграции успешно инициализированны.' . PHP_EOL;
        echo 'Время выполнения запроса: ' . $time . 'сек.';
        echo PHP_EOL . PHP_EOL;
        return 0;
    }

    /**
     * Создает файл миграции по которому будет создаваться новая таблица в 
     * Базе Данных
     */
    private function newTableFile($migrationClass, $tableName)
    {
        $contentMigrationFile = [
            "<?php\n",
            "\n",
            "use myframe\console\base\Migration;\n",
            "\n",
            "class {$migrationClass} extends Migration\n",
            "{\n",
            "   public function up()\n",
            "   {\n",
            '       return $this->createTable(\''.$tableName.'\', ['."\n",
            '           \'id\' => $this->bigInt(11, true)->notNull()->autoIncrement(),'."\n",
            "           //Перечислите имена колонок с их типом данных\n",
            '           $this->primaryKey(\'id\')'."\n",
            '       ]);'."\n",
            '   }'."\n",
            "\n",
            "   public function down()\n",
            "   {\n",
            '       return $this->dropTable(\''.$tableName.'\');'."\n",
            "   }\n",
            "}\n",
        ];

        $migration = fopen(ROOT . '/console_app/migrations/'. $migrationClass . '.php' , "wb");
        foreach($contentMigrationFile as $string) {
            fwrite($migration, $string);
        }
        fclose($migration);

        return 0;
    }

    private function addColumnFile($migrationClass, $columnName)
    {
        $contentMigrationFile = [
            "<?php\n",
            "\n",
            "use myframe\console\base\Migration;\n",
            "\n",
            "class {$migrationClass} extends Migration\n",
            "{\n",
            "   public function up()\n",
            "   {\n",
            '       return $this->addColumn(\'//Имя таблицы\', \''.$columnName.'\', $this->string(255));'."\n",
            '   }'."\n",
            "\n",
            "   public function down()\n",
            "   {\n",
            '       return $this->dropColumn(\'//Имя таблицы\', \''.$columnName.'\');'."\n",
            "   }\n",
            "}\n",
        ];

        $migration = fopen(ROOT . '/console_app/migrations/'. $migrationClass . '.php' , "wb");
        foreach($contentMigrationFile as $string) {
            fwrite($migration, $string);
        }
        fclose($migration);

        return 0;
    }
}