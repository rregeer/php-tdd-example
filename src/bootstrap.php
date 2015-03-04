<?php

require_once __DIR__ . '/../vendor/autoload.php';

$esClient = new Elasticsearch\Client();
$productRetriever = new ProductRetriever($esClient);


