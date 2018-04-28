<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/11/17
 * Time: 12:36 PM
 */
$mysqli = mysqli_connect("localhost", "root", "12345", "");
mysqli_select_db($mysqli, "sys_blog");
echo "<pre>";
echo "\n --------------- MYSQLI INFO ------------------ \n";
print_r($mysqli);
/**
 * Mysqli query is a combination of mysqli_real_query + mysqli_store_result / mysqli_use_result. Only mysqli_query and mysqli_stmt_get_results has this in build feature of calling Store or use automatically which also we can change by mysqli_query($mysqli, $query, fetch_type) where fetch_type default is MYSQLI_STORE_RESULT and can also use MYSQLI_USE_RESULT. All the other methods are supposed to be used with mysqli_store_result or mysqli_use_result.
 * Mysqli_use_result will not fetch all the records from database in one shot it will fetch the records as needed where as mysqli_store_result will get all the records from database at once and hence can use mysqli_data_seek
 */
$resultRealQuery = mysqli_real_query($mysqli, "select * from test");
echo "\n --------------------------------- MYSQLI REAL QUERY --------------------------------\n";
print_r($resultRealQuery); /// it returns true / false but not result set as mysqli_query
$storedReal = mysqli_store_result($mysqli);
print_r($storedReal);
print_r(mysqli_fetch_all($storedReal));
$result = mysqli_query($mysqli, "select * from test"); // returns number of columns and rows affected by query whereas in pdo we got a pdo object without all this info
print_r($result);
// $storedReal and $result above are all mysql_result_objects. They are not actual
// Fetching a result from query or prepared statement moves the result cursor to next fetch_all moves it to end

echo "\n -------------- Prepared Statement Normal Affected/Num Rows Start ------------------- \n";
// for pdo both are rowCount
echo "AF -> ". mysqli_affected_rows($mysqli);
echo PHP_EOL;
echo "NUM -> ".mysqli_num_rows($result);
echo "\n";

echo "\n ---------------- RESULT SET --------------- \n";
print_r($result);
echo "\n ----- ALL ----- \n";
print_r(mysqli_fetch_all($result));
echo "\n ----- ARRAY ASSOC ----- \n";
$result = mysqli_query($mysqli, "select * from test");
print_r(mysqli_fetch_array($result, MYSQLI_ASSOC));
echo "\n ----- ARRAY NUM ----- \n";
$result = mysqli_query($mysqli, "select * from test");
print_r(mysqli_fetch_array($result, MYSQLI_NUM));
echo "\n ----- ARRAY BOTH ----- \n";
$result = mysqli_query($mysqli, "select * from test");
print_r(mysqli_fetch_array($result, MYSQLI_BOTH));
echo "\n ----- ROW ----- \n";
$result = mysqli_query($mysqli, "select * from test");
print_r(mysqli_fetch_row($result));
echo "\n ----- FIELD ----- \n";
$columnInfo = mysqli_query($mysqli, "select * from test");
//print_r(mysqli_fetch_field($columnInfo));
while($info = mysqli_fetch_field($columnInfo)) {
    print_r($info);
}
// fields in mysqli are columns
echo "\n ---------- FETCH OBJECT STD -------------- \n";
$result = mysqli_query($mysqli, "select * from test");
while($row = mysqli_fetch_object($result)) { // by default the object is of class stdClass
    print_r($row);
}
echo "\n ---------------- FETCH OBJECT CLASS ----------------- \n";
class a{}
$resultCopy = mysqli_query($mysqli, "select * from test");
while($rowNew = mysqli_fetch_object($resultCopy, "a")) { // but if we pass on the name of the class we can get the object of that class
    print_r($rowNew);
}

echo "\n -------------- DATA SEEK ------------------ \n";
// can modify the position of cursor to a random row in result set. This should be good for pagination sort of things.
$result = mysqli_query($mysqli, "select * from test");
mysqli_data_seek($result, 5);
print_r(mysqli_fetch_assoc($result));

echo "\n ------------- MYSQLI CURRENT FIELD --------------- \n";
// Returns the offset of current column after doing mysqli_fetch_field
$result = mysqli_query($mysqli, "select * from test");
mysqli_fetch_field($result);
mysqli_fetch_field($result);
print_r(mysqli_field_tell($result));

echo "\n ---------------- Field Lengths -------------- \n";
$result = mysqli_query($mysqli, "select * from test LIMIT 1");
var_dump(mysqli_fetch_lengths($result));

echo "\n ---------------- Field Counts --------------- \n";
print_r(mysqli_field_count($mysqli)); // takes is mysqli connection adapter link and returns the number of columns . If used after a query then returns the number of columns present in that query.
$result = mysqli_query($mysqli, "select id, name from test");
echo "\n";
print_r(mysqli_num_fields($result)); // takes in result as argument and returns the number of columns in query.

// For SELECT statements mysqli_affected_rows() works like mysqli_num_rows().
echo "\n -------------- Num Rows -------------- \n";
var_dump(mysqli_affected_rows($mysqli));
echo "\n";
$result = mysqli_query($mysqli, "insert into test (name, is_active, uniqueEntry) values (\"Kushagra Again\", 1, 11)");
var_dump(mysqli_num_rows($result));
echo "\n";
var_dump(mysqli_affected_rows($mysqli));

/// There are two functions or logic available even without executing the query
/// 1). GEt total number of columns present in the table ,not specific to any query. -> mysqli_field_count($mysqli)
/// 2). Get total number of rows present in table, not specific to any query. -> mysqli_affected_rows($mysqli)
/// these both work before or after the query execution. If called before they return the number not specific to any query.

echo "\n ========================================== MYSQLI MULTI QUERIES STARTS ========================================== \n";

echo "\n --------- MYSQLI STORE RESULT WITH MULTI QUERY ----------- \n";
$mysqliNew = mysqli_connect("localhost", "root", "12345", "sys_blog");
$query  = "SELECT VERSION();";
$query .= "SELECT CURRENT_USER();";
$query = mysqli_multi_query($mysqliNew, $query);
echo "\n ===== Dumping Multi Query ===== \n";
print_r($query);
echo "\n";
//$use = mysqli_use_result($mysqliNew); // this will transfer the result set from the last query run on the connectionecho "<pre>";
do {
    $stored = mysqli_store_result($mysqliNew); // this will transfer the result set from the last query run on the connection
    while($row = mysqli_fetch_row($stored)) {
        print_r($row);
    }
} while(mysqli_next_result($mysqliNew));

echo "\n --------- MYSQLI USE RESULT WITH MULTI QUERY ----------- \n";
$mysqliNew = mysqli_connect("localhost", "root", "12345", "sys_blog");
$query  = "SELECT name from test;";
$query .= "SELECT CURRENT_USER();";
$query = mysqli_multi_query($mysqliNew, $query);
echo "\n ===== Dumping Multi Query ===== \n";
print_r($query);
echo "\n";
//$use = mysqli_use_result($mysqliNew); // this will transfer the result set from the last query run on the connectionecho "<pre>";
do {
    $use = mysqli_use_result($mysqliNew); // this will transfer the result set from the last query run on the connection
    echo PHP_EOL." Printing all the values ".PHP_EOL;
    echo PHP_EOL."--- Starting 1 ----".PHP_EOL;
    print_r(mysqli_fetch_all($use));
    echo PHP_EOL."--- Ending 1 ----".PHP_EOL;
    echo PHP_EOL."--- Starting 2 ----".PHP_EOL;
    print_r(mysqli_fetch_assoc($use));
    echo PHP_EOL."--- Ending 2 ----".PHP_EOL;
    while($row = mysqli_fetch_row($use)) {
        print_r($row);
    }
    if (mysqli_more_results($mysqliNew)) { // check if more results are present
        printf("-----------------\n");
    }
} while(mysqli_next_result($mysqliNew));

mysqli_free_result($stored);
echo "\n --------- MYSQLI STORE RESULT WITH SINGLE QUERY ----------- \n";
$mysqli2 = mysqli_connect("localhost", "root", "12345", "sys_blog");
$query = mysqli_query($mysqli2,"SELECT name from test;");
//$stored = mysqli_use_result($mysqli2); // this does not work because we used mysqli_query which already has mysqli_use_result
while($row = mysqli_fetch_row($stored)) {
    print_r($row);
}

echo "\n ---------- Finding Difference between use and store -------------- \n";
$mysqli3 = mysqli_connect("localhost", "root", "12345", "sys_blog");
$query  = "SELECT name from test;";
$query .= "SELECT CURRENT_USER();";
$query = mysqli_multi_query($mysqli3, $query);
$storeQ = mysqli_store_result($mysqli3);

echo "\n ----- Dumping store before ------ \n";
print_r($storeQ);

echo "\n --- Printing Store ---- \n";
print_r(mysqli_fetch_row($storeQ));
echo "\n ----- Dumping store After ------ \n";
print_r($storeQ);
echo "\n ------ Dumping Affected Rows ----- \n";
echo mysqli_affected_rows($mysqli3);
echo "\n";

$mysqli4 = mysqli_connect("localhost", "root", "12345", "sys_blog");
$query  = "SELECT name from test;";
$query .= "SELECT CURRENT_USER();";
$query2 = mysqli_multi_query($mysqli4, $query);
$useQ = mysqli_use_result($mysqli4);

echo "\n ----- Dumping use Before ------ \n";
print_r($useQ);

echo "\n --- Printing Use ---- \n";
print_r(mysqli_fetch_row($useQ));

echo "\n ----- Dumping use After ------ \n";
print_r($useQ);

echo "\n ------ Dumping Affected Rows ----- \n";
echo mysqli_affected_rows($mysqli4);
echo "\n";


/***
 * MYSQLI_STORE_RESULT , MYSQLI_USE_RESULT works only with multi query and not with mysqli_query. According to documentation mysqli_store fetches data in one shot from server but mysqli_use fetches data row by row from server.
 * mysqli_store, mysqli_use returns the query object same as we get from mysqli_query.
 * Guessing from the behaviour above looks like mysqli_store wil fetch all the rows at once mysqli_use will fetch nothing or 0 rows . It gets them when we request them using mysqli_fetch_assoc etc
 */

echo "\n ========================================== MYSQLI MULTI QUERIES ENDS ========================================== \n";

mysqli_free_result($result);
/// The difference is that mysql_escape_string just treats the string as raw bytes, and adds escaping where it believes it's appropriate.
// mysql_real_escape_string, on the other hand, uses the information about the character set used for the MySQL connection. This means the string is escaped while treating multi-byte characters properly; i.e., it won't insert escaping characters in the middle of a character. This is why you need a connection for mysql_real_escape_string; it's necessary in order to know how the string should be treated.
/// mysqli_real_connect uses mysqli_init object to open connection to mysql server. mysqli_init can be used to put in options and configure the connection. Whereas in mysqli_connect its not possible to use options.
/// mysqli_options() should be called after mysqli_init() and before mysqli_real_connect().

echo "\n ======================== Prepared Statements ====================== \n";
/// Mysqli supports only positional ? prepared statements.

$mysqliAffectedCheck = mysqli_connect("localhost", "root", "12345" ,"sys_blog");
$stmtAffectedCheck = mysqli_prepare($mysqliAffectedCheck, "select * from test where id = ?");
$id = 1;
mysqli_stmt_bind_param($stmtAffectedCheck, "i", $id);
mysqli_stmt_bind_result($stmtAffectedCheck, $id, $name, $is_active, $unique);
mysqli_stmt_execute($stmtAffectedCheck);

print_r($result = mysqli_stmt_get_result($stmtAffectedCheck));
echo "\n -------------- Prepared Statement Affected/Num Rows Start ------------------- \n";
echo "AF -> ". mysqli_stmt_affected_rows($mysqliAffectedCheck);
echo PHP_EOL;
echo "NUM -> ".mysqli_stmt_num_rows($stmtAffectedCheck);
echo "\n";
echo "\n -------------- Prepared Statement Affected/Num Rows End 11 ------------------- \n";
while($row = mysqli_fetch_assoc($result)) {
    print_r($row);
}
$stmt = mysqli_prepare($mysqli, "select * from test where id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_bind_result($stmt, $id, $name, $is_active, $unique);
mysqli_stmt_execute($stmt);
while(mysqli_stmt_fetch($stmt)) { // Fetch results from a prepared statement into the bound variables
    echo "\n -------------- Prepared Statement Affected/Num Rows Start------------------- \n";
    echo mysqli_stmt_affected_rows($stmt);
    echo PHP_EOL;
    echo mysqli_stmt_num_rows($stmt);
    echo "\n";
    echo "\n -------------- Prepared Statement Affected/Num Rows End ------------------- \n";
    print_r("Id = ".$id);
    print_r("Name = ".$name);
    print_r("Is Active = ".$is_active);
    print_r("Unique = ".$unique);
}

$mysqliFetchT = mysqli_prepare($mysqli, 'select * from test');
$resultMysqliFetchT = mysqli_stmt_execute($mysqliFetchT);
while($r = mysqli_stmt_fetch($mysqliFetchT)) {
    print_r($r);
}


$mysqliFinal = mysqli_connect("localhost", "root", "12345", "sys_blog");
$queryPrep = mysqli_prepare($mysqliFinal, "select * from test where id IN (?,?,?)");
$id1 = 1;
$id2 = 3;
$id3 = 5;
mysqli_stmt_bind_param($queryPrep, "iii", $id1, $id2, $id3);
//mysqli_stmt_bind_param($queryPrep, "i", $id2);
//mysqli_stmt_bind_param($queryPrep, "i", $id3);
mysqli_stmt_execute($queryPrep);
//$resultFinal = mysqli_stmt_get_result($queryPrep);
print_r(mysqli_stmt_store_result($queryPrep));
echo PHP_EOL."Final Number Rows Check Before -> ".mysqli_stmt_num_rows($queryPrep).PHP_EOL; // becomes 0 when not using mysqli_stmt_store or mysqli_stmt_use
echo PHP_EOL."Final Affected Rows Check After -> ".mysqli_stmt_affected_rows($queryPrep).PHP_EOL; // works well with or without mysqli_stmt_store and mysqli_stmt_use

$mysqliFinalSt = mysqli_connect("localhost", "root", "12345", "sys_blog");
$query = "SELECT VERSION(), CURRENT_USER();";
if ($stmt = mysqli_prepare($mysqliFinalSt, $query)) {

    /* execute query */
    mysqli_stmt_execute($stmt);

    /* store result */
    print_r(mysqli_stmt_store_result($stmt));

    printf("Number of Affected rows: %d.\n", mysqli_stmt_affected_rows($stmt));
    printf("Number of rows: %d.\n", mysqli_stmt_num_rows($stmt));

    /* close statement */
    mysqli_stmt_close($stmt);
}

/* close connection */
mysqli_close($mysqliFinalSt);

echo "\n ------------------------ MYSQLI STMT DATA SEEK --------------------------- \n";
$mysqliFinalStN = mysqli_connect("localhost", "root", "12345", "sys_blog");
$prepStDS = mysqli_prepare($mysqliFinalStN, "select * from test;");
$table = `test`;
//mysqli_stmt_bind_param($prepStDS, "s",$table);
mysqli_stmt_bind_result($prepStDS, $id, $name, $active, $unique);
mysqli_stmt_execute($prepStDS);
//$resultSt = mysqli_stmt_store_result($prepStDS);
//print_r($resultSt);
//print_r($rowST = mysqli_stmt_store_result($prepStDS));
mysqli_stmt_data_seek($prepStDS, 5);
$resultSet = mysqli_stmt_get_result($prepStDS);
print_r(mysqli_fetch_assoc($resultSet));
//mysqli_stmt_fetch($prepStDS);
//echo $id.PHP_EOL;
//echo $name.PHP_EOL;
//echo $active.PHP_EOL;
//echo $unique.PHP_EOL;
//print_r(mysqli_fetch_assoc($rowST));
//print_r(mysqli_stmt_store_result($stmt));


echo PHP_EOL."------- Check on bind params ------- ".PHP_EOL;
$mysqliCheck = mysqli_connect("localhost", "root", "12345" ,"sys_blog");
$stmtCheck = mysqli_prepare($mysqliCheck, "select * from test where id = ? and is_active = ?");
$ida = 1;
$namea = "kushagra";
$activea = 1;
$ar = [$ida, $activea];
mysqli_stmt_bind_param($stmtCheck, "ii", ... $ar);
//mysqli_stmt_bind_param($stmtCheck, "i", $id);
//mysqli_stmt_bind_param($stmtCheck, "s", $name);
//mysqli_stmt_bind_param($stmtCheck, "i", $active);

mysqli_stmt_execute($stmtCheck);
mysqli_stmt_store_result($stmtCheck);
var_dump(mysqli_stmt_num_rows($stmtCheck));
$params = ['$id', '$name', '$is_active', '$unique'];
mysqli_stmt_bind_result($stmtCheck, ... $params);
//var_dump($store);
//var_dump(mysqli_stmt_fetch($stmtCheck));
while(mysqli_stmt_fetch($stmtCheck)) {
    echo PHP_EOL;
    echo $id;
    echo PHP_EOL;
    echo $name;
    echo PHP_EOL;
    echo $is_active;
    echo PHP_EOL;
    echo $unique;
}

$arr = ["id", "name", "active"];
$cont = [];
foreach($arr as $v) {
    array_push($cont, "$".$v);
}
print_r($cont);
//print_r(mysqli_stmt_get_result($stmtCheck));