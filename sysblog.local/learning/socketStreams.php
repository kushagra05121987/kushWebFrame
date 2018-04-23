<?php

/**
Connecting to a Server
Connecting to a server is done with the function stream_socket_client. The only mandatory argument is the specification of the socket you want to connect to, and it returns a resource on success or false on error.

The socket specification is in the form of $protocol://$host:$port where protocol is one of the following:

tcp, for communicating via TCP, which is used by almost all common internet protocols like HTTP, FTP, SMTP where reliability is needed.
udp
or unix, which connects to a Unix Socket, a special kind of network socket, which is internal to the operating system’s network stack. Slightly more efficient, because no network interface is involved.
*/
$addr = gethostbyname("www.example.com");
//var_dump(getprotobyname("tcp"));exit;
$client = stream_socket_client("tcp://$addr:80", $errno, $errorMessage);

if ($client === false) {
    throw new UnexpectedValueException("Failed to connect: $errorMessage");
}

fwrite($client, "GET / HTTP/1.0\r\nHost: www.example.com\r\nAccept: */*\r\n\r\n");
echo stream_get_contents($client);
fclose($client);

/**
Servers
The Stream extension also provides a simple way to make socket servers with the stream_socket_server function.

The function stream_socket_server, again, takes a socket specification as first argument, in the same format as the string passed to stream_socket_client.

Running a server involves at least these things:

Bind on a Socket, tells the operating system that we’re interested in network packages arriving at the given network interface and port (= socket)
Check if an incoming connection is available
“Accept” the incoming connection (with stream_socket_accept).
Send something useful back to the client
Close the connection, or let the client close it
Go to (2)
When writing a server, you first have to do an “Accept” operation on the server socket. This is done with the stream_socket_accept function. This function blocks until a client connects to the server, or the timeout runs out.
*/

$server = stream_socket_server("tcp://127.0.0.1:1337", $errno, $errorMessage);

if ($server === false) {
    throw new UnexpectedValueException("Could not bind to socket: $errorMessage");
}

for (;;) {
    $client = @stream_socket_accept($server);

    if ($client) {
        stream_copy_to_stream($client, $client);
        fclose($client);
    }
}
socket_getpeername($socket,$name,$port);
echo "{$name}:{$port}\n"; // 127.0.0.1:1


// fsockopen()
//fsockopen — Open Internet or Unix domain socket connection
//fsockopen() returns a file pointer which may be used together with the other file functions (such as fgets(), fgetss(), fwrite(), fclose(), and feof()). If the call fails, it will return FALSE
$fp = fsockopen("www.example.com", 80, $errno, $errstr, 30);
if (!$fp) {
    echo "$errstr ($errno)<br />\n";
} else {
    $out = "GET / HTTP/1.1\r\n";
    $out .= "Host: www.example.com\r\n";
    $out .= "Connection: Close\r\n\r\n";
    fwrite($fp, $out);
    while (!feof($fp)) {
        echo fgets($fp, 128);
    }
    fclose($fp);
}