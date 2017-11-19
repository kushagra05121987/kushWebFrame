<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 19/11/17
 * Time: 7:53 PM
 */
$host = "sysblog.local";
$port = "41234";
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); // Protocol : 0 [ or IPPROTO_IP This is IP protocol]

socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);

$socket_bindTcp = socket_bind($socket, $host, $port);

$socketListen = socket_listen($socket, 10); // returns socket resource

$clients = [];
// $handle = fopen("socket.logs","a+");
function runServer($clients, $socket, $count) {
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
        if(in_array($socket, $readNew)) {
            if($client = socket_accept($socket)) {
                array_push($clients, $client);
                socket_getpeername($client, $addressC, $portC);
                $readFromClient = socket_recv($client, $buff, 4096, MSG_DONTWAIT);
                if($readFromClient) {
                    $message = "Message: $buff received. Welcome you are now connected with us.";
                    if(socket_send($client, $message, strlen($message), 0)) {
                        // fwrite($handle,"Client with address $addressC is connect with us on port $portC and message was sent\n");
                    } else {
                        // fwrite($handle,"Client with address $addressC is connect with us on port $portC and message was not sent\n");
                    }
                } else {
                    $message = "Welcome you are now connected with us.";
                    socket_send($client, $message, strlen($message), 0);
                    // fwrite($handle,"Client with address $addressC is connect with us on port $portC and message was not read\n");
                }
            } else {
                // fwrite($handle,"Unable to accept client\n");
            }
        }

        //  check for read
        foreach($clients as $clientR) {
            if(in_array($clientR, $readNew)) {
                // fwrite($handle,"Socket ".(string) $clientR." is ready for read.\n");
                if(socket_recv($clientR, $messageReceived, 4096, 0)) {
                    // fwrite($handle,"Message from client ".(string) $clientR.": $messageReceived\n");
                    $messageToSendToSocket = "We received $messageReceived";
                    if(socket_write($clientR, $messageToSendToSocket)) {
                        // fwrite($handle,"Sent response to ".(string) $clientR."\n");
                    } else {
                        // fwrite($handle,"Unable to Send response to ".(string) $clientR."\n");
                    }
                } else {
                    // fwrite($handle,"unable to read from ".(string) $clientR."\n");
                }
            }
        }
        // check for write
        foreach($clients as $clientW) {
            if(in_array($clientW, $write)) {
                // fwrite($handle,"Socket ".(string) $clientW." is ready for write.\n");
            }
        }
        // check for exception
        foreach($clients as $clientE) {
            if(in_array($clientE, $exception)) {
                // fwrite($handle,"Socket ".(string) $clientE." is in exception state.\n");
            }
        }
    }
    // reset everything
    $readNew = [];
    $write = [];
    $exception = [];
    ++$count;
    runServer($clients, $socket, $count);
}
// start socket server
echo "Starting server -----";
runServer($clients, $socket, 0);
