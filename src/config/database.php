<?php
require __DIR__ . '/../../src/vendor/autoload.php';

$mongoUrl = getenv('MONGO_URI');
$mongoDB = getenv('MONGO_DB');

try{
    // connect to mongodb
    $client = new MongoDB\Client($mongoUrl);
    $db = $client->selectDatabase($mongoDB);

}catch(Exception $e) {
    die('Connection not successful!' . $e->getMessage());
}

return $db;

?>