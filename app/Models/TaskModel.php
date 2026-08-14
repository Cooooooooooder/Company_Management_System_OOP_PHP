<?php

declare(strict_types=1);

namespace App\Models;

class TaskModel extends Model
{
    public function all(): array
    {
        $sql = "
            SELECT
                tasks.id,
                tasks.project_id,
                tasks.employee_id,
                tasks.title,
                tasks.description,
                tasks.priority,
                tasks.status,
                tasks.due_date,
                tasks.created_at,

                projects.name AS project_name,

                employees.name AS employee_name

            FROM tasks

            LEFT JOIN projects
                ON projects.id = tasks.project_id

            LEFT JOIN employees
                ON employees.id = tasks.employee_id

            ORDER BY tasks.id DESC
        ";

        $result = $this->db->query($sql);

        if ($result === false) {
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function find(int $id): ?array
    {
        $sql = "
        SELECT
            tasks.id,
            tasks.project_id,
            tasks.employee_id,
            tasks.title,
            tasks.description,
            tasks.priority,
            tasks.status,
            tasks.due_date,
            tasks.created_at,

            projects.name AS project_name,

            employees.name AS employee_name

        FROM tasks

        LEFT JOIN projects
            ON projects.id = tasks.project_id

        LEFT JOIN employees
            ON employees.id = tasks.employee_id

        WHERE tasks.id = ?
    ";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return null;
        }

        $statement->bind_param('i', $id);

        $statement->execute();

        $result = $statement->get_result();

        $task = $result->fetch_assoc();

        $statement->close();

        return $task ?: null;
    }

    public function create(array $data): bool
    {
        $sql = "
        INSERT INTO tasks (
            project_id,
            employee_id,
            title,
            description,
            priority,
            status,
            due_date
        )
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return false;
        }

        $statement->bind_param(
            'iisssss',
            $data['project_id'],
            $data['employee_id'],
            $data['title'],
            $data['description'],
            $data['priority'],
            $data['status'],
            $data['due_date']
        );

        $success = $statement->execute();

        $statement->close();

        return $success;
    }

    public function update(array $data): bool
    {
        $sql = "
        UPDATE tasks
        SET
            project_id = ?,
            employee_id = ?,
            title = ?,
            description = ?,
            priority = ?,
            status = ?,
            due_date = ?
        WHERE id = ?
    ";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return false;
        }

        $statement->bind_param(
            'iisssssi',
            $data['project_id'],
            $data['employee_id'],
            $data['title'],
            $data['description'],
            $data['priority'],
            $data['status'],
            $data['due_date'],
            $data['id']
        );

        $success = $statement->execute();

        $statement->close();

        return $success;
    }


    public function delete(int $id): bool
    {
        $sql = "DELETE FROM tasks WHERE id = ?";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return false;
        }

        $statement->bind_param('i', $id);

        $success = $statement->execute();

        $statement->close();

        return $success;
    }

    public function search(string $search): array
    {
        $sql = "
        SELECT
            tasks.*,

            projects.name AS project_name,

            employees.name AS employee_name

        FROM tasks

        LEFT JOIN projects
            ON projects.id = tasks.project_id

        LEFT JOIN employees
            ON employees.id = tasks.employee_id

        WHERE tasks.title LIKE ?
           OR projects.name LIKE ?
           OR employees.name LIKE ?
           OR tasks.priority LIKE ?
           OR tasks.status LIKE ?

        ORDER BY tasks.id DESC
    ";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            return [];
        }

        $searchTerm = '%' . $search . '%';

        $stmt->bind_param(
            'sssss',
            $searchTerm,
            $searchTerm,
            $searchTerm,
            $searchTerm,
            $searchTerm
        );

        $stmt->execute();

        $result = $stmt->get_result();

        $tasks = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return $tasks;
    }

    
}
