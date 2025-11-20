<?php

class User {
    private $collection;

    public function __construct($db)
    {
        $this->collection = $db->selectCollection('users');
    }

    public function createUser($data) 
    {
        return $this->collection->insertOne([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'password'   => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'       => $data['role'],
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function findByEmail($email) 
    {
        return $this->collection->findOne(['email' => $email]);
    }
}
?>