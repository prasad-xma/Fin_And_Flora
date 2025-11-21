<?php

namespace Models;

use Config\Database;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Collection;
use MongoDB\InsertOneResult;

class User
{
    private Collection $collection;

    public function __construct(?Collection $collection = null)
    {
        if ($collection !== null) {
            $this->collection = $collection;
        } else {
            $this->collection = Database::getInstance()
                ->getDatabase()
                ->selectCollection('users');
        }

        $this->collection->createIndex(['email' => 1], ['unique' => true]);
    }

    public function create(array $data): InsertOneResult
    {
        return $this->collection->insertOne([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => strtolower($data['email']),
            'password'   => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'       => $data['role'],
            'created_at' => new UTCDateTime(),
            'updated_at' => new UTCDateTime(),
        ]);
    }

    public function findByEmail(string $email): ?array
    {
        $result = $this->collection->findOne(['email' => strtolower($email)]);

        return $result === null ? null : (array) $result;
    }
}
