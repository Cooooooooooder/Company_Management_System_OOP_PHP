<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\DepartmentModel;

class EmployeeController extends Controller
{
    private EmployeeModel $employeeModel;
    private DepartmentModel $departmentModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
        $this->departmentModel = new DepartmentModel();
    }

    public function index(): void
    {
        requireAuth();

        $search = trim($_GET['search'] ?? '');

        if ($search !== '') {

            $employees = $this->employeeModel->search($search);
        } else {

            $employees = $this->employeeModel->all();
        }

        $this->view('employees/index', [
            'employees' => $employees,
            'search' => $search
        ]);
    }
    
    public function create(): void
    {
        requireAuth();
        $departments = $this->departmentModel->all();

        $this->view('employees/create', [
            'departments' => $departments
        ]);
    }

    public function show(): void
    {
        requireAuth();

        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {

            http_response_code(404);

            echo "Employee not found.";

            return;
        }


        // Get employee

        $employee = $this->employeeModel->find($id);

        if ($employee === null) {

            http_response_code(404);

            echo "Employee not found.";

            return;
        }


        // Get tasks assigned to this employee

        $tasks = $this->employeeModel->tasks($id);


        $this->view('employees/show', [

            'employee' => $employee,

            'tasks' => $tasks

        ]);
    }

    public function store(): void
    {
        requireAuth();
        $data = [
            'department_id' => $_POST['department_id'] ?? '',
            'name'          => trim($_POST['name'] ?? ''),
            'email'         => trim($_POST['email'] ?? ''),
            'phone'         => trim($_POST['phone'] ?? ''),
            'position'      => trim($_POST['position'] ?? ''),
            'salary'        => trim($_POST['salary'] ?? ''),
            'hire_date'     => $_POST['hire_date'] ?? '',
        ];


        $errors = [];


        /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

        if ((int) $data['department_id'] <= 0) {
            $errors[] = 'Please select a department.';
        }

        if ($data['name'] === '') {

            $errors[] = 'Name is required.';
        } elseif (strlen($data['name']) < 2) {

            $errors[] = 'Name must be at least 2 characters.';
        } elseif (strlen($data['name']) > 100) {

            $errors[] = 'Name must not exceed 100 characters.';
        }


        if ($data['email'] === '') {

            $errors[] = 'Email is required.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {

            $errors[] = 'Please enter a valid email address.';
        }


        if ($data['phone'] === '') {

            $errors[] = 'Phone is required.';
        } elseif (!preg_match('/^\d{11}$/', $data['phone'])) {

            $errors[] = 'Phone must contain exactly 11 digits.';
        }


        if ($data['position'] === '') {

            $errors[] = 'Position is required.';
        }


        if ($data['salary'] === '') {

            $errors[] = 'Salary is required.';
        } elseif (!is_numeric($data['salary']) || $data['salary'] < 0) {

            $errors[] = 'Salary must be a valid positive number.';
        }


        if ($data['hire_date'] === '') {

            $errors[] = 'Hire date is required.';
        }


        /*
    |--------------------------------------------------------------------------
    | Image Validation
    |--------------------------------------------------------------------------
    */

        $imageName = null;

        if (
            isset($_FILES['image']) &&
            $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE
        ) {

            if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {

                $errors[] = 'Failed to upload image.';
            } else {

                $allowedTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ];

                if (!in_array($_FILES['image']['type'], $allowedTypes, true)) {

                    $errors[] = 'Image must be JPG, PNG, or WEBP.';
                }
            }
        }


        /*
    |--------------------------------------------------------------------------
    | Validation Failed
    |--------------------------------------------------------------------------
    */

        if (!empty($errors)) {

            $_SESSION['errors'] = $errors;

            $_SESSION['old'] = $data;

            $this->redirect('employees/create');
        }


        /*
    |--------------------------------------------------------------------------
    | Upload Image
    |--------------------------------------------------------------------------
    */

        if (
            isset($_FILES['image']) &&
            $_FILES['image']['error'] === UPLOAD_ERR_OK
        ) {

            $extension = pathinfo(
                $_FILES['image']['name'],
                PATHINFO_EXTENSION
            );

            $imageName = uniqid('employee_', true) . '.' . $extension;

            $uploadPath = BASE_PATH . '/assets/images/' . $imageName;

            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                $uploadPath
            );
        }


        $data['image'] = $imageName;


        /*
    |--------------------------------------------------------------------------
    | Create Employee
    |--------------------------------------------------------------------------
    */

        if (!$this->employeeModel->create($data)) {

            $_SESSION['errors'] = [
                'Failed to create employee.'
            ];

            $_SESSION['old'] = $data;

            $this->redirect('employees/create');
        }


        $_SESSION['success'] = 'Employee created successfully.';

        $this->redirect('employees');
    }

    public function edit(): void
    {
        requireAuth();
        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {

            http_response_code(404);

            echo "Employee not found.";

            return;
        }

        $employee = $this->employeeModel->find($id);

        if ($employee === null) {

            http_response_code(404);

            echo "Employee not found.";

            return;
        }

        $departments = $this->departmentModel->all();

        $this->view('employees/edit', [
            'employee' => $employee,
            'departments' => $departments
        ]);
    }

    public function update(): void
    {

        requireAuth();

        $data = [
            'id'            => (int) ($_POST['id'] ?? 0),
            'department_id' => $_POST['department_id'] ?? '',
            'name'          => trim($_POST['name'] ?? ''),
            'email'         => trim($_POST['email'] ?? ''),
            'phone'         => trim($_POST['phone'] ?? ''),
            'position'      => trim($_POST['position'] ?? ''),
            'salary'        => trim($_POST['salary'] ?? ''),
            'hire_date'     => $_POST['hire_date'] ?? '',
        ];

        $errors = [];

        /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

        if ($data['id'] <= 0) {
            $errors[] = 'Invalid employee.';
        }

        if ((int) $data['department_id'] <= 0) {
            $errors[] = 'Please select a department.';
        }

        if ($data['name'] === '') {
            $errors[] = 'Name is required.';
        } elseif (strlen($data['name']) < 2) {
            $errors[] = 'Name must be at least 2 characters.';
        } elseif (strlen($data['name']) > 100) {
            $errors[] = 'Name must not exceed 100 characters.';
        }

        if ($data['email'] === '') {
            $errors[] = 'Email is required.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        }

        if ($data['phone'] === '') {
            $errors[] = 'Phone is required.';
        } elseif (!preg_match('/^\d{11}$/', $data['phone'])) {
            $errors[] = 'Phone must contain exactly 11 digits.';
        }

        if ($data['position'] === '') {
            $errors[] = 'Position is required.';
        }

        if ($data['salary'] === '') {
            $errors[] = 'Salary is required.';
        } elseif (!is_numeric($data['salary']) || $data['salary'] < 0) {
            $errors[] = 'Salary must be a valid positive number.';
        }

        if ($data['hire_date'] === '') {
            $errors[] = 'Hire date is required.';
        }

        /*
    |--------------------------------------------------------------------------
    | Get Current Employee
    |--------------------------------------------------------------------------
    */

        $employee = $this->employeeModel->find($data['id']);

        if ($employee === null) {
            http_response_code(404);

            echo "Employee not found.";

            return;
        }

        /*
    |--------------------------------------------------------------------------
    | Image Validation
    |--------------------------------------------------------------------------
    */

        $newImage = null;

        if (
            isset($_FILES['image']) &&
            $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE
        ) {

            if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {

                $errors[] = 'Failed to upload image.';
            } else {

                $allowedTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ];

                if (!in_array($_FILES['image']['type'], $allowedTypes, true)) {
                    $errors[] = 'Image must be JPG, PNG, or WEBP.';
                }
            }
        }

        /*
    |--------------------------------------------------------------------------
    | Validation Failed
    |--------------------------------------------------------------------------
    */

        if (!empty($errors)) {

            $_SESSION['errors'] = $errors;

            $_SESSION['old'] = $data;

            $this->redirect(
                'employees/edit?id=' . $data['id']
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Upload New Image
    |--------------------------------------------------------------------------
    */

        if (
            isset($_FILES['image']) &&
            $_FILES['image']['error'] === UPLOAD_ERR_OK
        ) {

            $extension = pathinfo(
                $_FILES['image']['name'],
                PATHINFO_EXTENSION
            );

            $newImage = uniqid('employee_', true) . '.' . $extension;

            $uploadPath = BASE_PATH
                . '/assets/images/'
                . $newImage;

            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                $uploadPath
            );

            $data['image'] = $newImage;
        } else {

            /*
         * No new image.
         * Keep the current image.
         */
            $data['image'] = $employee['image'];
        }

        /*
    |--------------------------------------------------------------------------
    | Update Employee
    |--------------------------------------------------------------------------
    */

        if (!$this->employeeModel->update($data)) {

            $_SESSION['errors'] = [
                'Failed to update employee.'
            ];

            $_SESSION['old'] = $data;

            $this->redirect(
                'employees/edit?id=' . $data['id']
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Delete Old Image
    |--------------------------------------------------------------------------
    */

        if (
            $newImage !== null &&
            !empty($employee['image'])
        ) {

            $oldImagePath = BASE_PATH
                . '/assets/images/'
                . $employee['image'];

            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        $_SESSION['success'] = 'Employee updated successfully.';

        $this->redirect('employees');
    }

    public function delete(): void
    {

        requireAuth();
        $id = (int) ($_POST['id'] ?? 0);

        /*
    |--------------------------------------------------------------------------
    | Validate ID
    |--------------------------------------------------------------------------
    */

        if ($id <= 0) {

            $_SESSION['errors'] = [
                'Invalid employee.'
            ];

            $this->redirect('employees');
        }


        /*
    |--------------------------------------------------------------------------
    | Find Employee
    |--------------------------------------------------------------------------
    */

        $employee = $this->employeeModel->find($id);

        if ($employee === null) {

            $_SESSION['errors'] = [
                'Employee not found.'
            ];

            $this->redirect('employees');
        }


        /*
    |--------------------------------------------------------------------------
    | Delete Employee From Database
    |--------------------------------------------------------------------------
    */

        if (!$this->employeeModel->delete($id)) {

            $_SESSION['errors'] = [
                'Failed to delete employee.'
            ];

            $this->redirect('employees');
        }


        /*
    |--------------------------------------------------------------------------
    | Delete Employee Image
    |--------------------------------------------------------------------------
    */

        if (!empty($employee['image'])) {

            $imagePath = BASE_PATH
                . '/assets/images/'
                . $employee['image'];

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }


        /*
    |--------------------------------------------------------------------------
    | Success
    |--------------------------------------------------------------------------
    */

        $_SESSION['success'] = 'Employee deleted successfully.';

        $this->redirect('employees');
    }
}
