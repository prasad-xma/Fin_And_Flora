<?php

declare(strict_types=1);

namespace Config;

use MongoDB\Client;
use MongoDB\Database as MongoDatabase;
use RuntimeException;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Simple singleton wrapper around the MongoDB client so we only create
 * one connection per request lifecycle.
 */
class Database
{
    private static ?self $instance = null;

    private Client $client;

    private MongoDatabase $database;

    private function __construct()
    {
        $uri = getenv('MONGO_URI');
        $databaseName = getenv('MONGO_DB');

        if (!$uri) {
            throw new RuntimeException('Missing MongoDB connection string. Set MONGO_URI in your environment.');
        }

        if (!$databaseName) {
            throw new RuntimeException('Missing MongoDB database name. Set MONGO_DB in your environment.');
        }

        $this->client = new Client($uri, [], [
            'typeMap' => [
                'root' => 'array',
                'document' => 'array',
                'array' => 'array',
            ],
        ]);

        $this->database = $this->client->selectDatabase($databaseName);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getDatabase(): MongoDatabase
    {
        return $this->database;
    }
}
