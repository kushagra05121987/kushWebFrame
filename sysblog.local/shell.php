<?php
$o1 = shell_exec('ls -la'); // returns all and do not dump anything
echo "ONE => <hr />";
$o2 = exec('ls -la'); // does not dump and returns only last line
echo "TWO => <hr />";
$o3 = system('ls -la'); //  dump everything immediately and returns only last line
echo "Three => <hr />";
$o4 = passthru('ls -la'); // won't return anything and dump immediately

echo "FOUR => <hr />";
print_r($o1);
echo "<hr />";
echo "<hr />";

print_r($o2);
echo "FIVE => <hr />";
echo "<hr />";
echo "<hr />";

print_r($o3);
echo "SIX => <hr />";
echo "<hr />";
echo "<hr />";
echo "<hr />";
print_r($o4);