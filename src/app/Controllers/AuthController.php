<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;

class AuthController extends Controller
{

    public function index(): void
    {
        $this->render('login.twig');
    }

    public function auth(): void
    {
        // if the request is not a POST request, redirect to the login page
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login');
            exit;
        }

        // validate the fields
        $fields = User::validate($_POST);

        // if fields is false, redirect to the login page
        if (!$fields) {
            header('Location: /login');
            exit;
        }

        // find the user
        $user = User::find($fields['email'], $fields['password']);

        // if user is found, set the session and redirect to the home page
        if ($user) {
            $_SESSION['user'] = [
                'email' > $user->getEmail(),
            ];
            header('Location: /admin');
            exit;
        } else {
            $_SESSION['message'] = 'Invalid credentials';
            // retain the email field value
            $_SESSION['fields'] = ['email' => $fields['email']];
            header('Location: /login');
            exit;
        }
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        header('Location: /login');
        exit;
    }
}
