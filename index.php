<?php

class ExcelCsv
{
    private $csvFilePath;
    private $host;
    private $user;
    private $password;
    private $database;
    private $tableToInsert;

    public function __construct(string $csvFilePath, string $host, string $user, string $password, string $database, string $tableToInsert)
    {
        $this->csvFilePath = $csvFilePath;
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->tableToInsert = $tableToInsert;
    }

    public function insertInSql()
    {
        $dsn = "mysql:host=localhost;dbname=testsite;charset=UTF8";
        $pdo = new PDO($dsn, 'root', '');

        $tableData = file($this->csvFilePath, FILE_IGNORE_NEW_LINES);
        $count = count($tableData);
        $numberOfInserts = 0;
        for ($i = 1; $i < $count; $i++) {
            $table[$i] = explode(";", $tableData[$i]);

            $result = "(NULL";


            foreach ($table[$i] as $value) {
                $result = "{$result}, '{$value}'";
            }
            $sqlValues = "{$result})";

            $sql = "INSERT INTO $this->tableToInsert VALUES {$sqlValues}";

            $numberOfInserts += $pdo->exec($sql);

        }
        print_r("Кол-во внесенных записей: {$numberOfInserts}");
    }
}
$test = new ExcelCsv("D:\\try\\table.csv", "localhost", "root", "", "testsite", "excel_import");
$test->insertInSql();
