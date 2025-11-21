<?php
namespace Controllers;

use Config\Database;
use Models\User;
use Throwable;

class UserController
{
    private User $userModel;

    public function __construct(?User $userModel = null)
    {
        if ($userModel !== null) {
            $this->userModel = $userModel;
            return;
        }

        $collection = Database::getInstance()
            ->getDatabase()
            ->selectCollection('users');

        $this->userModel = new User($collection);
    }

    public function create(array $payload): array
    {
        $requiredFields = ['first_name', 'last_name', 'email', 'password', 'role'];

        foreach ($requiredFields as $field) {
            if (empty($payload[$field])) {
                return [
                    'status' => 400,
                    'data' => [
                        'error' => "Field '{$field}' is required.",
                    ],
                ];
            }
        }

        if (!filter_var($payload['email'], FILTER_VALIDATE_EMAIL)) {
            return [
                'status' => 422,
                'data' => [
                    'error' => 'Invalid email address provided.',
                ],
            ];
        }

        if ($this->userModel->findByEmail($payload['email'])) {
            return [
                'status' => 409,
                'data' => [
                    'error' => 'Email address already registered.',
                ],
            ];
        }

        try {
            $result = $this->userModel->create($payload);
        } catch (Throwable $exception) {
            return [
                'status' => 500,
                'data' => [
                    'error' => 'Failed to create user record.',
                    'details' => $exception->getMessage(),
                ],
            ];
        }

        return [
            'status' => 201,
            'data' => [
                'message' => 'User created successfully.',
                'id' => (string) $result->getInsertedId(),
            ],
        ];
    }
}

?>