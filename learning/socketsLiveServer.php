<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 19/11/17
 * Time: 7:53 PM
 echo "Hello World" | nc 127.0.0.1 1337
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
                $message = "Message: $buff received. Welcome you are now connected with us.";
                if(!socket_send($client, $message, strlen($message), 0)) {
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
                echo socket_strerror(socket_last_error($clientR));
                echo PHP_EOL;
            }
        }
    }
}
// Check if client has write access
function writeClientsIfAvailable(&$clients, &$writeAbleClients, &$message, &$focusClient = null) {
    foreach($clients as $clientW) {
        if($focusClient != null && $clientW != $focusClient) {
            if(in_array($clientW, $writeAbleClients)) {
                if(!socket_write($clientW, $message)) {
                    echo PHP_EOL;
                    echo socket_strerror(socket_last_error($clientW));
                    echo PHP_EOL;
                }
            }
        } else {
            if(in_array($clientW, $writeAbleClients)) {
                if(!socket_write($clientW, $message)) {
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
            // fwrite($handle,"Socket ".(string) $clientE." is in exception state.\n");
        }
    }
}