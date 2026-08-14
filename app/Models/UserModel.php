<?php

declare(strict_types=1);

namespace App\Models;

use mysqli_result;

class UserModel extends Model
{
    public function all(): array
    {
        $sql = "SELECT * FROM users";

        $result = $this->db->query($sql);

        if ($result === false) {
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create(array $data): bool
    {
        $sql = "
        INSERT INTO users (
            name,
            email,
            phone,
            password
        )
        VALUES (?, ?, ?, ?)";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return false;
        }

        $hashedPassword = password_hash(
            $data['password'],
            PASSWORD_DEFAULT
        );

        $statement->bind_param(
            "ssss",
            $data['name'],
            $data['email'],
            $data['phone'],
            $hashedPassword
        );

        $result = $statement->execute();

        $statement->close();

        return $result;
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM users WHERE id = ?";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return null;
        }

        $statement->bind_param("i", $id);

        $statement->execute();

        $result = $statement->get_result();

        $user = $result->fetch_assoc();

        $statement->close();

        return $user ?: null;
    }

    public function update(array $data): bool
    {
        // Password is not being changed
        if (empty($data['password'])) {

            $sql = "
            UPDATE users
            SET name = ?, email = ?, phone = ?
            WHERE id = ?
        ";

            $statement = $this->db->prepare($sql);

            if ($statement === false) {
                return false;
            }

            $statement->bind_param(
                "sssi",
                $data['name'],
                $data['email'],
                $data['phone'],
                $data['id']
            );

            $result = $statement->execute();

            $statement->close();

            return $result;
        }

        // Password is being changed
        $sql = "
        UPDATE users
        SET name = ?, email = ?, phone = ?, password = ?
        WHERE id = ?";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return false;
        }

        $statement->bind_param(
            "ssssi",
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['password'],
            $data['id']
        );

        $result = $statement->execute();

        $statement->close();

        return $result;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM users WHERE id = ?";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return false;
        }

        $statement->bind_param("i", $id);

        $result = $statement->execute();

        $statement->close();

        return $result;
    }

    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return null;
        }

        $statement->bind_param("s", $email);

        $statement->execute();

        $result = $statement->get_result();

        $user = $result->fetch_assoc();

        $statement->close();

        return $user ?: null;
    }

    public function managedProjects(int $userId): array
    {
        $sql = "
        SELECT *
        FROM projects
        WHERE manager_id = ?
        ORDER BY id DESC
    ";

        $statement = $this->db->prepare($sql);

        if ($statement === false) {
            return [];
        }

        $statement->bind_param('i', $userId);

        $statement->execute();

        $result = $statement->get_result();

        $projects = $result->fetch_all(MYSQLI_ASSOC);

        $statement->close();

        return $projects;
    }

    public function search(string $search): array
    {
        $sql = "
        SELECT *
        FROM users
        WHERE name LIKE ?
           OR email LIKE ?
           OR phone LIKE ?
        ORDER BY id DESC
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

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
