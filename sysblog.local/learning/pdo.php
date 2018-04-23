<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 31/10/17
 * Time: 7:39 PM
 */
/***
 * PDO::ATTR_CASE: Force column names to a specific case.

PDO::CASE_LOWER: Force column names to lower case.

PDO::CASE_NATURAL: Leave column names as returned by the database driver.

PDO::CASE_UPPER: Force column names to upper case.

PDO::ATTR_ERRMODE: Error reporting.

PDO::ERRMODE_SILENT: Just set error codes.

PDO::ERRMODE_WARNING: Raise E_WARNING.

PDO::ERRMODE_EXCEPTION: Throw exceptions.

PDO::ATTR_ORACLE_NULLS (available with all drivers, not just Oracle): Conversion of NULL and empty strings.

PDO::NULL_NATURAL: No conversion.

PDO::NULL_EMPTY_STRING: Empty string is converted to NULL.

PDO::NULL_TO_STRING: NULL is converted to an empty string.

PDO::ATTR_STRINGIFY_FETCHES: Convert numeric values to strings when fetching. Requires bool.

PDO::ATTR_STATEMENT_CLASS: Set user-supplied statement class derived from PDOStatement. Cannot be used with persistent PDO instances. Requires array(string classname, array(mixed constructor_args)).

PDO::ATTR_TIMEOUT: Specifies the timeout duration in seconds. Not all drivers support this option, and its meaning may differ from driver to driver. For example, sqlite will wait for up to this time value before giving up on obtaining an writable lock, but other drivers may interpret this as a connect or a read timeout interval. Requires int.

PDO::ATTR_AUTOCOMMIT (available in OCI, Firebird and MySQL): Whether to autocommit every single statement.

PDO::ATTR_EMULATE_PREPARES Enables or disables emulation of prepared statements. Some drivers do not support native prepared statements or have limited support for them. Use this setting to force PDO to either always emulate prepared statements (if TRUE and emulated prepares are supported by the driver), or to try to use native prepared statements (if FALSE). It will always fall back to emulating the prepared statement if the driver cannot successfully prepare the current query. Requires bool.

PDO::MYSQL_ATTR_USE_BUFFERED_QUERY (available in MySQL): Use buffered queries.

PDO::ATTR_DEFAULT_FETCH_MODE: Set default fetch mode. Description of modes is available in PDOStatement::fetch() documentation.
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
// creating pdo connection using string in dsn
$pdo = new \PDO("mysql:host=localhost;dbname=sys_blog;charset=utf8mb4", "root", "12345", [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false   ,
    PDO::ATTR_PERSISTENT => true
]);

// Opening pdo connection using uri in dsn
//$pdo = new \PDO("file:///var/www/sysblog.local/learning/mysql.dsn");


// Running a query in pdo can be done in two ways
// 1). Through PDO::query() if there are no variable involved in query. This will run a query and returns a PDOStatement object with the result associated. It can be treated as resource in mysql_query()
// 2). Prepared Statements if there are any variables in query . It prevents passing unwanted data to queries which prevents certain attacks such as Sql Injection
echo "<pre>";
$stmt = $pdo -> query("select * from test;");
// this is pdo statement when we do fetch or fetch all then only we get actual result
var_dump($stmt);
echo "\n ===== \n";

// Statement class creates only one object or array for a query and always traverses through it only . So if you fetch something first from stmt and then do fetch all the returned value will start from the current point modified by previous fetch statements

$count = 0;
while(($row = $stmt -> fetch(PDO::FETCH_NUM)) && $count < 5) {
    echo "\n Starting Row \n";
    print_r($row);
    echo "\n Ending Row \n";
    ++$count;
}
echo "\n ======== Fetch All ======= \n";
print_r($stmt -> fetchAll(PDO::FETCH_ASSOC));

$stmtAr = (array) $stmt;
print_r((object) $stmtAr);

//$stmt -> closeCursor();
echo "\n ======== Fetch All ======= \n";
print_r($stmt -> fetchAll(PDO::FETCH_ASSOC));

// There is no possibility to reset the array obtained by pdo query fetch or fetchall . All we can do is do a fetchall and store it and then keep using it.
// It is required to never use quotes with :named or ? queries

// Prepared Statements
echo "\n ===== Prepared Statements ====== \n ";
$id = "1";
$name = "Kushagra";

ini_set("display_errors", 1);
error_reporting(E_ALL);
$stmtNorm = $pdo -> query("select * from test where id = $id and name = '$name';"); // Normal query without prepared statements

// Following prepare queries will not execute and contain results as happened in case of $pdo->query. They will only be prepared and will execute when $stmt->execute() is called
$stmtQuestionMark = $pdo -> prepare("select * from test where id = ? and name = ?;"); // Prepared query with ?
$stmtNamed = $pdo -> prepare("select * from test where id = :id and name = :name;"); // Prepared query with :named parameters

echo "\n ===== Normal Query Result ===== \n ";
$result = $stmtNorm -> fetch();
print_r($result);

echo "\n ===== Prepared ? Query Result ===== \n ";
$execute = $stmtQuestionMark -> execute(array($id, $name)); // here parameter are taken as strings. This returns true and not the object of statement
$result = $stmtQuestionMark -> fetch(); // fetch has to performed on statement only and not on execute return value
print_r($result);
/**
 * emulate prepared statement off work like the below because mysql don't have any native support for named preapred statements
 * Following code works when prepare emulate mode is off.
 */
//$execute2 = $stmtQuestionMark -> execute(array("id" => $id, "name" => $name)); // here parameter are taken as strings. This returns true and not the object of statement
//$result = $stmtQuestionMark -> fetch(); // fetch has to performed on statement only and not on execute return value
//print_r($result);

echo "\n ===== Prepared :named Query Result ===== \n ";
$execute3 = $stmtNamed -> execute(["id" => $id, "name" => $name]); // here parameter are taken as strings
$result = $stmtNamed -> fetch();
print_r($result);
/**
 * Following code works when prepare emulate mode is off
 */
//$execute4 = $stmtNamed -> execute([$id, $name]); // This also works . So the understanding that for named queries only associative arrays work is wrong
//$result = $stmtNamed -> fetch();
//print_r($result);

/// In all the above cases parameters passed in execute are taken as strings but that is ok only in some queries whereas the others expect data to be in specific type
/// LIMIT clause (or any other SQL clause that just cannot accept a string operand) if emulation mode is turned ON.
// complex queries with non-trivial query plan that can be affected by a wrong operand type
// peculiar column types, like BIGINT or BOOLEAN that require an operand of exact type to be bound (note that in order to bind a BIGINT value with PDO::PARAM_INT you need a mysqlnd-based installation).

/// To address such issues and to put a hard restriction on what values the query should take we can use bindValue() or bindParam().
/// bindParam and bindValue differ on following points
/// 1). bindParam takes the values by reference and not by value, that means if after binding a variable and before executing we change the value of the variable, the change will reflect in query but in case of bindValue() the variable is read by value and not by reference so the changes in the variable wont reflect.
/// 2). In bindParam we can also provide the length of the argument but in bindValue there is no option to provide length.

/// PDO::ATTR_EMULATE_PREPARES ->
///  prepared queries work in two ways
/// 1). by transmitting data directly to mysql server with binding the actual values. So when we prepare we are just sending the query as is without dumping the data into it the data is sent when we execute the query.
/// 2). by preparing the query putting in all the bound data into it and then sending it to the mysql server . Execute will finally execute the query.
/// 1st mode is for PDO::ATTR_EMULATE_PREPARES = false while 2nd mode is PDO::ATTR_EMULATE_PREPARES = true
/// In first mode PDO will not have fully prepared query with itself but in 2nd mode it will but will not be exposed to us fo use.
/// The default value is TRUE, like
//$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES,true);
//
//This means that no prepared statement is created with $dbh->prepare() call. With exec() call PDO replaces the placeholders with values itself and sends MySQL a generic query string.
// When using named queries (:name) and PDO::ATTR_EMULATE_PREPARES = false the named parameters are replaced with ? and then sent to mysql server
$pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
echo "\n++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ BEHAVIOUR WITH PDO::ATTR_EMULATE_PREPARES = true ++++++++++++++++++++++++++++++++++++++++++++++++++++++\n";
echo "\n ===== Binding Parameters ===== \n ";
echo "\n ============================================= bindValue ================================================== \n";

echo "\n ------------------ Question Mark Value ------------------- \n";
$id = 1;
$name = "name 2";
$active = true;
//$pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$stmtBindValueQuestion = $pdo -> prepare("select * from test where id = ? and name = ? and is_active = ?");

$stmtBindValueQuestion -> bindValue(1, $id, PDO::PARAM_INT);
$stmtBindValueQuestion -> bindValue(2, $name, PDO::PARAM_STR);
$stmtBindValueQuestion -> bindValue(3, $active, PDO::PARAM_BOOL);
$stmtBindValueQuestion -> execute();
$result = $stmtBindValueQuestion -> fetchAll();
print_r($result);

echo "\n -------------------- Named Mark Value ----------------------- \n";
$id = 1;
$name = "name 2";
$active = true;
//$pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$stmtBindValueNamed = $pdo -> prepare("select * from test where id = :id and name = :name and is_active = :active");
$stmtBindValueNamed -> bindValue(":id", $id, PDO::PARAM_INT);
$stmtBindValueNamed -> bindValue(":name", $name, PDO::PARAM_STR);
$stmtBindValueNamed -> bindValue(":active", $active, PDO::PARAM_BOOL);
//$stmtBindValueNamed -> bindValue(":active", $active, PDO::PARAM_INT);
$stmtBindValueNamed -> execute();
$result = $stmtBindValueNamed -> fetchAll();
print_r($result);

echo "\n ========================================== bindParam ======================================= \n";
echo "\n -------------------- Question Mark Value -------------------- \n";
$id = 1;
$name = "name 2";
$active = true;
//$pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$stmtBindparamQuestion = $pdo -> prepare("select * from test where id = ? and name = ? and is_active = ?");

$stmtBindparamQuestion -> bindParam(1, $id, PDO::PARAM_INT);
$stmtBindparamQuestion -> bindParam(2, $name, PDO::PARAM_STR);
$stmtBindparamQuestion -> bindParam(3, $active, PDO::PARAM_BOOL);

$stmtBindparamQuestion -> execute();
$result = $stmtBindparamQuestion -> fetchAll();
print_r($result);

echo "\n -------------------- Named Mark Value -------------------- \n";
$id = 1;
$name = "name 2";
$active = true;
//$pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$stmtBindParamNamed = $pdo -> prepare("select * from test where id = :id and name = :name and is_active = :active");

$stmtBindParamNamed -> bindParam(":id", $id, PDO::PARAM_INT);
$stmtBindParamNamed -> bindParam(":name", $name, PDO::PARAM_STR);
$stmtBindParamNamed -> bindParam(":active", $active, PDO::PARAM_BOOL);
//$stmtBindValueNamed -> bindParam(":active", $active, PDO::PARAM_INT);

$stmtBindParamNamed -> execute();
$result = $stmtBindParamNamed -> fetchAll();
print_r($result);

// bindValue or bindParam don't work with out ATTR_EMULATE_PREPARES being true
$pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
echo "\n++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ BEHAVIOUR WITH PDO::ATTR_EMULATE_PREPARES = false ++++++++++++++++++++++++++++++++++++++++++++++++++++++\n";
echo "\n ===== Binding Parameters ===== \n ";
echo "\n ============================================= bindValue ================================================== \n";

echo "\n ------------------ Question Mark Value ------------------- \n";
$id = 1;
$name = "name 2";
$active = true;
//$pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$stmtBindValueQuestion = $pdo -> prepare("select * from test where id = ? and name = ? and is_active = ?");

$stmtBindValueQuestion -> bindValue(1, $id, PDO::PARAM_INT);
$stmtBindValueQuestion -> bindValue(2, $name, PDO::PARAM_STR);
$stmtBindValueQuestion -> bindValue(3, $active, PDO::PARAM_BOOL);
$stmtBindValueQuestion -> execute();
$result = $stmtBindValueQuestion -> fetchAll();
print_r($result);

echo "\n -------------------- Named Mark Value ----------------------- \n";
$id = 1;
$name = "name 2";
$active = true;
//$pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$stmtBindValueNamed = $pdo -> prepare("select * from test where id = :id and name = :name and is_active = :active");
$stmtBindValueNamed -> bindValue(":id", $id, PDO::PARAM_INT);
$stmtBindValueNamed -> bindValue(":name", $name, PDO::PARAM_STR);
$stmtBindValueNamed -> bindValue(":active", $active, PDO::PARAM_BOOL);
//$stmtBindValueNamed -> bindValue(":active", $active, PDO::PARAM_INT);
$stmtBindValueNamed -> execute();
$result = $stmtBindValueNamed -> fetchAll();
print_r($result);

echo "\n ========================================== bindParam ======================================= \n";
echo "\n -------------------- Question Mark Value -------------------- \n";
$id = 1;
$name = "name 2";
$active = true;
//$pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$stmtBindparamQuestion = $pdo -> prepare("select * from test where id = ? and name = ? and is_active = ?");

$stmtBindparamQuestion -> bindParam(1, $id, PDO::PARAM_INT);
$stmtBindparamQuestion -> bindParam(2, $name, PDO::PARAM_STR);
$stmtBindparamQuestion -> bindParam(3, $active, PDO::PARAM_BOOL);

$stmtBindparamQuestion -> execute();
$result = $stmtBindparamQuestion -> fetchAll();
print_r($result);

echo "\n -------------------- Named Mark Value -------------------- \n";
$id = 1;
$name = "name 2";
$active = true;
//$pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$stmtBindParamNamed = $pdo -> prepare("select * from test where id = :id and name = :name and is_active = :active");

$stmtBindParamNamed -> bindParam(":id", $id, PDO::PARAM_INT);
$stmtBindParamNamed -> bindParam(":name", $name, PDO::PARAM_STR);
$stmtBindParamNamed -> bindParam(":active", $active, PDO::PARAM_BOOL);
//$stmtBindValueNamed -> bindParam(":active", $active, PDO::PARAM_INT);

$stmtBindParamNamed -> execute();
$result = $stmtBindParamNamed -> fetchAll();
print_r($result);

$pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
echo "\n++++++++++++++++++++++++++++++++++++++++++++++ BEHAVIOUR WITH PDO::ATTR_EMULATE_PREPARES = true and without BOOL ++++++++++++++++++++++++++++++++++++++++++++++++++\n";
echo "\n ===== Binding Parameters ===== \n ";
echo "\n ============================================= bindValue ================================================== \n";

echo "\n ------------------ Question Mark Value ------------------- \n";
$id = 1;
$name = "name 2";
$active = true;
//$pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$stmtBindValueQuestion12 = $pdo -> prepare("select * from test where id = ? and name = ? and is_active = ?");

$stmtBindValueQuestion12 -> bindValue(1, $id, PDO::PARAM_INT);
$stmtBindValueQuestion12 -> bindValue(2, $name, PDO::PARAM_STR);
$stmtBindValueQuestion12 -> bindValue(3, $active, PDO::PARAM_INT);
$stmtBindValueQuestion12 -> execute();
$result = $stmtBindValueQuestion12 -> fetchAll();
print_r($result);

echo "\n -------------------- Named Mark Value ----------------------- \n";
$id = 1;
$name = "name 2";
$active = true;
//$pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$stmtBindValueNamed = $pdo -> prepare("select * from test where id = :id and name = :name and is_active = :active");
$stmtBindValueNamed -> bindValue(":id", $id, PDO::PARAM_INT);
$stmtBindValueNamed -> bindValue(":name", $name, PDO::PARAM_STR);
$stmtBindValueNamed -> bindValue(":active", $active, PDO::PARAM_INT);
//$stmtBindValueNamed -> bindValue(":active", $active, PDO::PARAM_INT);
$stmtBindValueNamed -> execute();
$result = $stmtBindValueNamed -> fetchAll();
print_r($result);

echo "\n ========================================== bindParam ======================================= \n";
echo "\n -------------------- Question Mark Value -------------------- \n";
$id = 1;
$name = "name 2";
$active = true;
//$pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$stmtBindparamQuestion = $pdo -> prepare("select * from test where id = ? and name = ? and is_active = ?");

$stmtBindparamQuestion -> bindParam(1, $id, PDO::PARAM_INT);
$stmtBindparamQuestion -> bindParam(2, $name, PDO::PARAM_STR);
$stmtBindparamQuestion -> bindParam(3, $active, PDO::PARAM_BOOL);

$stmtBindparamQuestion -> execute();
$result = $stmtBindparamQuestion -> fetchAll();
print_r($result);
echo "\n -------------------- Named Mark Value -------------------- \n";
$id = 1;
$name = "name 2";
$active = true;
//$pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$stmtBindParamNamed = $pdo -> prepare("select * from test where id = :id and name = :name and is_active = :active");

$stmtBindParamNamed -> bindParam(":id", $id, PDO::PARAM_INT);
$stmtBindParamNamed -> bindParam(":name", $name, PDO::PARAM_STR);
$stmtBindParamNamed -> bindParam(":active", $active, PDO::PARAM_BOOL);
//$stmtBindValueNamed -> bindParam(":active", $active, PDO::PARAM_INT);

$stmtBindParamNamed -> execute();
$result = $stmtBindParamNamed -> fetchAll();
print_r($result);

/// From the above it can be observed that with bind param or bind value , with PDO::ATTR_EMULATE_PREPARES = true PDO::PARAM_BOOL does not work . The query will silently fail but if we pass PARAM_INT it starts working

echo "\n ++++++++++++++++++++++++ Executing Multiple Queries ++++++++++++++++++++++ \n ";
echo "\n ----------- With ? -------------- \n";
$pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$data = [
    1 => "name",
    1 => "is",
    130 => "name 2",
];
$stmt = $pdo->prepare('UPDATE test SET name = ? WHERE id = ?');
foreach ($data as $id => $active)
{
    $stmt->execute([$active, $id]);
}

echo "\n ------------- With :named -------------- \n";
$data = [
    1 => "new 2",
    1 => "name 2",
    130 => "is name 2",
];
$stmt = $pdo->prepare('UPDATE test SET name = :name WHERE id = :id');
foreach ($data as $id => $name)
{
    $stmt->execute(["name" => $name, "id" => $id]);
}

echo "\n ------------------ Row Count ------------------- \n";
$stmt = $pdo -> query("select * from test");
echo $stmt -> rowCount();
echo "\n";
$stmt = $pdo -> prepare("select * from test");
echo $stmt -> rowCount(); // returns 0 here because query is still not executed



echo "\n ===== Dump the information of the query prepared and executed ======= \n";
// the following information will not contain the actual query after binding params because that is internal to PDO and PDO will not expose it.
echo $stmtBindValueQuestion -> debugDumpParams();
echo $stmtBindValueQuestion -> queryString;

echo "\n";
echo $stmtBindValueNamed -> debugDumpParams();
echo $stmtBindValueQuestion -> queryString;

echo "\n ----------------------------------------------------------------------- Modes Of Fetch ------------------------------------------------------------------------ \n";
function prepare() {
    global $pdo;
    $pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $pdo -> query("select * from test");
}
function prepareFetch() {
    global $pdo;
    return $pdo -> prepare("select * from test");
}
class a {
    public $id = 0;
    public $name = "";
    public $is_active = false;
}
echo "\n ---- Num ----- \n";
print_r(prepare() -> fetch(PDO::FETCH_NUM));
echo "\n ---- Assoc ----- \n";
print_r(prepare() -> fetch(PDO::FETCH_ASSOC));
echo "\n ---- Both ----- \n";
print_r(prepare() -> fetch(PDO::FETCH_BOTH));
echo "\n ---- Obj ----- \n";
print_r(prepare() -> fetch(PDO::FETCH_OBJ));
echo "\n ---- Lazy ----- \n";
print_r(prepare() -> fetch(PDO::FETCH_LAZY));
echo "\n ---- BOUND ----- \n";
$stmtBound = $pdo -> prepare("select * from test");
$stmtBound -> bindColumn(1, $idBound);
$stmtBound -> bindColumn(2, $nameBound);
$stmtBound -> bindColumn(3, $uniqueBound);
$stmtBound -> execute();
print_r($stmtBound -> fetch(PDO::FETCH_BOUND));
echo "\n ID = $idBound \n";
echo "\n NAME = $nameBound \n";
echo "\n UNIQUE = $uniqueBound \n";
//print_r(prepare() -> fetchAll(PDO::FETCH_LAZY)); /// LAZY cannot be used with fetchAll

echo "\n ---- Class ----- \n";
// in this mode class variable are initialised first before calling constructor . If we want to change this behaviour then we need to pass FETCH_PROPS_LATE as well
print_r(prepare() -> fetchAll(PDO::FETCH_CLASS, "a"));
echo "\n ---- Class Mode With Fetch----- \n";
// when using fetch instead of fetchAll we need to use setFetchMode on prepared statement first it will not work without that as it works in fetchAll
$st = prepareFetch();
$st -> setFetchMode(PDO::FETCH_CLASS, "a");
$st -> execute();
print_r($st -> fetch(   PDO::FETCH_CLASS));

echo "\n ------- Function ------ \n ";
// PDO::FETCH_FUNC is only allowed in fetchAll and not in fetch
//$st = prepareFetch();
//$st -> setFetchMode(PDO::FETCH_FUNC, function($arg) {
//    print_r($arg);
//});
//$st -> execute();
prepare() -> fetchAll(PDO::FETCH_FUNC, function($id, $name, $active) {
    echo "\n ------- Row ----- \n";
    print_r($id);
    echo "\n";
    print_r($name);
    echo "\n";
    print_r($active);
});

echo "\n ------------------------------------------------------------------- Fetch Cursors ------------------------------------------------------------------------ \n";
/// CURSOR_SCROLL IS NOT SUPPORTED IN MYSQL
/// SO THE FOLLOWING CODE WONT WORK
//echo "\n ----- FETCH_ORI_NEXT ----- \n";
//$st = prepareFetch();
//$st -> setAttribute(PDO::ATTR_CURSOR,PDO::CURSOR_SCROLL);
//$st -> execute();
//print_r($st -> fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT));
//print_r($st -> fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT));
//echo "\n ----- FETCH_ORI_PRIOR ----- \n";
////$st = $pdo -> prepare("select * from test");
////$st -> execute();
//print_r($st -> fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_PRIOR));
//echo "\n ----- FETCH_ORI_ABS ----- \n";
////$st = $pdo -> prepare("select * from test");
////$st -> execute();
//print_r($st -> fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_ABS, 2));
//echo "\n ----- FETCH_ORI_REL ----- \n";
////$st = $pdo -> prepare("select * from test");
////$st -> execute();
//print_r($st -> fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_REL, 2));
//echo "\n ----- FETCH_ORI_FIRST ----- \n";
////$st = $pdo -> prepare("select * from test");
////$st -> execute();
//print_r($st -> fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_FIRST));
//echo "\n ----- FETCH_ORI_LAST ----- \n";
////$st = $pdo -> prepare("select * from test");
////$st -> execute();
//print_r($st -> fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_LAST));
echo " \n --------------- Fetch Object ----------------- \n";
$stmt = prepareFetch();
$stmt -> execute();
print_r($stmt -> fetchObject("a"));

echo "\n ------------------------------------------ Fetch Column Using Fetch -------------------------------------------- \n";
$stmt = prepareFetch();
$stmt -> execute();
print_r($stmt -> fetchColumn());
echo "\n";
print_r($stmt -> fetchColumn(1));

echo "\n ------------------------------------------ Fetch Column Using Fetch All -------------------------------------------- \n";
$stmt = prepareFetch();
$stmt -> execute();
print_r($stmt -> fetchAll(PDO::FETCH_COLUMN));
$stmt = prepareFetch();
$stmt -> execute();
print_r($stmt -> fetchAll(PDO::FETCH_COLUMN, 1));


echo "\n ----------------------------------------------- Different Modes Of Fetch All -------------------------------------------- \n";
echo "\n Normal \n";
print_r(prepare() -> fetchAll());
echo "\n FETCH_COLUMN \n";
print_r(prepare() -> fetchAll(PDO::FETCH_COLUMN, 1));
echo "\n FETCH_ASSOC \n";
print_r(prepare() -> fetchAll(PDO::FETCH_ASSOC));
echo "\n FETCH_UNIQUE \n";
$pdoQSingleC = $pdo -> query('select name, id  from test');
print_r($pdoQSingleC -> fetchAll(PDO::FETCH_UNIQUE));
echo "\n FETCH_GROUP \n";
$pdoQSingleC = $pdo -> query('select name, id  from test'); // groups the second column based on the first one
print_r($pdoQSingleC -> fetchAll(PDO::FETCH_GROUP));
echo "\n FETCH_KEY_PAIR \n";
// if more than two columns are given error will be generated. This requires exactly two columns.
$stmt = $pdo -> query("select id, name from test;");
print_r($stmt -> fetchAll(PDO::FETCH_KEY_PAIR)); // this mode requires the result set to have exactly two column if more than two columns are returned in result set then PDOException is thrown


/// PDO is using the same function for returning both number of rows returned by SELECT statement and number of rows affected by DML queries - PDOstatement::rowCount(). Thus, to get the number of rows affected, just call this function after performing a query.
/// By default rowCount() returns the number of rows affected by the query not the number of row matched . It might happen that the actual row might not be affected by the query but during the matching the row was picked up. If we want to pick the number of rows matched and not affected then we need PDO::MYSQL_ATTR_FOUND_ROWS constant to be set during pdo instantiation

echo "\n -------------------------------------------------- Getting Row Counts ---------------------------------------------------------- \n";
$pdo = new \PDO("mysql:host=localhost;dbname=sys_blog;charset=utf8mb4", "root", "12345", [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::ATTR_PERSISTENT => true,
//    PDO::MYSQL_ATTR_FOUND_ROWS => true // doesnt work with mysql
]);
//echo $pdo -> getAttribute(PDO::MYSQL_ATTR_FOUND_ROWS); // PDO::MYSQL_ATTR_FOUND_ROWS is not supported by mysql.
//$stmt = $pdo -> prepare("update test set uniqueEntry = 2 where name = ? and is_active = 0");
//$stmt -> execute(["mishra", false]);
//echo $stmt -> rowCount(); // always returns the number of rows affected

echo "\n ------------------------------------ Last Insert Id ---------------------------------------- \n";
//PDO::lastInsertId is concurrent environment safe.
//$pdo -> query("insert into test(name, is_active, uniqueEntry) values('kushagra', true, 11)");
//echo $pdo -> lastInsertId();

// Whatever we pass in prepared statement is passed completely as a string or integer. No partial passing will be done. Hence for Like and In queries we have to be careful.
echo "\n ----------------------------------------------- Like Query --------------------------------------------------------\n";
// Like statements have to created separately first and then passed on to prepared statements.
$stmt = $pdo -> prepare("select * from test where name like ?");
$name = "%agra%";
$stmt -> execute([$name]);
print_r($stmt -> fetchAll());

echo "\n ----------------------------------------------- In Query --------------------------------------------------------- \n";
// If we pass a string like 1,2,4 to prepared statement it will be treated as a string and hence the query select * from test in (1,2,4) will become select * from test in ('1,2,4')

$stmt = $pdo -> prepare("select * from test where id IN (?,?,?);");
$stmt -> execute([1,2,3]);
print_r($stmt -> fetchAll());

echo "\n --------------------- Check Query With Quotes ------------------- \n";
$stmt = $pdo -> prepare("select * from test where name like ?");
$p = "my 'quoted' string";
$stmt -> execute([$p]);
// the above query gets converted to select * from test where name like 'my \'quoted\' string' Adding necessary slashes.

echo "\n Execute Multiple queries \n ";
$pdoT = new \PDO("mysql:host=localhost;dbname=sys_blog;charset=utf8mb4", "root", "12345", [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => true   ,
    PDO::ATTR_PERSISTENT => false,
    PDO::MYSQL_ATTR_MULTI_STATEMENTS => true
]);
//$stmtPrepare = $pdoT -> prepare("select ? as c1, ? as c2, ? as c3, ? as c4 UNION select * from test;");
//$stmtPrepare -> execute([1,2,3,4]);
//echo $stmtPrepare -> columnCount();

$stmtQuery = $pdoT -> query("select VERSION();select CURRENT_USER();");

//
do {
    echo " \n ======= In ======= \n";
    $data = $stmtQuery->fetchAll();
    var_export($data);
} while ($stmtQuery->nextRowset());

//$id = 3;
//$active = true;
//$stmt = $pdo -> prepare("select * from test where id = :id and is_active = :active");
//$stmt -> bindParam(":id", $id, PDO::PARAM_INT);
//$stmt -> execute(["active" => $active]);
//print_r($stmt -> fetchAll());

echo PHP_EOL."------------------ FETCH ALL TWO TEST ------------------".PHP_EOL;
$id = 1;
$pdoNN = new \PDO("mysql:host=localhost;dbname=sys_blog;charset=utf8mb4", "root", "12345", [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => true   ,
    PDO::ATTR_PERSISTENT => false
]);
$stmt = $pdoNN -> prepare("select * from test where id > :id");
$stmt -> execute(["id" => $id]);
print_r($stmt -> fetchAll());
print_r($stmt -> fetchAll());


echo "</pre>";
