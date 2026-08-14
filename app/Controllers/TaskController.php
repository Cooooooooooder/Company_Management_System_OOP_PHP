<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\TaskModel;
use App\Models\ProjectModel;
use App\Models\EmployeeModel;


class TaskController extends Controller
{
    private TaskModel $taskModel;
    private ProjectModel $projectModel;
    private EmployeeModel $employeeModel;

    public function __construct()
    {
        $this->taskModel = new TaskModel();
        $this->projectModel = new ProjectModel();
        $this->employeeModel = new EmployeeModel();
    }

    public function index(): void
    {
        requireAuth();

        $search = trim($_GET['search'] ?? '');

        if ($search !== '') {

            $tasks = $this->taskModel->search($search);
        } else {

            $tasks = $this->taskModel->all();
        }

        $this->view('tasks/index', [
            'tasks' => $tasks,
            'search' => $search
        ]);
    }

    public function show(): void
    {
        requireAuth();

        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {

            http_response_code(404);

            echo "Task not found.";

            return;
        }


        $task = $this->taskModel->find($id);


        if ($task === null) {

            http_response_code(404);

            echo "Task not found.";

            return;
        }


        $this->view('tasks/show', [
            'task' => $task
        ]);
    }

    public function create(): void
    {
        requireAuth();

        $projects = $this->projectModel->all();

        $employees = $this->employeeModel->all();

        $this->view('tasks/create', [
            'projects' => $projects,
            'employees' => $employees
        ]);
    }

    public function store(): void
    {
        requireAuth();

        $projectId = (int) ($_POST['project_id'] ?? 0);

        $employeeId = (int) ($_POST['employee_id'] ?? 0);

        $title = trim($_POST['title'] ?? '');

        $description = trim($_POST['description'] ?? '');

        $priority = trim($_POST['priority'] ?? '');

        $status = trim($_POST['status'] ?? '');

        $dueDate = trim($_POST['due_date'] ?? '');


        $errors = [];


        /*
    |--------------------------------------------------------------------------
    | Project Validation
    |--------------------------------------------------------------------------
    */

        if ($projectId <= 0) {

            $errors[] = 'Please select a project.';
        } elseif ($this->projectModel->find($projectId) === null) {

            $errors[] = 'Selected project does not exist.';
        }


        /*
    |--------------------------------------------------------------------------
    | Employee Validation
    |--------------------------------------------------------------------------
    */

        if ($employeeId <= 0) {

            $errors[] = 'Please select an employee.';
        } elseif ($this->employeeModel->find($employeeId) === null) {

            $errors[] = 'Selected employee does not exist.';
        }


        /*
    |--------------------------------------------------------------------------
    | Title Validation
    |--------------------------------------------------------------------------
    */

        if ($title === '') {

            $errors[] = 'Task title is required.';
        } elseif (strlen($title) < 3) {

            $errors[] = 'Task title must be at least 3 characters.';
        } elseif (strlen($title) > 255) {

            $errors[] = 'Task title must not exceed 255 characters.';
        }


        /*
    |--------------------------------------------------------------------------
    | Description Validation
    |--------------------------------------------------------------------------
    */

        if (strlen($description) > 1000) {

            $errors[] = 'Description must not exceed 1000 characters.';
        }


        /*
    |--------------------------------------------------------------------------
    | Priority Validation
    |--------------------------------------------------------------------------
    */

        $allowedPriorities = [
            'Low',
            'Medium',
            'High'
        ];

        if (!in_array($priority, $allowedPriorities, true)) {

            $errors[] = 'Invalid priority.';
        }


        /*
    |--------------------------------------------------------------------------
    | Status Validation
    |--------------------------------------------------------------------------
    */

        $allowedStatuses = [
            'Pending',
            'In Progress',
            'Completed'
        ];

        if (!in_array($status, $allowedStatuses, true)) {

            $errors[] = 'Invalid status.';
        }


        /*
    |--------------------------------------------------------------------------
    | Due Date Validation
    |--------------------------------------------------------------------------
    */

        if ($dueDate !== '') {

            $date = \DateTime::createFromFormat(
                'Y-m-d',
                $dueDate
            );

            if (
                $date === false ||
                $date->format('Y-m-d') !== $dueDate
            ) {

                $errors[] = 'Invalid due date.';
            }
        }


        /*
    |--------------------------------------------------------------------------
    | Validation Failed
    |--------------------------------------------------------------------------
    */

        if (!empty($errors)) {

            $_SESSION['errors'] = $errors;

            $_SESSION['old'] = [
                'project_id' => $projectId,
                'employee_id' => $employeeId,
                'title' => $title,
                'description' => $description,
                'priority' => $priority,
                'status' => $status,
                'due_date' => $dueDate
            ];

            $this->redirect('tasks/create');
        }


        /*
    |--------------------------------------------------------------------------
    | Data
    |--------------------------------------------------------------------------
    */

        $data = [
            'project_id' => $projectId,
            'employee_id' => $employeeId,
            'title' => $title,
            'description' => $description,
            'priority' => $priority,
            'status' => $status,
            'due_date' => $dueDate
        ];


        /*
    |--------------------------------------------------------------------------
    | Create Task
    |--------------------------------------------------------------------------
    */

        $success = $this->taskModel->create($data);


        /*
    |--------------------------------------------------------------------------
    | Database Error
    |--------------------------------------------------------------------------
    */

        if (!$success) {

            $_SESSION['errors'] = [
                'Failed to create task.'
            ];

            $_SESSION['old'] = [
                'project_id' => $projectId,
                'employee_id' => $employeeId,
                'title' => $title,
                'description' => $description,
                'priority' => $priority,
                'status' => $status,
                'due_date' => $dueDate
            ];

            $this->redirect('tasks/create');
        }


        /*
    |--------------------------------------------------------------------------
    | Success
    |--------------------------------------------------------------------------
    */

        success('Task created successfully.');

        $this->redirect('tasks');
    }

    public function edit(): void
    {
        requireAuth();

        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {

            http_response_code(404);

            echo "Task not found.";

            return;
        }

        $task = $this->taskModel->find($id);

        if ($task === null) {

            http_response_code(404);

            echo "Task not found.";

            return;
        }

        $projects = $this->projectModel->all();

        $employees = $this->employeeModel->all();

        $this->view('tasks/edit', [
            'task' => $task,
            'projects' => $projects,
            'employees' => $employees
        ]);
    }
    public function update(): void
    {
        requireAuth();

        $id = (int) ($_POST['id'] ?? 0);

        $projectId = (int) ($_POST['project_id'] ?? 0);

        $employeeId = (int) ($_POST['employee_id'] ?? 0);

        $title = trim($_POST['title'] ?? '');

        $description = trim($_POST['description'] ?? '');

        $priority = trim($_POST['priority'] ?? '');

        $status = trim($_POST['status'] ?? '');

        $dueDate = trim($_POST['due_date'] ?? '');

        $errors = [];


        /*
    |--------------------------------------------------------------------------
    | Task ID
    |--------------------------------------------------------------------------
    */

        if ($id <= 0) {

            $errors[] = 'Invalid task ID.';
        } elseif ($this->taskModel->find($id) === null) {

            $errors[] = 'Task not found.';
        }


        /*
    |--------------------------------------------------------------------------
    | Project Validation
    |--------------------------------------------------------------------------
    */

        if ($projectId <= 0) {

            $errors[] = 'Please select a project.';
        } elseif ($this->projectModel->find($projectId) === null) {

            $errors[] = 'Selected project does not exist.';
        }


        /*
    |--------------------------------------------------------------------------
    | Employee Validation
    |--------------------------------------------------------------------------
    */

        if ($employeeId <= 0) {

            $errors[] = 'Please select an employee.';
        } elseif ($this->employeeModel->find($employeeId) === null) {

            $errors[] = 'Selected employee does not exist.';
        }


        /*
    |--------------------------------------------------------------------------
    | Title Validation
    |--------------------------------------------------------------------------
    */

        if ($title === '') {

            $errors[] = 'Task title is required.';
        } elseif (strlen($title) < 3) {

            $errors[] = 'Task title must be at least 3 characters.';
        } elseif (strlen($title) > 100) {

            $errors[] = 'Task title must not exceed 100 characters.';
        }


        /*
    |--------------------------------------------------------------------------
    | Description Validation
    |--------------------------------------------------------------------------
    */

        if (strlen($description) > 1000) {

            $errors[] = 'Description must not exceed 1000 characters.';
        }


        /*
    |--------------------------------------------------------------------------
    | Priority Validation
    |--------------------------------------------------------------------------
    */

        $allowedPriorities = [
            'Low',
            'Medium',
            'High'
        ];

        if (!in_array($priority, $allowedPriorities, true)) {

            $errors[] = 'Invalid priority.';
        }


        /*
    |--------------------------------------------------------------------------
    | Status Validation
    |--------------------------------------------------------------------------
    */

        $allowedStatuses = [
            'Pending',
            'In Progress',
            'Completed'
        ];

        if (!in_array($status, $allowedStatuses, true)) {

            $errors[] = 'Invalid status.';
        }


        /*
    |--------------------------------------------------------------------------
    | Due Date Validation
    |--------------------------------------------------------------------------
    */

        if ($dueDate === '') {

            $errors[] = 'Due date is required.';
        } else {

            $date = \DateTime::createFromFormat(
                'Y-m-d',
                $dueDate
            );

            if (
                $date === false ||
                $date->format('Y-m-d') !== $dueDate
            ) {

                $errors[] = 'Invalid due date.';
            }
        }


        /*
    |--------------------------------------------------------------------------
    | Validation Failed
    |--------------------------------------------------------------------------
    */

        if (!empty($errors)) {

            $_SESSION['errors'] = $errors;

            $_SESSION['old'] = [
                'project_id' => $projectId,
                'employee_id' => $employeeId,
                'title' => $title,
                'description' => $description,
                'priority' => $priority,
                'status' => $status,
                'due_date' => $dueDate
            ];

            $this->redirect('tasks/edit?id=' . $id);
        }


        /*
    |--------------------------------------------------------------------------
    | Data
    |--------------------------------------------------------------------------
    */

        $data = [
            'id' => $id,
            'project_id' => $projectId,
            'employee_id' => $employeeId,
            'title' => $title,
            'description' => $description,
            'priority' => $priority,
            'status' => $status,
            'due_date' => $dueDate
        ];


        /*
    |--------------------------------------------------------------------------
    | Update Task
    |--------------------------------------------------------------------------
    */

        $success = $this->taskModel->update($data);


        /*
    |--------------------------------------------------------------------------
    | Database Error
    |--------------------------------------------------------------------------
    */

        if (!$success) {

            $_SESSION['errors'] = [
                'Failed to update task.'
            ];

            $_SESSION['old'] = [
                'project_id' => $projectId,
                'employee_id' => $employeeId,
                'title' => $title,
                'description' => $description,
                'priority' => $priority,
                'status' => $status,
                'due_date' => $dueDate
            ];

            $this->redirect('tasks/edit?id=' . $id);
        }


        /*
    |--------------------------------------------------------------------------
    | Success
    |--------------------------------------------------------------------------
    */

        success('Task updated successfully.');

        $this->redirect('tasks');
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

            error('Invalid task ID.');

            $this->redirect('tasks');
        }


        /*
    |--------------------------------------------------------------------------
    | Check Task Exists
    |--------------------------------------------------------------------------
    */

        $task = $this->taskModel->find($id);

        if ($task === null) {

            error('Task not found.');

            $this->redirect('tasks');
        }


        /*
    |--------------------------------------------------------------------------
    | Delete Task
    |--------------------------------------------------------------------------
    */

        $success = $this->taskModel->delete($id);


        /*
    |--------------------------------------------------------------------------
    | Database Error
    |--------------------------------------------------------------------------
    */

        if (!$success) {

            error('Failed to delete task.');

            $this->redirect('tasks');
        }


        /*
    |--------------------------------------------------------------------------
    | Success
    |--------------------------------------------------------------------------
    */

        success('Task deleted successfully.');

        $this->redirect('tasks');
    }
}
