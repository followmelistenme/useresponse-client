<?php

use UseresponseClient\Client;
use UseresponseClient\ClientConfig;
use UseresponseClient\Exceptions\HttpBadRequestException;
use UseresponseClient\Objects\Attachment;
use UseresponseClient\Objects\Ticket;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/Name.php';

$config = new ClientConfig('your_token', 'your.domain', '/your_path', 5, true, 'user-agent string');
$client = Client::initByConfig($config);
$attach = new Attachment('name.jpg', 'base64hash');

$ticket = (new Ticket('helpdesk', 'smth went wrong', 'notify@mail.ru', 'notify name', 'content'))
    ->addCustomField(new Name('test name'))
    ->addAttachment($attach);

try {
$result = $client->createObject($ticket);
} catch (HttpBadRequestException $e) {
    echo $e->getResponse();
    die;
}

echo json_encode($result->toArray());
die;
