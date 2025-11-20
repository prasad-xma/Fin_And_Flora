<?php

class User {
    private $collection;

    public function __construct($db)
    {
        $this->collection = $db->selectCollection('users');
    }

    public function createUser($data) {
        
    }
}
?>