<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RememberTokenModel;

class AuthController extends Controller
{
    private UserModel $userModel;

    private RememberTokenModel $rememberTokenModel;


    public function __construct()
    {
        $this->userModel = new UserModel();

        $this->rememberTokenModel = new RememberTokenModel();
    }


    /**
     * Show Login Page
     */
    public function login(): void
    {
        guestOnly();

        $this->view('auth/login');
    }


    /**
     * Authenticate User
     */
    public function authenticate(): void
    {
        $email = trim($_POST['email'] ?? '');

        $password = $_POST['password'] ?? '';

        $errors = [];


        /*
        |--------------------------------------------------------------------------
        | Email Validation
        |--------------------------------------------------------------------------
        */

        if ($email === '') {

            $errors[] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $errors[] = 'Please enter a valid email address.';
        }


        /*
        |--------------------------------------------------------------------------
        | Password Validation
        |--------------------------------------------------------------------------
        */

        if ($password === '') {

            $errors[] = 'Password is required.';
        }


        /*
        |--------------------------------------------------------------------------
        | Validation Failed
        |--------------------------------------------------------------------------
        */

        if (!empty($errors)) {

            $_SESSION['errors'] = $errors;

            $_SESSION['old'] = [
                'email' => $email
            ];

            $this->redirect('login');
        }


        /*
        |--------------------------------------------------------------------------
        | Find User
        |--------------------------------------------------------------------------
        */

        $user = $this->userModel->findByEmail($email);

        if ($user === null) {

            $_SESSION['errors'] = [
                'Invalid email or password.'
            ];

            $_SESSION['old'] = [
                'email' => $email
            ];

            $this->redirect('login');
        }


        /*
        |--------------------------------------------------------------------------
        | Verify Password
        |--------------------------------------------------------------------------
        */

        if (!password_verify($password, $user['password'])) {

            $_SESSION['errors'] = [
                'Invalid email or password.'
            ];

            $_SESSION['old'] = [
                'email' => $email
            ];

            $this->redirect('login');
        }


        /*
        |--------------------------------------------------------------------------
        | Login Successful
        |--------------------------------------------------------------------------
        */

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];

        $_SESSION['user_name'] = $user['name'];

        $_SESSION['user_email'] = $user['email'];


        /*
        |--------------------------------------------------------------------------
        | Remember Me
        |--------------------------------------------------------------------------
        */

        if (isset($_POST['remember'])) {

            /*
            |--------------------------------------------------------------------------
            | Generate Random Token
            |--------------------------------------------------------------------------
            */

            $token = bin2hex(
                random_bytes(32)
            );


            /*
            |--------------------------------------------------------------------------
            | Token Expiration
            |--------------------------------------------------------------------------
            |
            | 30 Days
            |
            */

            $expiresAt = date(
                'Y-m-d H:i:s',
                time() + (60 * 60 * 24 * 30)
            );


            /*
            |--------------------------------------------------------------------------
            | Save Token
            |--------------------------------------------------------------------------
            */

            $this->rememberTokenModel->create(
                (int) $user['id'],
                $token,
                $expiresAt
            );


            /*
            |--------------------------------------------------------------------------
            | Create Cookie
            |--------------------------------------------------------------------------
            */

            setcookie(
                'remember_token',
                $token,
                [
                    'expires' => time() + (60 * 60 * 24 * 30),

                    'path' => '/',

                    'httponly' => true,

                    'samesite' => 'Lax'
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Success Message
        |--------------------------------------------------------------------------
        */

        success('Login successful.');


        /*
        |--------------------------------------------------------------------------
        | Redirect To Dashboard
        |--------------------------------------------------------------------------
        */

        $this->redirect('dashboard');
    }


    /**
     * Logout User
     */
    public function logout(): void
    {


        if (isset($_COOKIE['remember_token'])) {

            $token = $_COOKIE['remember_token'];

            $this->rememberTokenModel->delete($token);


            setcookie(
                'remember_token',
                '',
                [
                    'expires' => time() - 3600,
                    'path' => '/',
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]
            );
        }

        $_SESSION = [];

        session_destroy();


        header(
            'Location: ' . url('login')
        );

        exit();
    }
}
