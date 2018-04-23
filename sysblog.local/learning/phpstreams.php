<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/9/17
 * Time: 8:55 PM
 */
// file reads complete file in array
//var_dump(file("php://stdin"));
echo "<pre>";
print_r(stream_get_transports());
print_r(stream_get_wrappers());
print_r(stream_get_filters());
// Streams are like resources which can be opened by file, file_get_contents, fopen, stream_get_contents, etc and can be written to
// Every stream has a wrapper around it which makes it usable with some hooks and functions
// Streams have following structure
// <scheme>://<target>
// <scheme> is the name of the wrapper and <target> depends on the stream and wrapper
// File stream or file:// wrapper -> This is the default wrapper for all the files unless we specify the name of the scheme
//var_dump(file($handle)); // file needs a path not a resource like $handle
// Reading a file with file:// is same as reading it without it so file:// is the default wrapper on file system stream
// rewind take the file pointer back to the initial
readfile('op.txt');
echo "<hr />";
var_dump(file('file:///var/www/html/sysblog.local/op.txt'));

// php:// wrapper is a wrapper that php itself provides for its system wide stream such as input -> stdin stream, output -> stdout stream, error ->
// stderr stream . Corresponding wrappers are php://stdin, php://stdout, php://stderr. There is also one more wrapper that is provided by php
// php://input, this can be used for getting data in request body (raw data) from a post request

$ch = curl_init();
$payload = array("one" => 1, "two" => 2);
print_r(json_encode($payload));
curl_setopt($ch, CURLOPT_URL, 'http://sysblog.local/postcheck');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
    json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen(json_encode($payload)))
);
// in real life you should use something like:
// curl_setopt($ch, CURLOPT_POSTFIELDS,
//          http_build_query(array('postvar1' => 'value1')));

// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);

print_r($server_output); // This gives $_POST as empty because we are sending a request body instead of post data which is considered as a raw request in php
// and we received it with php://input

curl_close ($ch);


// php://stdin can be used to read only the input coming from system input stream which in case of cli is cli's stdin such as taking input from command line
// similar to php://stdin , php://stdout will send output to its wrappers stdout which in case of cli is cli's stdout
// because of above two reasons these two methods dont work on browsers as in browser the wrapper is apache or php-fpm which will run in background
// if we can run inn foreground then whatever we send from browser through stdout will be visible on apache's console
// below code works only cli as it binds php's input stream and keep listening to the new data as its being written in cli

// following code only works on cli because of above reason
//$f = fopen( 'php://stdin', 'r' );
//$line = "this is a new line \n" ;
//while( $line = fgets( $f )) {
//    echo $line;
//    echo "\n";
//    echo shell_exec($line);
//}
file_put_contents("php://stdout", "this is a new line \n");
//fclose( $f );

file_put_contents("php://output", "this is a new line \n"); // php://output works same as echo or print and output to browser
echo "Right Here";
print_r(file_get_contents( 'php://input'));

/***
 * php://memory and php://temp ¶

    php://memory and php://temp are read-write streams that allow temporary data to be stored in a file-like wrapper. The only difference between the two is that php://memory will always store its data in memory, whereas php://temp will use a temporary file once the amount of data stored hits a predefined limit (the default is 2 MB). The location of this temporary file is determined in the same way as the sys_get_temp_dir() function.

    The memory limit of php://temp can be controlled by appending /maxmemory:NN, where NN is the maximum amount of data to keep in memory before using a temporary file, in bytes.
 *
 */
echo "<br />";
file_put_contents("php://memory", "this is a new content");
var_dump(file_get_contents("php://memory" ));
// above produces nothing because file_put_contents automatically opens and closes the connection
$f = fopen('php://memory', 'w+');
fwrite($f, 'foo');
fwrite($f, 'bar');

rewind($f);
$contents = stream_get_contents($f);  //=> "foobar"
fclose($f);
print_r($contents);

$size = 5*1024*1024;
$f = fopen('php://temp/maxmemory:'.$size-1, 'a+');
fwrite($f, str_pad('MemoryCheckTempFileKushagra',$size, '.'));
rewind($f);
$contents = stream_get_contents($f);  //=> "foobar"
fclose($f);
echo "<br />";
//print_r($contents);
echo "<br />";
echo "temp dir";
echo sys_get_temp_dir();
//tmpfile(void) ;//- Creates a temporary file
//tempnam() ;//- Create file with unique file name
/**
 * string tempnam ( string $dir , string $prefix )
Creates a file with a unique filename, with access permission set to 0600, in the specified directory. If the directory does not exist or is not writable, tempnam() may generate a file in the system's temporary directory, and return the full path to that file, including its name.
 */

echo PHP_EOL;
echo "--------------- CHECKing memory storage stream after closing file handle -----------------------";
$fopen = fopen("php://temp", "w+");
fwrite($fopen, "this is now written");
fclose($fopen);
print_r(file("php://memory"));
echo PHP_EOL;

echo "<br />--------------- Filters ----------------<br />";
// Filters can be applied to other streams while we open them using file_get_contents, file_put_contents, file, readFile
// Writes data without applying any filters because no filters are specified
file_put_contents("php://filter//resource=file:///var/www/html/sysblog.local/somefile.txt","Hello World");

// Writes data with string.rot13 filter
file_put_contents("php://filter/write=string.rot13/resource=file:///var/www/html/sysblog.local/somefile.txt","Hello World");

// Read data and encode/decode
readfile("php://filter/read=string.toupper|string.rot13/resource=http://www.google.com");
//echo shell_exec("ls");
// builds query in the format of a=b&b=c with some encoding for sending it with POST request as a form data
$postdata = http_build_query(
    array(
        'var1' => 'some content',
        'var2' => 'doh'
    )
);
var_dump($postdata);

// PHP Stream Wrapper contexts
// Contexts are a set of options which are stream/wrapper specific which can be used to modify or enhance the functioning of the wrappers or streams
// for example with http REST requests we need to use curl but id we use contexts then for normal or basic request we dont need to use curl
// array(<wrapper> => array(options names) or option name)
$options = array(
    "http" => array(
        "method" => "POST",
        "header" => array("Custom-X-Header: Custom-X-Value","Content-type: application/json","Content-Length: ".strlen("{one: 1, two: 2}")),
        "content" => "{one: 1, two: 2}"
    )
);
$defaults = stream_context_get_default($options);
var_dump($defaults);
readfile("http://sysblog.local:8080/postcheck");

// Other context are
/**
Socket context options — Socket context option listing
HTTP context options — HTTP context option listing
FTP context options — FTP context option listing
SSL context options — SSL context option listing
CURL context options — CURL context option listing
Phar context options — Phar context option listing
MongoDB context options — MongoDB context option listing
Context parameters — Context parameter listing
Zip context options — Zip context option listing
 */

