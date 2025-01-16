<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

// Connect to MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017");
echo "Connection to Database Successfully";

// Select the database
$db = $client->mydb;
echo "Database my db selected";

// Select the collection
$collection = $db->mycol;
echo "Collection selected successfully";

// Document to insert
$doc = [
    "title" => "MongoDB",
    "description" => "database",
    "like" => 100,
    "url" => "http://www.mongo.com",
    "by" => "NoSql"
];

// Insert document
$result = $collection->insertOne($doc);
echo "Document inserted successfully. Inserted ID: " . $result->getInsertedId();
?>
