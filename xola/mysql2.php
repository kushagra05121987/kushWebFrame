<?php
echo "<pre>";
// $link = mysqli_init();
 $adapter = mysqli_connect("localhost", "root", "12345", "sys_blog") or die("Cannot Connect");

// $link -> real_connect("p:localhost", "root", "12345", "sys_blog", 3306) or die("Cannot Connect");
// // $link = new mysqli("p:localhost", "root", "12345", "sys_blog") or die("Cannot Connect");
// // var_dump($link);
// // var_dump($adapter);
$adapter -> query("set @rOut1 = 12;");
$adapter -> query("set @rOut2 = 34;");
$resource = $adapter -> query("call checkMe(@rOut1, @rOut2)");
$resource = $adapter -> query("select @rOut1, @rOut2");
// // $adapter -> query("call checkMe(2, @io1, @io2)");
// $resource = $adapter -> query("select * from test");

// $link -> query("call checkMe(2, @io1, @io2)");
// $link -> query("call checkMe(2, @io1, @io2)");
 // $resource = $adapter -> query("select @io1, @io2, @io3");

// var_dump($resource);
while($row = mysqli_fetch_assoc($resource)) {
	print_r($row);
}
echo " \n ============ Using PDO ========== \n ";
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
echo PHP_EOL. "First Call" .PHP_EOL;
$pdo = new PDO($dsn, $user, $pass, $opt);
print_r($pdo->query('SELECT CONNECTION_ID()')->fetch());

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
// $pdo -> query("set @c = 2;");
$pdo -> query("set @rOut1 = 12;");
$pdo -> query("set @rOut2 = 34;");
$resource = $pdo -> query("select @rInOut2 as rValue");
$result = $resource -> fetchAll();

if(!$result[0]['rValue']) {
	$pdo -> query("set @rInOut2 = 20;");
}
$resource = $pdo -> query("call checkMe()");
$resource = $pdo -> query("select @rInOut2");
// $resource = $pdo->query('select checkFunction()');
//$pdo = null;
$result = $resource->fetchAll();
//unset($pdo);
print_r($result);
//echo PHP_EOL. "Second Call" .PHP_EOL;
//$pdo = new PDO($dsn, $user, $pass, $opt);
//$resource = $pdo -> query("call checkMe(2, @io1, @io2, @io3)");
//$result = $resource->fetchAll();
////unset($pdo);
//// print_r($pdo);
//print_r($result);