<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18/11/17
 * Time: 2:55 PM
 */
//ini_set('default_socket_timeout', 1);
$host = "sysblog.local";
$port = "41234";

// connect create a socket
/**
 * Domain -> The domain parameter specifies the protocol family to be used by the socket.
 * AF_INET	IPv4 Internet based protocols. TCP and UDP are common protocols of this protocol family.
 * AF_INET6	IPv6 Internet based protocols. TCP and UDP are common protocols of this protocol family.
 * AF_UNIX	Local communication protocol family. High efficiency and low overhead make it a great form of IPC (Interprocess Communication).
 * Type -> The type parameter selects the type of communication to be used by the socket.
 * SOCK_STREAM	Provides sequenced, reliable, full-duplex, connection-based byte streams. An out-of-band data transmission mechanism may be supported. The TCP protocol is based on this socket type.
 * SOCK_DGRAM	Supports datagrams (connectionless, unreliable messages of a fixed maximum length). The UDP protocol is based on this socket type.
 * SOCK_SEQPACKET	Provides a sequenced, reliable, two-way connection-based data transmission path for datagrams of fixed maximum length; a consumer is required to read an entire packet with each read call.
 * SOCK_RAW	Provides raw network protocol access. This special type of socket can be used to manually construct any type of protocol. A common use for this socket type is to perform ICMP requests (like ping).
 * SOCK_RDM	Provides a reliable datagram layer that does not guarantee ordering. This is most likely not implemented on your operating system.
 * Protocol -> The protocol parameter sets the specific protocol within the specified domain to be used when communicating on the returned socket. The proper value can be retrieved by name by using getprotobyname(). If the desired protocol is TCP, or UDP the corresponding constants SOL_TCP, and SOL_UDP can also be used.
 *
 * Socket errors
 * using two methods  socket_last_error(). This error code may be passed to socket_strerror(socket_last_error())
 *
 * Sockets are blocking by default. These can be turned to non-blocking by using socket_set_blocking() or socket_set_nonblock(). When in non-blocking mode methods which are supposed to wait until they receive data return right away without waiting.
 * socket_set_blocking is an alias of stream_set_blocking which can be used to set any stream in non blocking mode by passing true or false as argument.
 * All the methods such as socket_accept and socket_change which actually wait for things to happen work that way only in blocking mode and not in non blocking mode.
 */
echo "<pre>";
echo PHP_EOL;
echo "--- Dumping the exact value of socket protocol ---";
echo PHP_EOL;
var_dump(getprotobyname('tcp'));
echo PHP_EOL;
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); // Protocol : 0 [ or IPPROTO_IP This is IP protocol]
echo "---- Dumping Socket ----";
echo PHP_EOL;
echo "---- Dumping TCP Socket ----";
echo PHP_EOL;
var_dump($socket);
echo PHP_EOL;
echo "---- Dumping Error code ----";
echo PHP_EOL;
var_dump($lastErrorCode = socket_last_error($socket)); // this returns error code
echo PHP_EOL;
echo "---- Dumping Error message ----";
echo PHP_EOL;
var_dump(socket_strerror($lastErrorCode)); // the above error code can be used by this method to generate the sting of error

// connecting to a server using the created socket
$connect = socket_connect($socket, gethostbyname("www.google.com"), 80); // this logic can be used to create a port scanner
echo PHP_EOL;
echo " ------ Dumping Socket connect status ------ ";
echo PHP_EOL;
var_dump($connect);

// Sending data
echo PHP_EOL;
echo "---- with socket_send -----";
echo PHP_EOL;
$message = "GET / HTTP/1.1\r\n\r\n";
$socket_send = socket_send($socket, $message, strlen($message), 0); // returns the number of bytes sent. When sending data to a socket you are basically writing data to that socket. This is similar to writing data to a file. Hence you can also use the write function to send data to a socket.
$socket_sendmsg = socket_sendmsg($socket, [$message], 0);
$socket_sendto = socket_sendto($socket, $message, strlen($message), 0, 'sysblog.local', 9000);// sends message from one socket to another even if its not connected. returns the number of bytes send.
$socket_write = socket_write($socket, $message); //returns the number of bytes send.
/**
 * There is a little explanation of send() in section 9, but no real examples of using flags other than zero (the author mentions that there may be some differences in the implementation of the send() flags for different operating systems).

Bottom line: send() with flags equal to zero is pretty much the same as write(), which, I'm guessing, is what you suspected all along.
 */
echo PHP_EOL;
echo "--- Send message using socket_send ------ ";
echo PHP_EOL;
var_dump($socket_send);
echo PHP_EOL;
echo "--- Send message using socket_sendmsg ------ ";
echo PHP_EOL;
var_dump($socket_sendmsg);
echo PHP_EOL;
echo "--- Send message using socket_sendto ------ ";
echo PHP_EOL;
var_dump($socket_sendto);
echo PHP_EOL;
echo "--- Send message using socket_write ------ ";
echo PHP_EOL;
var_dump($socket_write);
/**
socket.send is a low-level method and basically just the C/syscall method send(3) / send(2). It can send less bytes than you requested, but returns the number of bytes sent.

socket.sendall is a high-level Python-only method that sends the entire buffer you pass or throws an exception. It does that by calling socket.send until everything has been sent or an error occurs.
 */

// Receiving Data
$socket_recv = socket_recv($socket, $buff, 4096, 0); // get the data in the variable passed and returns the length of data received
$socket_read = socket_read($socket, 4096, 0); // get the data read as the returned value
/**
 * socket_recv returns the number of bytes received socket_read returns the data that has been received

 * With socket_recv you can read bytes from the buffer AND know how many bytes have been received. With socket_read you can only read a specific amount of data from the buffer
 * socket_recv --->>>
 * Possible values for flags
Flag	Description
MSG_OOB	Process out-of-band data.
MSG_PEEK	Receive data from the beginning of the receive queue without removing it from the queue.
MSG_WAITALL	Block until at least len are received. However, if a signal is caught or the remote host disconnects, the function may return less data.
MSG_DONTWAIT	With this flag set, the function returns even if it would normally have blocked.
 *
 * socket_read --->>>
 * Parameters ¶

socket
A valid socket resource created with socket_create() or socket_accept().

length
The maximum number of bytes read is specified by the length parameter. Otherwise you can use \r, \n, or \0 to end reading (depending on the type parameter, see below).

type
Optional type parameter is a named constant:

PHP_BINARY_READ (Default) - use the system recv() function. Safe for reading binary data.
PHP_NORMAL_READ - reading stops at \n or \r.
 */

echo PHP_EOL;
echo "--- Receiving message using socket_recv ------ ";
echo PHP_EOL;
echo "--- printing number of bytes returned by recv  ------ ";
echo PHP_EOL;
var_dump($socket_recv);
echo PHP_EOL;
echo "--- printing actual message returned by recv  ------ ";
echo PHP_EOL;
var_dump($buff);
echo PHP_EOL;
echo "--- Receiving message using socket_read ------ ";
echo PHP_EOL;
var_dump($socket_read);

/**
 * socket_recv returns the number of bytes received socket_read returns the data that has been received

With socket_recv you can read bytes from the buffer AND know how many bytes have been recevied. With socket_read you can only read a specific amount of data from the buffer
 * socket_recv is better than socket_read
 */

/**
 * Following settings are applied when creating a socket server
 */

socket_close($socket);

$socketA = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); // Protocol : 0 [ or IPPROTO_IP This is IP protocol]

// in order to use this socket multiple times with the same port binding we need to use this so_reuseaddr. socket_setopt or socket_set_option both can be used.
//socket_setopt($socketA, SOL_SOCKET, SO_REUSEADDR, 1);
socket_set_option($socketA, SOL_SOCKET, SO_REUSEADDR, 1);
// Socket bind
// bind the socket to a given address and given port
// This has to be done before a connection is be established using socket_connect() or socket_listen().
echo PHP_EOL;
echo "--- Binding TCP Address --- ";
echo PHP_EOL;

$socket_bindTcp = socket_bind($socketA, $host, $port);

echo PHP_EOL;
echo "--- Dumping TCP Bind --- ";
echo PHP_EOL;
var_dump($socket_bindTcp);
echo PHP_EOL;
echo "---- Dumping Error code TCP----";
echo PHP_EOL;
var_dump($lastErrorCode = socket_last_error($socketA)); // this returns error code
echo PHP_EOL;
echo "---- Dumping Error message ----";
echo PHP_EOL;
var_dump(socket_strerror($lastErrorCode));

//  We bind a socket to a particular IP address and a certain port number. By doing this we ensure that all incoming data which is directed towards this port number is received by this application.

// Socket Listen --->>> Listens for a connection on a socket
//After binding a socket to a port the next thing we need to do is listen for connections. For this we need to put the socket in listening mode. Function socket_listen is used to put the socket in listening mode.
//socket_listen ($sock , 10)
//The second parameter of the function socket_listen is called backlog. It controls the number of incoming connections that are kept "waiting" if the program is already busy. So by specifying 10, it means that if 10 connections are already waiting to be processed, then the 11th connection request shall be rejected.
// socket_listen() is applicable only to sockets of type SOCK_STREAM or SOCK_SEQPACKET.

$socketListen = socket_listen($socketA, 10); // returns socket resource
echo PHP_EOL;
echo "---- Dumping Socket listen TCP ----";
echo PHP_EOL;
var_dump($socket);

// Accept Connections
/**
 *
After the socket socket has been created using socket_create(), bound to a name with socket_bind(), and told to listen for connections with socket_listen(), this function will accept incoming connections on that socket. Once a successful connection is made, a new socket resource is returned, which may be used for communication. If there are multiple connections queued on the socket, the first will be used. If there are no pending connections, socket_accept() will block until a connection becomes present. If socket has been made non-blocking using socket_set_blocking() or socket_set_nonblock(), FALSE will be returned.

The socket resource returned by socket_accept() may not be used to accept new connections. The original listening socket socket, however, remains open and may be reused.
 */
$socketAccept = socket_accept($socketA);
echo PHP_EOL;
echo "---- Dumping Socket listen TCP ----";
echo PHP_EOL;
var_dump($socketAccept);

echo PHP_EOL;
echo "---- Dumping Error code TCP----";
echo PHP_EOL;
var_dump($lastErrorCode = socket_last_error($socketAccept)); // this returns error code
echo PHP_EOL;
echo "---- Dumping Error message ----";
echo PHP_EOL;
var_dump(socket_strerror($lastErrorCode));

//display information about the client who is connected
/**
 * Note:
    socket_getpeername() should not be used with AF_UNIX sockets created with socket_accept(). Only sockets created with socket_connect() or a primary server socket following a call to socket_bind() will return meaningful values.
 *  If the given socket is of type AF_INET or AF_INET6, socket_getpeername() will return the peers (remote) IP address  in appropriate notation (e.g. 127.0.0.1 or fe80::1) in the address parameter and, if the optional port parameter is     present, also the associated port.

    If the given socket is of type AF_UNIX, socket_getpeername() will return the Unix filesystem path (e.g. /var/run/daemon.sock) in the address parameter.
 */
echo PHP_EOL;
echo "--- Dumping After Socket Accept TCP ----";
echo PHP_EOL;
if(socket_getpeername($socketAccept , $addressClient , $portCilent)) // $addressClient and $portCilent are the variables in which address and port information of client will be filled
{
    echo "Client $addressClient : $portCilent is now connected to us. \n";
}


// read from the client
$read = socket_read($socketAccept, 4096); // both are blocking socket_read and socket_recv. but both cannot work at the same time on same accept resource


//$readRecv = socket_recv($socketAccept, $buff, 4096, 0);
echo PHP_EOL;
echo "---- Dumping Data read from request ----";
echo PHP_EOL;
var_dump($read);
echo PHP_EOL;
//echo "---- Dumping Data read from request recv ----";
//echo PHP_EOL;
//var_dump($buff);

// write response to socket
$message = "message received";
socket_write($socketAccept, $message);
//socket_send($socketAccept, $message, 4096, 0);


// Socket select .
/**
 * To handle every connection we need a separate handling code to run along with the main server accepting connections. One way to achieve this is using threads. The main server program accepts a connection and creates a new thread to handle communication for the connection, and then the server goes back to accept more connections.
However php does not support threading directly.

Another method is to use the select function. The select function basically 'polls' or observers a set of sockets for certain events like if its readable, or writable or had a problem or not etc.
So the select function can be used to monitor multiple clients and check which client has send a message.
 */

echo PHP_EOL;
echo " ----- SOCKETS AVAILABLE RIGHT NOW ------ ";
echo PHP_EOL;
var_dump($socketA);
var_dump($socketAccept);
echo PHP_EOL;
while(1) {
    $readNew = [$socketA, $socketAccept];
    $write = $readNew;
    $exception = $readNew;
    $socketSelect = socket_select($readNew, $writes, $exceptions, 0, 10);
    echo PHP_EOL;
    echo " ----- Socket Select ----- ";
    echo PHP_EOL;
    var_dump($socketSelect);
    echo PHP_EOL;
    var_dump($readNew);
    echo PHP_EOL;
    var_dump($write);
    echo PHP_EOL;
    var_dump($exception);
    echo PHP_EOL;
    // write response to socket
    $message = "message received";
    socket_write($socketAccept, $message);
//    break;
//socket_send($socketAccept, $message, 4096, 0);
}

//socket_shutdown($socketA, 2);
//socket_shutdown($socketAccept, 2);
//socket_close($socketAccept);
//socket_close($socketA);
//unlink($socketAccept);
//unlink($socketA);

// socket_send and socket_write are not much different. Just the exception is that socket_send takes 4 parameters namely socket, message, length, flag which are all mandatory but socket_write takes only three parameters out of which only first two are mandatory the third parameter length is optional . So socket_send with flag 0 is similar to socket_write

/**
 * methods returning socket resource
 * socket_create
 * socket_listen
 * socket_accept
 *
 * Blocking Methods
 * socket_accept
 * socket_listen
 * socket_connect
 * socket_select
 * socket_read
 * socket_recv
 */