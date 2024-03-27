<?php

namespace App\Models;

use App\DB\DBConnection;
use PDO;

class User extends Model
{

    private int $id;
    private $email;
    private $password;

    public function __construct(string $email = null, string $password = null)
    {
        parent::__construct();

        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail(): string|null
    {
        return $this->email;
    }

    public function getPassword(): string|null
    {
        return $this->password;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public static function find(string $email, string $password): User|bool
    {
        $db = (new DBConnection())->getConnection();

        $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, User::class);
        $stmt->bindValue(':email', $email);

        if ($stmt->execute()) {
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user->getPassword())) {
                return $user;
            }
        }

        return false;
    }

    public static function validate(array $data): array|bool
    {
        $errors = [
            'email' => '',
            'password' => '',
        ];
        $fields = $errors;

        $fields['email'] = trim($data['email']);
        $fields['password'] = trim($data['password']);

        if (empty($fields['email'])) {
            $errors['email'] = 'Email is required';
        } elseif ($fields['email'] < 255) {
            $errors['email'] = 'email must be 255 characters or less';
        }

        if (empty($fields['password'])) {
            $errors['password'] = 'password is required';
        } elseif ($fields['password'] < 50) {
            $errors['password'] = 'password must be 255 characters or less';
        }

        if (implode('', $errors) !== '') {
            $_SESSION['errors'] = $errors;
            $_SESSION['fields'] = $fields;
            return false;
        }

        return $fields;
    }
}
