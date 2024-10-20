<?php
require_once __DIR__ . '/../models/UsersModel.php';

class UsersController
{
    private $users;

    public function __construct()
    {
        $this->users = new UsersModel();
    }

    public function auth($email, $password)
    {
        $data = $this->users->getUserByEmailorUsername($email, $email);
        $response = [];

        if (!$data) {
            $response['status'] = 'failed';
            $response['message'] = 'email or username or password is incorrect';
            return $response;
        }

        if (!password_verify($password, $data['password'])) {
            $response['status'] = 'failed';
            $response['message'] = 'email or username or password is incorrect';
            return $response;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['username'] = $data['username'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['userId'] = $data['id'];
        $_SESSION['loggedin'] = true;

        $response['status'] = 'success';
        $response['message'] = 'user logged in successfully';
        return $response;
    }

    public function signUp($username, $email, $password)
    {
        $response = [];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['status'] = 'failed';
            $response['message'] = 'Invalid email format.';
            return $response;
        }

        if (strlen($password) < 8) {
            $response['status'] = 'failed';
            $response['message'] = 'Password must be at least 8 characters long.';
            return $response;
        }

        if ($this->users->getUserByEmailorUsername($email, $username)) {
            $response['status'] = 'failed';
            $response['message'] = 'email or username already exists';
            return $response;
        }

        if (!$this->users->insertUser($username, $email, $password)) {
            $response['status'] = 'error';
            $response['message'] = 'failed to sign up user';
            return $response;
        }

        $response['status'] = 'success';
        $response['message'] = 'user signed up successfully';

        return $response;
    }
}
