<?php
namespace Controllers;

class userController {
    private $userModel;

    public function __construct()
    {
        // dynamically instantiate the user model if available to avoid hard dependency
        $modelClass = 'Models\\User';
        if (class_exists($modelClass)) {
            $this->userModel = new $modelClass();
        } else {
            // handle missing model gracefully
            http_response_code(500);
            echo json_encode(['error' => 'User model class not found']);
            exit;
        }
    }

    // create user
    public function createUser() {
        // read json body
        $data = json_decode(file_get_contents('php://input'), true);

        // validate required fields
        $required = ["firstName", "lastName", "email", "password", "role"];
        
        foreach ($required as $reqField) {

            if (!isset($data[$reqField]) || empty($data[$reqField])) {
                http_response_code(400);
                echo json_encode(["error" => "$reqField is required"]);
                return;
            }
        }

        // insert to db
        $result = $this->userModel->createUser($data);

        echo json_encode([
            "message" => "User created successfully",
            "inserted_id" => (string)$result->getInsertedId()
        ]);
    }
}

?>