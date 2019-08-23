<?php declare(strict_types=1);

namespace App;

class Query
{
    protected function getAllFrom(string $table_name, SQLite3 $db_inst): array
    {
        $smtp = $db_inst->prepare("SELECT * FROM {$table_name};");
        $result = $smtp->execute();

        return $result->fetchArray(SQLITE3_ASSOC);
    }

    protected function createFishTable(SQLite3 $db_inst): void
    {
        $sql = <<<SQL
            CREATE TABLE fish (
                id smallint UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name varchar(220),
                price decimal(10,2)
            );
        SQL;

        $db_inst->exec($sql);
    }
}