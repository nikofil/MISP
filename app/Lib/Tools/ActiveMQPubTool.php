<?php

use Stomp\Client;
use Stomp\SimpleStomp;
use Stomp\Transport\Bytes;

class ActiveMQPubTool
{
    public function publish($body, $uri, $username, $password, $topic)
    {
        try {
            $client = new Client($uri);
            $client->setLogin($username, $password);
            $opts = array(
              'ssl'=>array(
                'verify_peer'=>false,
                'verify_peer_name'=>false,
                // 'cafile'=>'/var/www/MISP/broker_cert',
                // 'local_cer'=>'/var/www/MISP/client_cert',
              )
            );
            $client->getConnection()->setContext($opts);
            $stomp = new SimpleStomp($client);
            // send a message to the queue
            $bytesMessage = new Bytes($body);
            // $stomp->send('/queue/test', $bytesMessage);
            $stomp->send($topic, $bytesMessage);
            echo 'Sending message: ';
            print_r($body . "\n");
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}
