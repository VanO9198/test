<?php

class ExcelCsv
{
    public $csvFilePath;
    public $host;
    public $user;
    public $password;
    public $database;
    public $tableToInsert;

    public function __construct($csvFilePath, $host, $user, $password, $database, $tableToInsert)
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
        $con = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        mysqli_set_charset($con, "utf8");

        $tableData = file($this->csvFilePath, FILE_IGNORE_NEW_LINES);
        $count = count($tableData);

        $insertedRows = 0;
        for ($i = 1; $i < $count; $i++) {
            $table[$i] = explode(";", $tableData[$i]);

            $result = "(NULL";

            foreach ($table[$i] as $value) {
                $result = "{$result}, '{$value}'";
            }
            $sqlValues = $result . ")";

            $insertQuery = "INSERT INTO `{$this->tableToInsert}` VALUES {$sqlValues}";
            mysqli_query($con, $insertQuery);

            $insertedRows += mysqli_affected_rows($con);
        }
        print_r("Кол-во импортированных строк: {$insertedRows}");
    }
}
$test = new ExcelCsv("D:\\try\\table.csv", "localhost", "root", "", "testsite", "excel_import");

$test->insertInSql();
