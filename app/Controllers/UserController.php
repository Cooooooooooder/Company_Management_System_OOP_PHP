<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends Controller
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index(): void
    {
        requireAuth();

        $search = trim($_GET['search'] ?? '');

        if ($search !== '') {

            $users = $this->userModel->search($search);
        } else {

            $users = $this->userModel->all();
        }

        $this->view('users/index', [
            'users' => $users,
            'search' => $search
        ]);
    }

    public function create(): void
    {
        requireAuth();
        $this->view('users/create');
    }

    public function store(): void
    {
        requireAuth();
        $data = [

            'name' => trim($_POST['name'] ?? ''),

            'email' => trim($_POST['email'] ?? ''),

            'phone' => trim($_POST['phone'] ?? ''),

            'password' => $_POST['password'] ?? ''

        ];

        $errors = [];

        // Name Validation
        if ($data['name'] === '') {
            $errors[] = 'Name is required.';
        }

        // Email Validation
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email address.';
        }

        // Phone Validation
        if (!preg_match('/^[0-9]{11}$/', $data['phone'])) {
            $errors[] = 'Phone number must contain exactly 11 digits.';
        }

        // Password Validation
        if (strlen($data['password']) < 8) {
            $errors[] = 'Password must be at least 8 characters.';
        }

        if (!empty($errors)) {

            $_SESSION['errors'] = $errors;

            $_SESSION['old'] = $data;

            $this->redirect('/users/create');
        }

        $created = $this->userModel->create($data);

        if ($created) {

            $_SESSION['success'] = 'User created successfully.';
        } else {

            $_SESSION['error'] = 'Failed to create user.';
        }
        $this->redirect('users');
    }

    public function show(): void
    {
        requireAuth();
        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            http_response_code(404);

            echo "User not found.";

            return;
        }

        $user = $this->userModel->find($id);

        if ($user === null) {
            http_response_code(404);

            echo "User not found.";

            return;
        }

        $this->view('users/show', [
            'user' => $user
        ]);
    }
    public function edit(): void
    {
        requireAuth();

        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            http_response_code(404);
            echo "User not found.";
            return;
        }

        $user = $this->userModel->find($id);

        if ($user === null) {
            http_response_code(404);
            echo "User not found.";
            return;
        }

        $this->view('users/edit', [
            'user' => $user
        ]);
    }
    public function update(): void
    {
        requireAuth();
        $id = (int) ($_POST['id'] ?? 0);

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = [];

        // ID Validation
        if ($id <= 0) {
            $errors[] = 'Invalid user ID.';
        }

        // Name Validation
        if ($name === '') {
            $errors[] = 'Name is required.';
        } elseif (strlen($name) < 3) {
            $errors[] = 'Name must be at least 3 characters.';
        } elseif (strlen($name) > 100) {
            $errors[] = 'Name must not exceed 100 characters.';
        }

        // Email Validation
        if ($email === '') {
            $errors[] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        }

        // Phone Validation
        if ($phone === '') {
            $errors[] = 'Phone is required.';
        } elseif (!preg_match('/^[0-9]{11}$/', $phone)) {
            $errors[] = 'Phone must contain exactly 11 digits.';
        }

        // Password Validation
        if ($password !== '' && strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters.';
        }

        // Validation failed
        if (!empty($errors)) {

            $_SESSION['errors'] = $errors;

            $_SESSION['old'] = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone
            ];

            $this->redirect('users/edit?id=' . $id);
        }

        // Data for Model
        $data = [
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ];

        // Update password only if user entered a new one
        if ($password !== '') {

            $data['password'] = password_hash(
                $password,
                PASSWORD_DEFAULT
            );
        }

        // Send data to Model
        $success = $this->userModel->update($data);

        // Database update failed
        if (!$success) {

            $_SESSION['errors'] = [
                'Failed to update user.'
            ];

            $this->redirect('users/edit?id=' . $id);
        }

        // Success
        $_SESSION['success'] = 'User updated successfully.';

        $this->redirect('users');
    }


    public function delete(): void
    {
        requireAuth();

        $id = (int) ($_POST['id'] ?? 0);

        // Validate ID
        if ($id <= 0) {

            $_SESSION['errors'] = [
                'Invalid user ID.'
            ];

            $this->redirect('users');
        }

        // Delete user
        $success = $this->userModel->delete($id);

        // Delete failed
        if (!$success) {

            $_SESSION['errors'] = [
                'Failed to delete user.'
            ];

            $this->redirect('users');
        }

        // Success
        $_SESSION['success'] = 'User deleted successfully.';

        $this->redirect('users');
    }
}
