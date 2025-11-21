<?php

require_once __DIR__ . '/../models/User.php';

class UserController {
    private $user;

    public function __construct($db)
    {
        $this->user = new User($db);
    }

    public function registerAdmin()
    {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents("php://input"), true);

        if (!$input || !isset($input['email']) || !isset($input['password']))
        {
            echo json_encode(["error" => "Invalid input"]);
            return;
        }

        // check if user already exists
        $existing = $this->user->findByEmail($input['email']);
        if($existing) 
        {
            echo json_encode(["error" => "Email already exists"]);
            return;
        }

        $newUser = $this->user->createUser([
            'first_name' => $input['first_name'],
            'last_name'  => $input['last_name'],
            'email'      => $input['email'],
            'password'   => $input['password'],
            'role'       => 'admin',
        ]);

        echo json_encode(["message" => "Admin created successfully"]);
    }
}

?>