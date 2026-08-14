<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\UserModel;

class ProjectController extends Controller
{
    private ProjectModel $projectModel;
    private UserModel $userModel;

    public function __construct()
    {
        $this->projectModel = new ProjectModel();
        $this->userModel = new UserModel();
    }

    public function index(): void
    {
        requireAuth();

        $search = trim($_GET['search'] ?? '');

        if ($search !== '') {

            $projects = $this->projectModel->search($search);
        } else {

            $projects = $this->projectModel->all();
        }

        $this->view('projects/index', [
            'projects' => $projects,
            'search' => $search
        ]);
    }

    public function show(): void
    {
        requireAuth();

        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {

            http_response_code(404);

            echo "Project not found.";

            return;
        }


        // Get project

        $project = $this->projectModel->find($id);

        if ($project === null) {

            http_response_code(404);

            echo "Project not found.";

            return;
        }


        // Get tasks belonging to this project

        $tasks = $this->projectModel->tasks($id);


        $this->view('projects/show', [

            'project' => $project,

            'tasks' => $tasks

        ]);
    }

    public function create(): void
    {
        requireAuth();

        $users = $this->userModel->all();

        $this->view('projects/create', [
            'users' => $users
        ]);
    }

    public function store(): void
    {
        requireAuth();

        $managerId = (int) ($_POST['manager_id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $status = trim($_POST['status'] ?? '');
        $startDate = trim($_POST['start_date'] ?? '');
        $endDate = trim($_POST['end_date'] ?? '');

        $errors = [];


        // Manager Validation

        if ($managerId <= 0) {

            $errors[] = 'Project manager is required.';
        } else {

            $manager = $this->userModel->find($managerId);

            if ($manager === null) {
                $errors[] = 'Selected project manager does not exist.';
            }
        }


        // Name Validation

        if ($name === '') {

            $errors[] = 'Project name is required.';
        } elseif (strlen($name) < 3) {

            $errors[] = 'Project name must be at least 3 characters.';
        } elseif (strlen($name) > 100) {

            $errors[] = 'Project name must not exceed 100 characters.';
        }


        // Status Validation

        $allowedStatuses = [
            'pending',
            'active',
            'completed',
            'cancelled'
        ];

        if (!in_array($status, $allowedStatuses, true)) {

            $errors[] = 'Invalid project status.';
        }


        // Start Date Validation

        if ($startDate === '') {

            $errors[] = 'Start date is required.';
        }


        // End Date Validation

        if ($endDate !== '' && $startDate !== '' && $endDate < $startDate) {

            $errors[] = 'End date cannot be before start date.';
        }


        // Validation Failed

        if (!empty($errors)) {

            $_SESSION['errors'] = $errors;

            $_SESSION['old'] = [
                'manager_id' => $managerId,
                'name' => $name,
                'description' => $description,
                'status' => $status,
                'start_date' => $startDate,
                'end_date' => $endDate
            ];

            $this->redirect('projects/create');
        }


        // Data

        $data = [
            'manager_id' => $managerId,
            'name' => $name,
            'description' => $description,
            'status' => $status,
            'start_date' => $startDate,
            'end_date' => $endDate
        ];


        // Create Project

        $success = $this->projectModel->create($data);


        // Database Error

        if (!$success) {

            $_SESSION['errors'] = [
                'Failed to create project.'
            ];

            $_SESSION['old'] = $data;

            $this->redirect('projects/create');
        }


        // Success

        success('Project created successfully.');

        $this->redirect('projects');
    }

    public function edit(): void
    {
        requireAuth();

        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {

            http_response_code(404);

            echo "Project not found.";

            return;
        }

        $project = $this->projectModel->find($id);

        if ($project === null) {

            http_response_code(404);

            echo "Project not found.";

            return;
        }

        $users = $this->userModel->all();

        $this->view('projects/edit', [
            'project' => $project,
            'users' => $users
        ]);
    }

    public function update(): void
    {
        requireAuth();

        $id = (int) ($_POST['id'] ?? 0);

        $managerId = (int) ($_POST['manager_id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $status = trim($_POST['status'] ?? '');
        $startDate = trim($_POST['start_date'] ?? '');
        $endDate = trim($_POST['end_date'] ?? '');

        $errors = [];


        // ID Validation

        if ($id <= 0) {

            $errors[] = 'Invalid project ID.';
        }


        // Check Project Exists

        if ($id > 0) {

            $project = $this->projectModel->find($id);

            if ($project === null) {

                $errors[] = 'Project not found.';
            }
        }


        // Manager Validation

        if ($managerId <= 0) {

            $errors[] = 'Project manager is required.';
        } else {

            $manager = $this->userModel->find($managerId);

            if ($manager === null) {

                $errors[] = 'Selected project manager does not exist.';
            }
        }


        // Name Validation

        if ($name === '') {

            $errors[] = 'Project name is required.';
        } elseif (strlen($name) < 3) {

            $errors[] = 'Project name must be at least 3 characters.';
        } elseif (strlen($name) > 100) {

            $errors[] = 'Project name must not exceed 100 characters.';
        }


        // Status Validation

        $allowedStatuses = [
            'pending',
            'active',
            'completed',
            'cancelled'
        ];

        if (!in_array($status, $allowedStatuses, true)) {

            $errors[] = 'Invalid project status.';
        }


        // Start Date Validation

        if ($startDate === '') {

            $errors[] = 'Start date is required.';
        }


        // End Date Validation

        if (
            $endDate !== ''
            && $startDate !== ''
            && $endDate < $startDate
        ) {

            $errors[] = 'End date cannot be before start date.';
        }


        // Validation Failed

        if (!empty($errors)) {

            $_SESSION['errors'] = $errors;

            $_SESSION['old'] = [
                'manager_id' => $managerId,
                'name' => $name,
                'description' => $description,
                'status' => $status,
                'start_date' => $startDate,
                'end_date' => $endDate
            ];

            $this->redirect('projects/edit?id=' . $id);
        }


        // Data

        $data = [
            'id' => $id,
            'manager_id' => $managerId,
            'name' => $name,
            'description' => $description,
            'status' => $status,
            'start_date' => $startDate,
            'end_date' => $endDate
        ];


        // Update Project

        $success = $this->projectModel->update($data);


        // Database Error

        if (!$success) {

            $_SESSION['errors'] = [
                'Failed to update project.'
            ];

            $_SESSION['old'] = [
                'manager_id' => $managerId,
                'name' => $name,
                'description' => $description,
                'status' => $status,
                'start_date' => $startDate,
                'end_date' => $endDate
            ];

            $this->redirect('projects/edit?id=' . $id);
        }


        // Success

        success('Project updated successfully.');

        $this->redirect('projects');
    }

    public function delete(): void
    {
        requireAuth();

        $id = (int) ($_POST['id'] ?? 0);

        // Validate ID

        if ($id <= 0) {

            error('Invalid project ID.');

            $this->redirect('projects');
        }


        // Check Project Exists

        $project = $this->projectModel->find($id);

        if ($project === null) {

            error('Project not found.');

            $this->redirect('projects');
        }


        // Delete Project

        $success = $this->projectModel->delete($id);


        // Database Error

        if (!$success) {

            error('Failed to delete project.');

            $this->redirect('projects');
        }


        // Success

        success('Project deleted successfully.');

        $this->redirect('projects');
    }
}
