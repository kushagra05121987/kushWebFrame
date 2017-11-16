<?php
$host = '127.0.0.1';
$db   = 'sys_blog';
$user = 'root';
$pass = '12345';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::ATTR_PERSISTENT => true
];
$pdo = new PDO($dsn, $user, $pass, $opt);

//if(!getenv("pdoDBAdapter")) {
//	$pdo = new PDO($dsn, $user, $pass, $opt);
//	putenv('pdoDBAdapter='. json_encode($pdo));
//}
//$pdo = json_decode(getenv('pdoDBAdapter'));
//$stmt = $pdo->prepare('call checkMe(2, @io1, @io2, @io3)');
//$stmt->execute();
//$stmt = $pdo->prepare('select @io1, @io2, @io3');
//$stmt->execute();
// $stmt = $pdo->prepare('select * from test');
// $stmt->execute();
$pdo -> query("call checkMe(2, @io1, @io2, @io3)");
$resource = $pdo->query('select @io1, @io2, @io3');
$pdo = null;
$result = $resource->fetchAll();
unset($pdo);
// print_r($pdo);
print_r($result);