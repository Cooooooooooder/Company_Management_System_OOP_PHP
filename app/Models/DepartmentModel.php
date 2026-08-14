<?php

declare(strict_types=1);

namespace App\Models;

class DepartmentModel extends Model
{
    public function all(): array
    {
        $sql = "SELECT * FROM departments ORDER BY id DESC";

        $result = $this->db->query($sql);

        if ($result === false) {
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create(array $data): bool
    {
        $sql = "
        INSERT INTO departments (
            name,
            description
        )
        VALUES (?, ?)
    ";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return false;
        }

        $statement->bind_param(
            "ss",
            $data['name'],
            $data['description']
        );

        $result = $statement->execute();

        $statement->close();

        return $result;
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM departments WHERE id = ?";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return null;
        }

        $statement->bind_param("i", $id);

        $statement->execute();

        $result = $statement->get_result();

        $department = $result->fetch_assoc();

        $statement->close();

        return $department ?: null;
    }

    public function update(array $data): bool
    {
        $sql = "
        UPDATE departments
        SET name = ?, description = ?
        WHERE id = ?
    ";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return false;
        }

        $statement->bind_param(
            "ssi",
            $data['name'],
            $data['description'],
            $data['id']
        );

        $result = $statement->execute();

        $statement->close();

        return $result;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM departments WHERE id = ?";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return false;
        }

        $statement->bind_param("i", $id);

        $result = $statement->execute();

        $statement->close();

        return $result;
    }

    public function employees(int $departmentId): array
    {
        $sql = "
        SELECT *
        FROM employees
        WHERE department_id = ?
        ORDER BY id DESC
    ";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return [];
        }

        $statement->bind_param('i', $departmentId);

        $statement->execute();

        $result = $statement->get_result();

        $employees = $result->fetch_all(MYSQLI_ASSOC);

        $statement->close();

        return $employees;
    }


    public function search(string $search): array
    {
        $sql = "
        SELECT *
        FROM departments
        WHERE name LIKE ?
           OR description LIKE ?
        ORDER BY id DESC
    ";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            return [];
        }

        $searchTerm = '%' . $search . '%';

        $stmt->bind_param(
            'ss',
            $searchTerm,
            $searchTerm
        );

        $stmt->execute();

        $result = $stmt->get_result();

        $departments = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return $departments;
    }
}
