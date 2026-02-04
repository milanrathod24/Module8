<?php
$client = new SoapClient(null, [
    'location' => "http://localhost/Extra_m8/soap_server.php",
    'uri' => "http://localhost/Extra_m8/soap"
]);

print_r($client->getBooks());
