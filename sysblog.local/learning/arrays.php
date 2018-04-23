<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29/9/17
 * Time: 11:25 PM
 */
//setlocale(LC_ALL, 'nl_NL');
//setlocale(LC_ALL, "");
setlocale(LC_ALL, 'es_ES');
//setlocale(LC_ALL, 'en_ZM');
$date = new DateTime();
echo strftime("%B", $date->getTimestamp());
echo "<pre>";
$array1 = $array2 = array("img12.png", "img10.png", "img2.png", "img1.png");

sort($array1);
echo "Sort\n";
print_r($array1);
print_r($array2);
rsort($array2);
echo "RSort\n"; // rsort reverse sorts the array from sort.
print_r($array2);
asort($array1); // sorts based on values in array maintaining key => value association
echo "Standard sorting\n";
print_r($array1);

natsort($array2); // sorts based on values in array maintaining key => value association but using natural sort algorithm like humans do.
echo "\nNatural order sorting\n";
print_r($array2);

$array3 = array("img1","img1", "img2", "img2", "img3");
echo "Array unique \n";
print_r(array_unique($array3));

echo "Array Chunk \n";
print_r(array_chunk($array3, 2, 1)); // creates array chunks given by the size parameter.Last parameter preserves the key bindings.

$array4 = array(
    array(
        'id' => 2135,
        'first_name' => 'John',
        'last_name' => 'Doe',
    ),
    array(
        'id' => 3245,
        'first_name' => 'Sally',
        'last_name' => 'Smith',
    ),
    array(
        'id' => 5342,
        'first_name' => 'Jane',
        'last_name' => 'Jones',
    ),
    array(
        'id' => 5623,
        'first_name' => 'Peter',
        'last_name' => 'Doe',
    )
);
echo "Array Column\n";
print_r(array_column($array4, 'first_name', 'last_name')); // Generates array from a specific column given as second parameter and prepares array keys based on last parameter

echo "Array Combine \n";
$array5 = array(1,2,3,4,5);
$array55 = array("ee" => 1,"rt" => 2,"ct" => 3,"st" => 4,"ry" => 5);
$array6 = array("one","two","three","four","five");
$array7 = array("extra" => "one", "new array" => "two", "to" => "three", "try" => "four","five");
print_r(array_combine($array5, $array6)); // uses array1 to get keys for new array and array 2 for getting values. Both arrays should have equal number of elements
print_r(array_combine($array55, $array7)); // uses array1 to get keys for new array and array 2 for getting values. Both arrays should have equal number of elements


echo "Array Merge\n";
$array7 = array(1,2,3,4,5);
$array8 = array("me" => "kushagra", "she" => "ekta");
$array9 = array("relation" => array("me" => "wife", "she" => "husband"), 2,3,4, "me" => "named flacon"); // same named keys get replaced while in array_merge_recursive all these values are put inside a sub array on the common key.
print_r(array_merge($array7, $array8, $array9));

echo "Array Reverse\n";
print_r(array_reverse($array7));
print_r(array_reverse($array8));

echo "Array Count Values \n";
print_r(array_count_values($array3)); // counts the number of occurrences of every value in array

echo "List \n";
list($a, $b, $c) = array("My", "Name", "Is", "Kushagra", "MIshra"); // list helps to assign variables to their corresponding counterparts in array
echo "$a $b $c \n";
list($a, $b, $c, $d) = array("My", "Name", "Is", "Kushagra");
echo "$a $b $c $d \n";

echo "Array Fill \n";
// Inserts a given common string given number of times starting at a specific position
//        this is starting index , Next is the number of elements to be inserted, Then is the common value to be inserted
// so the below line means create an array starting at 0 with 10 elements in it and the values of those elements must be "My Big Dick"
$a = array_fill(0, 10, "My Big Dick");
$b = array_fill(5, 20, "My heavy round balls");
$c = array_fill(-3, 10, "Hey There Brown Fox.");
print_r($a);
print_r($b);
print_r($c);

echo "Array Fill Keys \n";
// Makes every element in array a key and associates is with the value passed
$keys = array("new", "key", 34, 50, "end");
$a = array_fill_keys($keys, "Quick Brown Fox.");
$b = $a; // creates a copy though in php 7 every thing except numeric types are returned as pointers and not original values
array_push($b, 1);
print_r($b);
print_r($a);
sort($a); // removes the keys and their associations giving them new numeric keys
print_r($a);
asort($b);
print_r($b);

echo "Array Range \n";
// generate array within given range as from 10th position to 100th position giving 10 as increment every time
$array = range(10, 100, 10);
print_r($array);

echo "Array Filter \n";
// Filter array by user defined function. If 0 is returned that set of key value is discarded
$arrayFilter = array(1,2,4,5,65,6, "my" => "key", "new" => "value");
$a = array_filter($arrayFilter, function($value, $key) {
    echo $key." => ".$value."\n";
    return $value;
}, ARRAY_FILTER_USE_BOTH);
$a = array_filter($arrayFilter, function($key) {
    echo $key."\n";
    return $key;
}, ARRAY_FILTER_USE_KEY); // removes first element as it is 0 which makes it false and hence discarded
print_r($a);
$a = array_filter($arrayFilter, function($value) {
    echo $value."\n";
    return $value;
}); // without any flag it gives only values in callback
print_r($a);

echo "Array Map \n";
$array1 = range(10,100, 10);
$array2 = array("one"=>1, "two"=>2, "three"=>3);
// Array map can only take value and not keys. This array_map just takes in the value and passes it to callback. Return type is array created by the value returned from callback.
$c = array_map(function(& $n) {
    $n = "This is not returned $n";
    echo "$n\n";
}, $array1, $array2); // if we don't return anything then all the values for keys will be empty
print_r($c);

$c = array_map(function(& $n) {
    echo "$n\n";
    $n = "This is new $n using pointer"; // just by modifying it here without returning it won't work as in array_walk
    return "This is value $n";
}, $array1, $array2);
print_r($c);

echo "Array Merge Recursive \n";
// Takes in multiple arrays and merges them with keys. Doesn't remove duplicate values but if same key is found in more than one array then that key is assigned a new array with all the values of that key from other different arrays
$ar1 = array("color" => array("favorite" => "red"), 5, 10, "key" => 20);
$ar2 = array(10, "color" => array("favorite" => "green", "blue"), "key" => 30);
$result = array_merge_recursive($ar1, $ar2, $array7);
$result2 = array_merge($ar1, $ar2); // this will overwrite the same key names and last array's keys persist
print_r($result);
print_r($result2);

echo "Array Walk \n";
// Array walk takes in three argument array, callback, optional user defined argument. In order to modify a value  we need to accept it as a pointer
$fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");

function test_alter(&$item1, $key, $prefix)
{
    $item1 = "$prefix: $key. $item1";
}

function test_print($item2, $key)
{
    $item2 = "$key. $item2";
    echo "$key. $item2<br />\n";
    return $item2; // it will not have any affect on array if we are not using pointer to array element to change it.
}

echo "Before ...:\n";
array_walk($fruits, 'test_print');
print_r($fruits);
array_walk($fruits, 'test_alter', 'fruit');
echo "... and after:\n";
print_r($fruits);

echo "================= MODIFICATION ================ \n";
$fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");\
array_walk($fruits, 'test_print');
$a = array_walk($fruits, function(&$value, $key, $opt) { // in order to modify the array we need to take pointer to the value and modify it
    echo "$key ===>>> $value\n";
    $value = $opt."-".$value;
//    return array($key => "$opt-$value");
}, 'fruit');
print_r($fruits);
//print_r($a); // gives 1 doesnt behave like array_map in which we can return the modification of values

echo "Array walk recursive \n";
// Works same as array walk but goes even inside of the nested array key to get the key value pair
$sweet = array('a' => 'apple', 'b' => 'banana');
$fruits = array('sweet' => $sweet, 'sour' => 'lemon');

function test_print_recur($item, $key)
{
    echo "$key holds $item\n";
}

array_walk_recursive($fruits, 'test_print_recur');

echo "KEY Exists \n";
var_dump(key_exists("a", $fruits)); // alias of array_key_exists
var_dump(array_key_exists("a", $fruits));

echo "KEY \n";
$array = array(
    'fruit1' => 'apple',
    'fruit2' => 'orange',
    'fruit3' => 'grape',
    'fruit4' => 'apple',
    'fruit5' => 'apple');
print_r(current($array)); // returns value from current position/index in array
echo "\n";
print_r(key($array)); // returns the index element of current array position
echo "\nAdvancing by one";
next($array); // advances the array pointer to next position
echo "\n";
print_r(current($array)); // returns value from current position/index in array
echo "\n";
print_r(key($array)); // returns the index element of current array position
echo "\nGoing back by one";
prev($array);
echo "\n";
print_r(current($array)); // returns value from current position/index in array
echo "\n";
print_r(key($array)); // returns the index element of current array position

echo "\n EACH \n ";
// similar to foreach but does not generate a loop
// combination of current , key and next
// deprecated as of 7.0.*
$input = array(1,2,3,4,5,6);
print_r(each($input));
print_r(each($input));
reset($input);
print_r(each($input));
end($input);
print_r(each($input));

echo "\nCompact\n";
// Compact does opposite of extract
$city  = "San Francisco";
$state = "CA";
$event = "SIGGRAPH";

$location_vars = array("city", "state");
//Creates an array containing variables and their values.
//For each of these, compact() looks for a variable with that name in the current symbol table and adds it to the output array such that the variable name becomes the key and the contents of the variable become the value for that key. In short, it does the opposite of extract().
///compact() takes a variable number of parameters. Each parameter can be either a string containing the name of the variable, or an array of variable names. The array can contain other arrays of variable names inside it; compact() handles it recursively.

$result = compact("event", "nothing_here", "location_vars"); // will use location_vars as is without checking variable names in keys
print_r($result);
$result = compact("event", "nothing_here", $location_vars); // will check for variable names in keys
print_r($result);
$result = compact($event, "nothing_here", $location_vars); // will not take $event as anything and will omit it. So if its only a single string then we should use name and not variable
print_r($result);

echo "Array Multisort \n";
// Sort multiple or multidimensional arrays
// this is a dependent sorting . This method sorts the first array first then based on the sorted first array it will sort the second array and then so on.
//// in this all the arrays must have the same number of elements then only this sort will work. Or we can say it will sort only the elements that have same number of elements. If we have to chain the sorting then we need to have all the array having same number of elements so that every other array can be used to sort the next one.
$array1 = array("apple", "lemon", "orange", "banana");
$array5 = array("bananas", "lemons", "oranges", "apples");
$array2 = range(10, 100, 10);
$array3 = array(13,2,34,4,52,6,79,80,91,210);
$array4 = array("apples", "Vegetables" => array("lauki", "kundru", "baingan", "mooli", "gajar"));
array_multisort($array5, $array4['Vegetables'], $array1, $array2, $array3); // in this all the arrays must have the same number of elements then only this sort will work. Or we can say it will sort only the elements that have same number of elements. If we have to chain the sorting then we need to have all the array having same number of elements so that every other array can be used to sort the next one.
print_r($array1);
echo "\n";
//array_multisort($array2);
print_r($array2);
echo "\n";
//array_multisort($array3);
print_r($array3);
echo "\n";
//array_multisort($array1);
print_r($array4);

$ar1 = array(10, 100, 100, 0);
$ar2 = array(1, 3, 2, 4);
array_multisort($ar1, $ar2, SORT_DESC); // this will desc sort the elements which had their position unchanged in second

print_r($ar1);
print_r($ar2);

echo "\n";

echo "Array Pad \n";
// pads the array with a string specifying the new length of array
$arrayPad = range(1, 10);
$result1 = array_pad($arrayPad, 12, "game"); // pads with game to new array length of 12
$result2 = array_pad($arrayPad, 10, "game"); // not padded because same new length as original length
$result2 = array_pad($arrayPad, 10, "game"); // not padded because same new length as original length
print_r($result1);
echo "\n";
print_r($result2);
echo "\n";
echo "Array PUSH \n";
$arrayPush = [1,2,3,4];
array_push($arrayPush, 12);
array_push($arrayPush, 20,20,30);
print_r($arrayPush);
echo "\n";

echo "Array POP \n";
array_pop($arrayPush);
print_r($arrayPush);
echo "\n";

echo "Array product \n";
print_r(array_product(array())); // with empty array gives 1
echo "\n";
print_r(array_product(array(21,23,45,67,89))); // computes product of all the elements
echo "\n";
print_r(array_product(array(21,23,45,67,89, "jkey" => array(12,2,3)))); //omits associative key

echo "\nArray sum \n ";
print_r(array_sum(array())); // gives 0
echo "\n";
print_r(array_sum(array(12,34,45,56,67)));// computes sum of all the elements
echo "\n";
print_r(array_sum(array(12,34,45,56,67,"key" => array(12,23,345))));//omits associative key

echo "\nArray random \n";
// Picks given number of random values from array
$input = array("Neo", "Morpheus", "Trinity", "Cypher", "Tank");
$rand_keys = array_rand($input, 2);
print_r($rand_keys);
echo $input[$rand_keys[0]] . "\n";
echo $input[$rand_keys[1]] . "\n";

echo "\nNat Case sort \n";
// Sorts array using natural lexical sorting as humans do without taking case in consideration. Sort an array using a case insensitive "natural order" algorithm
$array1 = $array2 = array('IMG13.png', 'img12.png', 'img10.png', 'img2.png', 'img1.png', 'IMG3.png');
natcasesort($array1);
natsort($array2);
print_r($array1);
print_r($array2);

/**
 * We can convert string to array as follow but array to string is not possible.
 */
$d = "sdsds";
$ar = array("sffdfd");
print_r((array) $d);
//print_r((string) $ar);

echo "\n Array Splice \n";
// The starting position is included in removal but ending position is excluded.
// If length is specified and is zero, no elements will be removed. And with length of 1 self is removed.
// Array splice is used to replace element/s in array at given position till given length by a given value.
// Array splice Removes a portion of the array and replace it with something else
// append two elements to $input
$input = range(10, 1000, 100);
$x = "lemon";
$y = "papaya";
array_push($input, $x, $y);
echo count($input);
echo sizeof($input);
array_splice($input, count($input), 0, array($x, $y));
echo "Append\n";
print_r($input);
echo "\n";

// remove the last element of $input
array_pop($input);
array_splice($input, -1);
echo "remove the last element of input \n";
print_r($input);
echo "\n";

// remove the first element of $input
array_shift($input);
array_splice($input, 0, 1);
echo "remove the first element of input \n";
print_r($input);
echo "\n";

// insert an element at the start of $input
array_unshift($input, $x, $y);
array_splice($input, 0, 0, array($x, $y));
echo "insert an element at the start of input \n";
print_r($input);
echo "\n";

// replace the value in $input at index $x
$x = 2;

$input[$x] = $y; // for arrays where key equals offset
array_splice($input, $x, 1, $y);
echo "replace the value in input at index x \n";
print_r($input);
echo "\n";
$input = [1,2,3,4,5,6,7,8,9,0, "key" => [1,2,3,4], "value"];
array_splice($input, -2, 2, "new thing");
print_r($input);
echo "\n";

echo "Array Slice \n";
// Extracts a slice of array at a given position and till given length without actually removing it from array.
// If length is omitted, then the sequence will have everything from offset up until the end of the array.
$input = [1,2,3,4,5,6,7,8,9,0, "key" => [1,2,3,4], "value"];
print_r(array_slice($input, 2, -1, true));
print_r(array_slice($input, 2, -1, false));
print_r(array_slice($input, 2, 7, false));
print_r(array_slice($input, -2, 7, false));
print_r(array_slice($input, -2, 7, true));

echo "\n Array Search \n";
$input = array("lamb"=>"white", "dog"=>"off white", "sheep"=>"black");
print_r(array_search("white", $input));

echo "\n Array Shift \n";
// Remove element from beginning of array
$input = [1,2,3,4,5,6,7];
array_shift($input);
print_r($input);

echo "\n Array Unshift \n ";
array_unshift($input, 10,20);
print_r($input);

echo "\n ======= ISSET vs EMPTY ============= \n";
$x = 10;
$y = null;
$z;
$input = array();
$input2 = array(1,2);
echo "\n =============== FIRST RUN =============== \n";
var_dump(isset($x));
echo "\n";
var_dump(empty($x));
echo "\n =============== SECOND RUN =============== \n";
var_dump(isset($y));
echo "\n";
var_dump(empty($y));
echo "\n =============== THIRD RUN =============== \n";
var_dump(isset($z));
echo "\n";
var_dump(empty($z));
echo "\n =============== FOURTH RUN =============== \n";
var_dump(isset($input));
echo "\n";
var_dump(empty($input));

echo "\n Array Replace \n";
// Replaces the first array values with the values from other arrays passed where the key from first array matches . If keys dont match then from first array then those values are left unchanged . values from other arrays that dont match are added at appropriate position in first array
$base = array("orange", "banana", "apple", "raspberry");
$replacements = array(0 => "pineapple", 4 => "cherry");
$replacements2 = array(0 => "grape");

$basket = array_replace($base, $replacements, $replacements2);
print_r($basket);
print_r(array_merge($base, $replacements, $replacements2));
$a = array('a' => 'hello', 'b' => 'world');
$b = array('a' => 'person', 'b' => 'thing', 'c'=>'other', '15'=>'x');

print_r(array_merge($a, $b));
/*Array
(
    [a] => person
    [b] => thing
    [c] => other
    [0] => x
)*/

print_r(array_replace($a, $b));
/*Array
(
    [a] => person
    [b] => thing
    [c] => other
    [15] => x
)*/
// Array replace also merges two arrays.

echo "\n Array Replace Recursive \n";
$base = array('citrus' => array( "orange", 'eggs', 'straw') , 'berries' => array("blackberry", "raspberry"), );
$replacements = array('citrus' => array('pineapple', 'apple'), 'berries' => array('blueberry'));

$basket = array_replace_recursive($base, $replacements);
print_r($basket);

$basket = array_replace($base, $replacements);
print_r($basket);

echo "\n Array Reduce \n";
// Reduce array to a single value
$input = array(1,2,3,4,5,6);
print_r(array_reduce($input, function($carry, $value) {
    echo "$carry, $value\n";
    return $carry+$value;
}));

echo "\n Array change key case \n ";
$input = array("small" => "one", "key" => "value", "column" => "value");
print_r(array_change_key_case($input, CASE_UPPER)); //CASE_LOWER
// for values to uppercase we can use array_flip then array_keys then array_change_key_case
// or we can use array_map

echo "\n Array Flip \n ";
$input = array("oranges", "apples", "pears");
$flipped = array_flip($input);

print_r($flipped);

echo "\n Array Shuffle \n ";
// destroys the keys and their order. Like shuffling of cards. Doesnot preserve keys
$input = array("small" => "one", "key" => "value", "column" => "value");
shuffle($input);
print_r($input);

echo "\n ksort \n";
$fruits = array("d"=>"lemon", "a"=>"orange", "b"=>"banana", "c"=>"apple");
ksort($fruits);
foreach ($fruits as $key => $val) {
    echo "$key = $val\n";
}
print_r($fruits);

echo "\n usort \n";
// THis will not preserve keys and rename them with 0 1 3 etc.
// sort array based on user defined function
// if first == second then dont do anything and return 0 , If first is less than second then also dont do anything and return -1, if first > second then exchange the position of two and return 1.
$input = array(34,50,1,2,23,12,23,34,50);
$input2 = array(50,1,2,3,4,5,6,7,8);
$input3 = array("lex1" => "hx234fg", "lex2" => "hx234ff", "lex3" => "hx234gg", "lex4" => "hy234fg", "lex5" => "zx234fg", "lex6" => "ax234fg", "lex7" => "ex234fg", "lex8" => "dx234fg", "lex9" => "h4234fg", "lex10" => "hx234fe", "lex11" => "h4234fg",);
usort($input, function($a, $b) {
    echo "$a - $b \n";
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
});
echo "==================== \n";
usort($input2, function($a, $b) {
    echo "$a - $b \n";
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
});

usort($input3, function($a, $b) {
    echo "$a - $b \n";
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
}); // does not maintain key associations
print_r($input);
print_r($input2);
print_r($input3);

// uksort same as usort but instead of values it receives keys
function cmp($a, $b)
{
    $a = preg_replace('@^(a|an|the) @', '', $a);
    $b = preg_replace('@^(a|an|the) @', '', $b);
    return strcasecmp($a, $b);
}

$a = array("John" => 1, "the Earth" => 2, "an apple" => 3, "a banana" => 4);

uksort($a, "cmp");

foreach ($a as $key => $value) {
    echo "$key: $value\n";
}

echo " \n UASORT \n ";
// Same as usort just maintains key => value association while matching the values.
// Comparison function
function cmpua($a, $b) {
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
}

// Array to be sorted
$array = array('a' => 4, 'b' => 8, 'c' => -1, 'd' => -9, 'e' => 2, 'f' => 5, 'g' => 3, 'h' => -4);

// Sort and print the resulting array
uasort($array, 'cmpua');
print_r($array);
usort($array, 'cmpua');
print_r($array);

echo "\n Array Diff \n";
// One or more arrays
// preserves the keys
$array1 = array("a" => "green", "red", "blue", "red");
$array2 = array("b" => "greens", "yellow", "red");
$result = array_diff($array1, $array2);

print_r($result);

echo "\n Array Intersect \n";
// One or more arrays
// preserves the keys
$array1 = array("a" => "green", "red", "blue", "red");
$array2 = array("b" => "green", "yellow", "red");
$result = array_intersect($array1, $array2);

print_r($result);
