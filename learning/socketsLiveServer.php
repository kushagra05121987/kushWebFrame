<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 19/11/17
 * Time: 7:53 PM
 echo "Hello World" | nc sysblog.local 41234
 */
$host = "sysblog.local";
$port = "41234";
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); // Protocol : 0 [ or IPPROTO_IP This is IP protocol]

socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);

$socket_bindTcp = socket_bind($socket, $host, $port);

$socketListen = socket_listen($socket, 10); // returns socket resource

$clients = [];

// start socket server
echo "Starting server -----";

$count = 0;

// $handle = fopen("socket.logs","a+");
while(1) {
    if(0 == $count) {
        echo PHP_EOL;
        echo "Started .... ";
        echo PHP_EOL;
    }
    $readNew = $clients;
    $write = $readNew;
    $exception = $readNew;
    array_unshift($readNew, $socket);
    if($socketSelect = socket_select($readNew, $write, $exception, 0, 10)) {
        // accept new client and notify him
        if($clientConnected = acceptNotifyClients($clients, $socket, $readNew)) {
            // notify other users connected about him
            $clientResourceString = (string) $clientConnected;
            notifyOthers($clients, $clientResourceString, $write, $clientConnected);
        }

        //  check for read
        readClientsIfAvailable($clients, $readNew, $write);

        // check for exception
        raiseExceptionForClients($clients, $exception);
    }
    // reset everything
    $readNew = [];
    $write = [];
    $exception = [];
    ++$count;
}

// accept read and write clients
function acceptNotifyClients(&$clients, &$socket, &$readNew) {
    if(in_array($socket, $readNew)) {
        if($client = socket_accept($socket)) {
            array_push($clients, $client);
            socket_getpeername($client, $addressC, $portC);
            $readFromClient = socket_recv($client, $buff, 4096, MSG_DONTWAIT);
            if($readFromClient) {
                $message = "Message: unmask($buff) received. Welcome you are now connected with us.";
                if(!socket_send($client, unmask($message), strlen($message), 0)) {
                    echo PHP_EOL;
                    echo __LINE__;
                    echo PHP_EOL;
                    echo socket_strerror(socket_last_error($client));
                    echo PHP_EOL;
                }
            } else {
                $message = "Welcome you are now connected with us.";
                socket_send($client, $message, strlen($message), 0);
            }
            return $client;
        } else {
            echo PHP_EOL;
            echo __LINE__;
            echo PHP_EOL;
            echo socket_strerror(socket_last_error($client));
            echo PHP_EOL;
            return false;
        }
    }
}
// Check if client has read access
function readClientsIfAvailable(&$clients, &$readAbleClients, &$write) {
    foreach($clients as $clientR) {
        if(in_array($clientR, $readAbleClients)) {
            if(socket_recv($clientR, $messageReceived, 4096, 0)) {
                writeClientsIfAvailable($clients, $write, $messageReceived, $clientR);
            } else {
                echo PHP_EOL;
                echo __LINE__;
                echo PHP_EOL;
                echo $lastError = socket_last_error($clientR);
                echo PHP_EOL;
                echo socket_strerror(socket_last_error($clientR));
                echo PHP_EOL;
                // remove the client if not available and notify other users
                if(11 == $lastError) {
                    $index = array_search($clientR, $clients);
                    unset($clients[$index]);
                }
                $message = (string) $clientR." disconnected.";
                writeClientsIfAvailable($clients, $write, $message, $clientR);
            }
        }
    }
}
// Check if client has write access
function writeClientsIfAvailable(&$clients, &$writeAbleClients, &$message, &$focusClient = null) {
    foreach($clients as $clientW) {
        if($focusClient != null && $clientW != $focusClient) {
            if(in_array($clientW, $writeAbleClients)) {
                $message = mask($message);
                if(!socket_write($clientW, $message)) {
                    echo PHP_EOL;
                    echo __LINE__;
                    echo PHP_EOL;
                    echo socket_strerror(socket_last_error($clientW));
                    echo PHP_EOL;
                }
            }
        }
    }
}
// notify other connected clients about this issues
function notifyOthers(&$clients, &$clientConnected, &$write, &$focusClient) {
    $message = "Client $clientConnected is now connected.";
    writeClientsIfAvailable($clients, $write, $message, $focusClient);
}
// Check if client in not having exception
function raiseExceptionForClients($clients, $exceptionClients) {
    foreach($clients as $clientE) {
        if(in_array($clientE, $exceptionClients)) {
            $exceptionClient = (string) $clientE;
            echo "Client $exceptionClient is under exception";
        }
    }
}
// mask messages
function mask($text) {
    $b1 = 0x80 | (0x1 & 0x0f);
    $length = strlen($text);

    if($length <= 125)
        $header = pack('CC', $b1, $length);
    elseif($length > 125 && $length < 65536)
        $header = pack('CCn', $b1, 126, $length);
    elseif($length >= 65536)
        $header = pack('CCNN', $b1, 127, $length);
    return $header.$text;
}
// unmask messages
function unmask($text) {
    $length = ord($text[1]) & 127;
    if($length == 126) {
        $masks = substr($text, 4, 4);
        $data = substr($text, 8);
    }
    elseif($length == 127) {
        $masks = substr($text, 10, 4);
        $data = substr($text, 14);
    }
    else {
        $masks = substr($text, 2, 4);
        $data = substr($text, 6);
    }
    $text = "";
    for ($i = 0; $i < strlen($data); ++$i) {
        $text .= $data[$i] ^ $masks[$i%4];
    }
    return $text;
}

// perform handshaking
function perform_handshaking($receved_header,$client_conn, $host, $port) {
    $headers = array();
    $lines = preg_split("/\r\n/", $receved_header);
    foreach($lines as $line)
    {
        $line = chop($line);
        if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
        {
            $headers[$matches[1]] = $matches[2];
        }
    }

    $secKey = $headers['Sec-WebSocket-Key'];
    $secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
    //hand shaking header
    $upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
        "Upgrade: websocket\r\n" .
        "Connection: Upgrade\r\n" .
        "WebSocket-Origin: $host\r\n" .
        "WebSocket-Location: ws://$host:$port/demo/shout.php\r\n".
        "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
    socket_write($client_conn,$upgrade,strlen($upgrade));
}