<?php

declare(strict_types=1);

namespace App\Models;

class ProjectModel extends Model
{
    public function all(): array
    {
        $sql = "
            SELECT
                projects.*,
                users.name AS manager_name
            FROM projects
            LEFT JOIN users
                ON projects.manager_id = users.id
            ORDER BY projects.id DESC
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
            projects.*,
            users.name AS manager_name
        FROM projects
        LEFT JOIN users
            ON projects.manager_id = users.id
        WHERE projects.id = ?
    ";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return null;
        }

        $statement->bind_param("i", $id);

        $statement->execute();

        $result = $statement->get_result();

        $project = $result->fetch_assoc();

        $statement->close();

        return $project ?: null;
    }

    public function create(array $data): bool
    {
        $sql = "
        INSERT INTO projects
        (
            manager_id,
            name,
            description,
            status,
            start_date,
            end_date
        )
        VALUES (?, ?, ?, ?, ?, ?)
    ";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return false;
        }

        $statement->bind_param(
            "isssss",
            $data['manager_id'],
            $data['name'],
            $data['description'],
            $data['status'],
            $data['start_date'],
            $data['end_date']
        );

        $success = $statement->execute();

        $statement->close();

        return $success;
    }

    public function update(array $data): bool
    {
        $sql = "
        UPDATE projects
        SET
            manager_id = ?,
            name = ?,
            description = ?,
            status = ?,
            start_date = ?,
            end_date = ?
        WHERE id = ?
    ";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return false;
        }

        $statement->bind_param(
            "isssssi",
            $data['manager_id'],
            $data['name'],
            $data['description'],
            $data['status'],
            $data['start_date'],
            $data['end_date'],
            $data['id']
        );

        $success = $statement->execute();

        $statement->close();

        return $success;
    }

    public function delete(int $id): bool
    {
        $sql = "
        DELETE FROM projects
        WHERE id = ?
    ";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return false;
        }

        $statement->bind_param("i", $id);

        $success = $statement->execute();

        $statement->close();

        return $success;
    }

    public function tasks(int $projectId): array
    {
        $sql = "
        SELECT
            tasks.*,
            employees.name AS employee_name
        FROM tasks
        LEFT JOIN employees
            ON employees.id = tasks.employee_id
        WHERE tasks.project_id = ?
        ORDER BY tasks.id DESC
    ";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return [];
        }

        $statement->bind_param('i', $projectId);

        $statement->execute();

        $result = $statement->get_result();

        $tasks = $result->fetch_all(MYSQLI_ASSOC);

        $statement->close();

        return $tasks;
    }

    public function search(string $search): array
    {
        $sql = "
        SELECT
            projects.*,
            users.name AS manager_name
        FROM projects

        LEFT JOIN users
            ON users.id = projects.manager_id

        WHERE projects.name LIKE ?
           OR users.name LIKE ?
           OR projects.status LIKE ?

        ORDER BY projects.id DESC
    ";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            return [];
        }

        $searchTerm = '%' . $search . '%';

        $stmt->bind_param(
            'sss',
            $searchTerm,
            $searchTerm,
            $searchTerm
        );

        $stmt->execute();

        $result = $stmt->get_result();

        $projects = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return $projects;
    }
}
