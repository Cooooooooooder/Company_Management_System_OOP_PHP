<?php

declare(strict_types=1);

namespace App\Models;

class EmployeeModel extends Model
{
    public function all(): array
    {
        $sql = "
            SELECT
                employees.*,
                departments.name AS department_name
            FROM employees
            LEFT JOIN departments
                ON employees.department_id = departments.id
            ORDER BY employees.id DESC
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
            employees.*,
            departments.name AS department_name
        FROM employees
        LEFT JOIN departments
            ON departments.id = employees.department_id
        WHERE employees.id = ? ";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return null;
        }

        $statement->bind_param("i", $id);

        $statement->execute();

        $result = $statement->get_result();

        $employee = $result->fetch_assoc();

        $statement->close();

        return $employee ?: null;
    }



    public function create(array $data): bool
    {
        $sql = "
        INSERT INTO employees (
            department_id,
            name,
            email,
            phone,
            position,
            salary,
            hire_date,
            image
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return false;
        }

        $statement->bind_param(
            "isssssss",
            $data['department_id'],
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['position'],
            $data['salary'],
            $data['hire_date'],
            $data['image']
        );

        $result = $statement->execute();

        $statement->close();

        return $result;
    }

    public function update(array $data): bool
    {
        $sql = "
        UPDATE employees
        SET
            department_id = ?,
            name = ?,
            email = ?,
            phone = ?,
            position = ?,
            salary = ?,
            hire_date = ?,
            image = ?
        WHERE id = ? ";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return false;
        }

        $statement->bind_param(
            "isssssssi",
            $data['department_id'],
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['position'],
            $data['salary'],
            $data['hire_date'],
            $data['image'],
            $data['id']
        );

        $result = $statement->execute();

        $statement->close();

        return $result;
    }

    public function delete(int $id): bool
    {
        $sql = "
        DELETE FROM employees
        WHERE id = ?
    ";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return false;
        }

        $statement->bind_param(
            "i",
            $id
        );

        $result = $statement->execute();

        $statement->close();

        return $result;
    }

    public function tasks(int $employeeId): array
    {
        $sql = "
        SELECT
            tasks.*,
            projects.name AS project_name
        FROM tasks
        LEFT JOIN projects
            ON projects.id = tasks.project_id
        WHERE tasks.employee_id = ?
        ORDER BY tasks.id DESC
    ";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return [];
        }

        $statement->bind_param('i', $employeeId);

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
            employees.*,
            departments.name AS department_name
        FROM employees

        LEFT JOIN departments
            ON departments.id = employees.department_id

        WHERE employees.name LIKE ?
           OR employees.email LIKE ?
           OR employees.phone LIKE ?
           OR departments.name LIKE ?

        ORDER BY employees.id DESC
    ";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            return [];
        }

        $searchTerm = '%' . $search . '%';

        $stmt->bind_param(
            'ssss',
            $searchTerm,
            $searchTerm,
            $searchTerm,
            $searchTerm
        );

        $stmt->execute();

        $result = $stmt->get_result();

        $employees = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return $employees;
    }

    
}
