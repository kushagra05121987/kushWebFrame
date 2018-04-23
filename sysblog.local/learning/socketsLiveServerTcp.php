<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 19/11/17
 * Time: 7:53 PM
echo "Hello World" | nc sysblog.local 41234
 */
//header_remove('Set-Cookie');
//header_remove('Cookie');
$host = "sysblog.local";
$port = "41234";
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); // Protocol : 0 [ or IPPROTO_IP This is IP protocol]
$socket2 = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); // Protocol : 0 [ or IPPROTO_IP This is IP protocol]

// SO_REUSEADDR actual working in php is different than in actual . In actual SO_REUSEADDR is supposed to be used only before binding second socket and SO_REUSEPORT is supposed to used with every socket but here SO_REUSEADDR is supposed to be used with every socket and it then starts working same as SO_REUSEPORT in which is allows different sockets with same host and name to be used. Also it has added advantage with TIME_WAIT.

//socket_set_option($socket2, SOL_SOCKET, SO_REUSEADDR, 1);
//$socket_bindTcp = socket_bind($socket2, '192.168.1.8', '41235');
//$socket_bindTcp = socket_bind($socket2, '192.168.1.8', $port);
//$socket_bindTcp = socket_bind($socket2, '127.0.0.1', $port); // already in use
//$socket_bindTcp = socket_bind($socket2, $host, $port); // already in use
$socket_bindTcp2 = socket_bind($socket2, '0.0.0.0', $port);
//$socket_bindTcp2 = socket_bind($socket2, '0.0.0.0', '41235');

//socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
//$socket_bindTcp = socket_bind($socket, $host, $port);
$socket_bindTcp = socket_bind($socket, '127.0.0.1', $port);

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
    // sweep and remove all clients that are not readable / connected
    // sweepAndRemoveClients($clients);

    $readNew = $clients;
    // $write = $readNew;
    // $exception = $readNew;
    array_unshift($readNew, $socket);
    if($socketSelect = socket_select($readNew, $write, $exception, 0, 10)) {
        // accept new client and notify him
        if(in_array($socket, $readNew)) {
            if($clientNew = socket_accept($socket)) {
                array_push($clients, $clientNew);
                socket_getpeername($clientNew, $addressC, $portC);
                $readFromClient = socket_recv($clientNew, $buff, 1024, 0);
            // $readFromClient = socket_recv($clientNew, $buff, 4096, MSG_DONTWAIT);
            // MSG_DONTWAIT good for chatting when no headers from client are expected but if headers from client such as to perform handshake are expected then 0 instead of MSG_DONTWAIT will work.
            // $readFromClient = socket_read($client, 1024);
                if(false !== $readFromClient) {
                    perform_handshaking($buff, $clientNew, $host, $port);
                    echo $message = (string) $clientNew." connected.";
                    $payload = mask(json_encode(array("message" => $message)));
                    foreach ($clients as $cl) {
                        if($cl != $clientNew) {
                            socket_write($cl, $payload, strlen($payload));
                        }
                    }
                } else if(false === $readFromClient) {
                    echo PHP_EOL;
                    echo " ------ No Read ------ ";
                    echo PHP_EOL;
                    echo __LINE__;
                    echo PHP_EOL;
                    echo socket_strerror(socket_last_error($clientNew));
                    echo PHP_EOL;
                }

            } else {
                echo PHP_EOL;
                echo " ------ No Accept ------ ";
                echo PHP_EOL;
                echo __LINE__;
                echo PHP_EOL;
                echo socket_strerror(socket_last_error($clientNew));
                echo PHP_EOL;
                return false;
            }
        }
        $clientResourceString = (string) $clientNew;
        // nostifyOthers($clients, $clientResourceString, $write, $clientConnected);

        //  check for read
        foreach($clients as $clientR) {
            if(in_array($clientR, $readNew)) {
                $socketReceived = socket_recv($clientR, $messageReceived, 1024, 0);
                if(false !== $socketReceived && strlen($messageReceived) >= 1) {
                    $messageReceived = unmask($messageReceived);
                    $messageReceived = mask(json_encode(["message" => $messageReceived]));
                    foreach ($clients as $cl) {
                        if($cl != $clientR) {
                            socket_write($cl, $messageReceived, strlen($messageReceived));
                        }
                    }
                } else if(false === $socketReceived) {
                    socket_close($clientR);
                    $index = array_search($clientR, $clients);
                    unset($clients[$index]);
                    echo $message = (string) $clientR." disconnected.";
                    $payload = mask(json_encode(array("message" => $message)));
                    foreach ($clients as $cl) {
                        socket_write($cl, $payload, strlen($payload));
                    }
                }
            }
        }
    }
    // reset everything
    $count = 1;
}
socket_close($socket);


// perform handshaking
function perform_handshaking($receved_header,$client_conn, $host, $port) {
    $headers = array();
    $lines = preg_split("/\r\n/", $receved_header);
    foreach($lines as $line)
    {
        $line = chop($line);
        if(preg_match('/\A(\S+): (.*)\z/', $line, $matches)){
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
    "WebSocket-Location: ws://$host:$port/learning/socketsLiveServerTCP.php\r\n".
    "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
    if(!socket_write($client_conn,$upgrade,strlen($upgrade))) {
        echo PHP_EOL;
        echo " ------ No Handshake message sent ------ ";
        echo PHP_EOL;
        echo __LINE__;
        echo PHP_EOL;
        echo socket_strerror(socket_last_error($client_conn));
        echo PHP_EOL;
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

// remove client from clients array
function removeClient(&$clients, $client) {
    // global $write, $readNew, $exception, $socket;
    try {
        socket_close($client);
        $index = array_search($client, $clients);
        unset($clients[$index]);
        // $readNew = $clients;
        // $write = $readNew;
        // $exception = $readNew;
        // array_unshift($readNew, $socket);
        return true;
    } catch(Throwable $t) {
        echo $t -> getMessage();
        return false;
    }
}