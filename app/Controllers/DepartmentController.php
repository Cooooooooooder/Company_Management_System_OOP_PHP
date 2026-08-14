<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\DepartmentModel;

class DepartmentController extends Controller
{
    private DepartmentModel $departmentModel;

    public function __construct()
    {
        $this->departmentModel = new DepartmentModel();
    }

    public function index(): void
    {
        requireAuth();

        $search = trim($_GET['search'] ?? '');

        if ($search !== '') {

            $departments = $this->departmentModel->search($search);
        } else {

            $departments = $this->departmentModel->all();
        }

        $this->view('departments/index', [
            'departments' => $departments,
            'search' => $search
        ]);
    }


    public function show(): void
    {
        requireAuth();

        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {

            http_response_code(404);

            echo "Department not found.";

            return;
        }


        // Get department
        $department = $this->departmentModel->find($id);

        if ($department === null) {

            http_response_code(404);

            echo "Department not found.";

            return;
        }


        // Get employees belonging to this department
        $employees = $this->departmentModel->employees($id);


        $this->view('departments/show', [

            'department' => $department,

            'employees' => $employees

        ]);
    }


    public function create(): void
    {
        requireAuth();
        $this->view('departments/create');
    }

    public function store(): void
    {
        requireAuth();
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        $errors = [];


        // Name Validation

        if ($name === '') {

            $errors[] = 'Department name is required.';
        } elseif (strlen($name) < 3) {

            $errors[] = 'Department name must be at least 3 characters.';
        } elseif (strlen($name) > 100) {

            $errors[] = 'Department name must not exceed 100 characters.';
        }


        // Validation failed

        if (!empty($errors)) {

            $_SESSION['errors'] = $errors;

            $_SESSION['old'] = [
                'name' => $name,
                'description' => $description
            ];

            $this->redirect('departments/create');
        }


        // Data

        $data = [
            'name' => $name,
            'description' => $description
        ];


        // Create department

        $success = $this->departmentModel->create($data);


        // Database error

        if (!$success) {

            $_SESSION['errors'] = [
                'Failed to create department.'
            ];

            $_SESSION['old'] = [
                'name' => $name,
                'description' => $description
            ];

            $this->redirect('departments/create');
        }


        // Success

        success('Department created successfully.');
        $this->redirect('departments');
    }

    public function edit(): void
    {
        requireAuth();
        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            http_response_code(404);

            echo "Department not found.";

            return;
        }

        $department = $this->departmentModel->find($id);

        if ($department === null) {
            http_response_code(404);

            echo "Department not found.";

            return;
        }

        $this->view('departments/edit', [
            'department' => $department
        ]);
    }

    public function update(): void
    {
        requireAuth();
        $id = (int) ($_POST['id'] ?? 0);

        $name = trim($_POST['name'] ?? '');

        $description = trim($_POST['description'] ?? '');

        $errors = [];


        if ($id <= 0) {

            $errors[] = 'Invalid department ID.';
        }



        if ($name === '') {

            $errors[] = 'Department name is required.';
        } elseif (strlen($name) < 3) {

            $errors[] = 'Department name must be at least 3 characters.';
        } elseif (strlen($name) > 100) {

            $errors[] = 'Department name must not exceed 100 characters.';
        }


        if (!empty($errors)) {

            $_SESSION['errors'] = $errors;

            $_SESSION['old'] = [
                'name' => $name,
                'description' => $description
            ];

            $this->redirect('departments/edit?id=' . $id);
        }



        $data = [
            'id' => $id,
            'name' => $name,
            'description' => $description
        ];



        $success = $this->departmentModel->update($data);



        if (!$success) {

            $_SESSION['errors'] = [
                'Failed to update department.'
            ];

            $_SESSION['old'] = [
                'name' => $name,
                'description' => $description
            ];

            $this->redirect('departments/edit?id=' . $id);
        }



        success('Department updated successfully.');

        $this->redirect('departments');
    }

    public function delete(): void
    {
        requireAuth();
        $id = (int) ($_POST['id'] ?? 0);

        if ($id <= 0) {

            error('Invalid department ID.');

            $this->redirect('departments');
        }

        $department = $this->departmentModel->find($id);

        if ($department === null) {

            error('Department not found.');

            $this->redirect('departments');
        }


        $success = $this->departmentModel->delete($id);

        if (!$success) {

            error('Failed to delete department.');

            $this->redirect('departments');
        }




        success('Department deleted successfully.');

        $this->redirect('departments');
    }
}
