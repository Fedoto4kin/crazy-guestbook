<?php

namespace common\daemons;

use consik\yii2websocket\WebSocketServer;
use Ratchet\ConnectionInterface;

class EchoServer extends WebSocketServer
{

    protected function getCommand(ConnectionInterface $from, $msg)
    {
        $request = json_decode($msg, true);

        return !empty($request['action']) ? $request['action'] : parent::getCommand($from, $msg);
    }

    public function commandPush(ConnectionInterface $sender, $msg)
    {
        $request = json_decode($msg, true);

        //TODO: check secret key

        if (!empty($request['comment']) && $data = $request['comment']) {
            foreach ($this->clients as $client) {
                if ($client != $sender)
                    $client->send(json_encode($data));
            }
        }
    }

}