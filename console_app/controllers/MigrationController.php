<?php

namespace console\controllers;

use Exception;
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
     * Выполнение миграций (Накатывание миграций)
     */
    public function actionUp()
    {   
        try {
            $migrations = $this->scanDirectory(ROOT . '/console_app/migrations');
            $migrationsFromDb = $this->fetchMigrationsFromDb();

            $newMigrations = array_diff($migrations, $migrationsFromDb);

            if (count($newMigrations) === 0) {
                exit("Новых миграций не обнаруженно.". PHP_EOL);
            } else {
                echo "Новые миграции обнаруженны: " . count($newMigrations) . "шт."  . PHP_EOL;
                echo "Выполнить миграции? [y/n]:". PHP_EOL;
                $user_action = readline('yes OR no :');
                echo PHP_EOL;

                if ($user_action === 'yes' || $user_action === 'y') {
                    $this->creatingMigrations($newMigrations);
                    echo "Миграции успешно выполнены!" . PHP_EOL . PHP_EOL;
                } else {
                    exit("Вы не подтвердили выполнение миграций." . PHP_EOL);
                }

            }    
        } catch(Exception $e) {
            exit(PHP_EOL . "Ошибка: " . $e->getMessage() . PHP_EOL . PHP_EOL);
        }
    }


    /**
     * Выполнение миграций (Откат миграций)
     */
    public function actionDown()
    {
        try {
            $migrations = $this->fetchMigrationsFromDb();
        
            if (count($migrations) > 0) {
                echo "Возможен откат миграций: " . count($migrations) . "шт."  . PHP_EOL;
                echo "Откатить ? [y/n]:". PHP_EOL;
                $user_action = readline('yes OR no :');

                if ($user_action === 'yes' || $user_action === 'y') {
                    $this->downingMigrations($migrations);
                    echo "Откат миграций успешно выполнен!" . PHP_EOL . PHP_EOL;
                } else {
                    exit("Вы не подтвердили откат миграций." . PHP_EOL);
                } 
            } else {
                exit("Миграций не обнаруженно.". PHP_EOL . PHP_EOL);
            }
        } catch(Exception $e) {
            exit(PHP_EOL . "Ошибка: " . $e->getMessage() . PHP_EOL . PHP_EOL);
        }
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
                apply_time TIMESTAMP,
                PRIMARY KEY (`version`)
            )"; 
            $this->pdo->exec($initMigrateSql);
            
            $time = time();
            $baseMigrateStr = "INSERT INTO migrations (`version`) VALUES ('migration0000_base')";
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
            "namespace console\migrations; \n",
            "\n",
            "use myframe\console\base\Migration;\n",
            "\n",
            "class {$migrationClass} extends Migration\n",
            "{\n",
            "   public function up()\n",
            "   {\n",
            '       return $this->createTable(\''.$tableName.'\', ['."\n",
            '           \'id\' => "BIGINT(12) NOT NULL AUTO_INCREMENT",'."\n",
            "           //Перечислите имена колонок с их типом данных\n",
            '           "" => "PRIMARY KEY(id)"'."\n",
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


    /**
     * Создаёт файл по которому будет добавляться новая колонка в таблицу БД.
     */
    private function addColumnFile($migrationClass, $columnName)
    {
        $contentMigrationFile = [
            "<?php\n",
            "\n",
            "namespace console\migrations; \n",
            "\n",
            "use myframe\console\base\Migration;\n",
            "\n",
            "class {$migrationClass} extends Migration\n",
            "{\n",
            "   public function up()\n",
            "   {\n",
            '       return $this->addColumn(\'//Имя таблицы\', \''.$columnName.'\', "VARCHAR(255)");'."\n",
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


    /**
     * Получение миграций из БД
     */
    private function fetchMigrationsFromDb(): array
    {
        $sql = "SELECT * FROM migrations";
        $stmt = $this->pdo->query($sql);

        while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $migrationsFromDatabase[] = $row['version'];
        }
        array_shift($migrationsFromDatabase);
        return $migrationsFromDatabase;
    }


    /**
     * Получение миграций из дирректории в которой они хранятся
     */
    private function scanDirectory(string $pathToMigrations): array
    {
        $migrationFiles = scandir($pathToMigrations); 
        unset($migrationFiles[0], $migrationFiles[1]);
        foreach ($migrationFiles as $migration) {
            // Если в одну строку, то выскакивает нотайс. -_-
            $chankMigrations = explode('.', $migration);
            $migrationsClasses[] = array_shift($chankMigrations);
        } 
        return $migrationsClasses;
    }


    /**
     * Проход по новым миграциям и их поднятие (накатывание)
     */
    private function creatingMigrations($newMigrations)
    {
        foreach($newMigrations as $migrationClass) {
            echo "Выполнение миграции {$migrationClass} ..." ;
            $start = microtime(true);

            $migrationClass = "console\\migrations\\" . $migrationClass;
            $migrationObject = new $migrationClass();
            $sql = $migrationObject->up();
            $this->pdo->exec($sql);

            $migrationVersion = explode('\\', $migrationClass);
            $migrationVersion = array_pop($migrationVersion);

            $addSql = "INSERT INTO migrations (`version`) VALUES ('$migrationVersion')";
            $this->pdo->exec($addSql); 

            $time = round((microtime(true) - $start), 3);
            echo PHP_EOL . "Выполнено. Время выполнения: $time сек.". PHP_EOL . PHP_EOL;
        }
    }


    /**
     * Проход по выполненым ранее миграциям и их откат.
     */
    private function downingMigrations($migrations)
    {
        foreach($migrations as $migrationClass) {
            echo "Откат миграции {$migrationClass} ..." ;
            $start = microtime(true);

            $migrationClass = "console\\migrations\\" . $migrationClass;
            $migrationObject = new $migrationClass();
            $sql = $migrationObject->down();
            $this->pdo->exec($sql);

            $migrationVersion = explode('\\', $migrationClass);
            $migrationVersion = array_pop($migrationVersion);

            $dropSql = "DELETE FROM migrations WHERE `version` = '$migrationVersion'";
            $this->pdo->exec($dropSql); 

            $time = round((microtime(true) - $start), 3);
            echo PHP_EOL . "Выполнено. Время выполнения: $time сек.". PHP_EOL . PHP_EOL;
        }
    }
}