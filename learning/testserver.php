<?php

$host = "sysblog.local";
$port = "41234";
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); // Protocol : 0 [ or IPPROTO_IP This is IP protocol]

socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);

$socket_bindTcp = socket_bind($socket, $host, $port);

$socketListen = socket_listen($socket, 10); // returns socket resource

$clients = [];

// start socket server
echo "Starting server -----";

$count = 1;

$null = null;

while(1) {
	if($count) {
		echo "Started ....";
	}

	$changedSockets = $clients;
	array_unshift($changedSockets, $socket);

	socket_select($changedSockets, $null, $null, 0, 10);

	if(in_array($socket, $changedSockets)) {
		$clientNew = socket_accept($socket);
		array_push($clients, $clientNew);
		$header = socket_read($clientNew, 1024);
		perform_handshaking($header, $clientNew, $host, $port);
		socket_getpeername($clientNew, $ip);
		$response = mask(json_encode(array('type'=>'system', 'message'=>$ip.' connected'))); //prepare json data
        send_message($response);
        $found_socket = array_search($socket, $changedSockets);
        unset($changedSockets[$found_socket]);
	}

	foreach($changedSockets as $chanedSocket) {
		while(socket_recv($chanedSocket, $buf, 1024, 0) >=1 ) {
			$received_text = unmask($buf); //unmask data
            $tst_msg = json_decode($received_text);
            $tst_msg = mask(json_encode($tst_msg));
			send_message($tst_msg); //send data
            break 2; //exist this loop
		}
		$buf = @socket_read($chanedSocket, 1024, PHP_NORMAL_READ);
        if ($buf === false) { // check disconnected client
            // remove client for $clients array
            $found_socket = array_search($chanedSocket, $clients);
            socket_getpeername($chanedSocket, $ip);
            unset($clients[$found_socket]);

            //notify all users about disconnected connection
            $response = mask(json_encode(array('type'=>'system', 'message'=>$ip.' disconnected')));
            send_message($response);
        }
	}
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
function send_message($msg){
    global $clients;
    foreach($clients as $changed_socket)
    {
        @socket_write($changed_socket,$msg,strlen($msg));
    }
    return true;
}
//Unmask incoming framed message
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

//Encode message for transfer to client.
function mask($text){
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

?>