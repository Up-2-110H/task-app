<?php


namespace core;


use core\interfaces\MigrationInterface;

class Migration
{
    public static function up()
    {
        $migrated = self::checkDb();

        if (is_array($migrated)) {
            $result = '';
            $dir = scandir(Application::MIGRATION_DIR);
            foreach ($dir as $file) {
                if ($file === '.' || $file === '..') {
                    continue;
                }

                $path = Application::MIGRATION_DIR . $file;

                if (is_file($path)) {
                    $migrationName = pathinfo($path)['filename'];

                    if (in_array($migrationName, $migrated)) {
                        continue;
                    }

                    $migrationClass = Application::MIGRATION_NAMESPACE . $migrationName;

                    /** @var MigrationInterface $migration */
                    $migration = new $migrationClass;

                    if ($migration->up()) {
                        $sql = 'insert into migration (name) values (:name);';
                        $data = FM::$app->getDb()->prepare($sql);

                        $data->execute([':name' => $migrationName]);
                        $result .= $migrationName . ' done<br>';
                    } else {
                        $result .= $migrationName . ' failed<br>';
                        break;
                    }
                }
            }
            closedir($dir);

            return $result;
        }

        return false;
    }

    public static function down()
    {
        $migrated = self::checkDb();
        $result = '';

        for ($i = count($migrated) - 1; $i >= 0; $i--) {
            $migrationClass = Application::MIGRATION_NAMESPACE . $migrated[$i];

            /** @var MigrationInterface $migration */
            $migration = new $migrationClass;

            if ($migration->down()) {
                $sql = 'delete from migration where name = :name;';
                $data = FM::$app->getDb()->prepare($sql);

                $data->execute([':name' => $migrated[$i]]);
                $result .= $migrated[$i] . ' done<br>';
            } else {
                $result .= $migrated[$i] . ' failed<br>';
                break;
            }
        }

        return $result;
    }

    public static function create($filename)
    {
        try {
            $filename = Application::MIGRATION_DIR . 'm' . date('ymd_His') . '_' . $filename . '.php';
            $file = fopen($filename, 'w');
            fwrite($file, '<?php');
            fclose($file);
            chmod($filename, 0777);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return true;
    }

    private static function checkDb()
    {
        $data = FM::$app->getDb()->prepare('select name from migration');

        if ($data->execute()) {
            $result = $data->fetchAll(\PDO::FETCH_COLUMN);

            if ($result !== false) {
                return $result;
            }
        } else {
            return self::createMigrationTable() ? [] : false;
        }

        return false;
    }

    private static function createMigrationTable()
    {
        $sql =
            'create table if not exists migration (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            name TEXT NOT NULL
        )';

        try {
            FM::$app->getDb()->exec($sql);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}