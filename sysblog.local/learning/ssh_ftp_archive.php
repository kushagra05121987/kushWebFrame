<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25/9/17
 * Time: 7:53 PM
 */
/*
 * If we want to copy any file to ftp server in php
 * we can either use stream to read and write to it with ftp://
 * or we can use ftp_connect or ftp_ssl_connect -> ftp_login -> ftp_put
 * $file = 'somefile.txt';
 *
 */
$remote_file = 'readme.txt';

// set up basic connection
$conn_id = ftp_connect($ftp_server);

// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

// upload a file
if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
 echo "successfully uploaded $file\n";
} else {
 echo "There was a problem while uploading $file\n";
}

// close the connection
ftp_close($conn_id);
/*
 * or we can read it/ download it using ftp_get
 */
$local_file = 'local.zip';
$server_file = 'server.zip';

// set up basic connection
$conn_id = ftp_connect($ftp_server);

// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

// try to download $server_file and save to $local_file
if (ftp_get($conn_id, $local_file, $server_file, FTP_BINARY)) {
    echo "Successfully written to $local_file\n";
} else {
    echo "There was a problem\n";
}

// close the connection
ftp_close($conn_id);


$ftp_path = 'ftp://username:password@example.com/example.txt';

// Allows overwriting of existing files on the remote FTP server
$stream_options = array('ftp' => array('overwrite' => true));

// Creates a stream context resource with the defined options
// these context options need to be specified when using fopen or other fuctions.
// stream_context_get_default modifies the default stream options so doesnot need to be specified.
$stream_context = stream_context_create($stream_options);

// Opens the file for writing and truncates it to zero length
if ($fh = fopen($ftp_path, 'w', 0, $stream_context))
{
    // Writes contents to the file
    fputs($fh, 'example contents');

    // Closes the file handle
    fclose($fh);
}
else
{
    die('Could not open file.');
}

$ftp_server = "ftp.example.com";
$ftp_user = "foo";
$ftp_pass = "bar";

// set up a connection or die
$conn_id = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server");

// try to login
if (@ftp_login($conn_id, $ftp_user, $ftp_pass)) {
    echo "Connected as $ftp_user@$ftp_server\n";
} else {
    echo "Couldn't connect as $ftp_user\n";
}

// close the connection
ftp_close($conn_id);
//ftp_pwd — Returns the current directory name

/**
 * Using ssh2 to login
 * phpseclib

Download it from here or here ( direct link ) ,
Include it to the project ,
And then :
*/

include('Net/SSH2.php');
$ssh = new Net_SSH2('www.example.com');
$ssh->login('username', 'password') or die("Login failed");
echo $ssh->exec('command');
 /*
 * Connect And execute script on remote
 */
/**
 * either ssh2_auth_password or
 * ssh2_auth_pubkey_file(
$conn,
'username',
'/home/username/.ssh/id_rsa.pub',
'/home/username/.ssh/id_rsa'
);
 * More functionality is available with the SFTP functions; you can change file or directory permissions, fetch information about a file, create directories, rename items, remove items, etc. They work quite similar to the SCP functions above, but an additional connect via ssh2_sftp() must be made prior to using the functions:

<?php
$sftp = ssh2_sftp($conn);

// Create a new folder
ssh2_sftp_mkdir($sftp, '/home/username/newdir');

// Rename the folder
ssh2_sftp_rename($sftp, '/home/username/newdir', '/home/username/newnamedir');

// Remove the new folder
ssh2_sftp_rmdir($sftp, '/home/username/newnamedir');

// Create a symbolic link
ssh2_sftp_symlink($sftp, '/home/username/myfile', '/var/www/myfile');

// Remove a file
ssh2_sftp_unlink($sftp, '/home/username/myfile');
ssh2_sftp() accepts the connection resource and returns an SFTP resource which is used in future ssh2_sftp_* calls. The calls then return a Boolean which allows you to determine whether the action was successful.

Using Wrapper Functions
When a specific file management function doesn’t exist for SFTP or SCP, generally the core file system function will work using a stream wrapper. Below are a few examples:

<?php
// Create a new folder
mkdir('ssh2.sftp://' . $sftp . '/home/username/newdir');

// Remove the new folder
rmdir('ssh2.sftp://' . $sftp . '/home/username/newdir');

// Retrieve a list of files
$files = scandir('ssh2.sftp://' . $sftp . '/home/username');
 * The only differnece visible between ftp and ssh in php is ssh can use public key to auth.
 * We can also use ftp_delete or ftp_exec, ftp_mkdir, ftp_delete, ftp_rmdit, ft_chdir, ftp_rename
 */
 $connection = ssh2_connect('shell.example.com', 22);
ssh2_auth_password($connection, 'username', 'password');

$stream = ssh2_exec($connection, '/usr/local/bin/php -i');
 /*
 * Copy one file to remote
 */
 $connection = ssh2_connect('shell.example.com', 22);
ssh2_auth_password($connection, 'username', 'password');

ssh2_scp_send($connection, '/local/filename', '/remote/filename', 0644);
 /*
 * Copy file from remote
 */
 $connection = ssh2_connect('shell.example.com', 22);
ssh2_auth_password($connection, 'username', 'password');

ssh2_scp_recv($connection, '/remote/filename', '/local/filename');

/*
 * PHP ZIP
 */
$zip = new ZipArchive;
if ($zip->open('test.zip') === TRUE) {
    $zip->addFile('/path/to/index.txt', 'newname.txt');
    $zip->close();
    echo 'ok';
} else {
    echo 'failed';
}

// passthru used to execute shell command which return binary information such as a file a zip file or image file and dump it directly to browser
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"myfile.zip\"");
header("Content-Length: 11111");
passthru("cat myfile.zip",$err);