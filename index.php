<?php


function insertInSql($csvFilePath, $database, $tableToInsert)
{
    $con = mysqli_connect("localhost", "root", "", $database);
    mysqli_set_charset($con, "utf8");

    $tableData = file($csvFilePath, FILE_IGNORE_NEW_LINES);
    $count = count($tableData);
    for ($i = 1; $i < $count; $i++) {
        $row = "row{$i}";
        $$row = explode(";", $tableData[$i]);

        $result = "(NULL";

        foreach ($$row as $value) {
            $result = "{$result}, '{$value}'";
        }
        $sqlValues = $result . ")";

        $insertQuery = "INSERT INTO `{$tableToInsert}` VALUES {$sqlValues}";
        mysqli_query($con, $insertQuery);
    }
}

/*
 * 1. обратный слэш в пути файла нужно задваивать для экранирования
 * 2. ексель таблица должна быть сохранена в формате .csv
 * 3. подразумевается, что первый столбец в таблице базы данных это primary с автоинкрементом
 */
insertInSql("D:\\try\\table.csv", "testsite", "excel_import");