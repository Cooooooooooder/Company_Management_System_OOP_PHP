<?php

namespace App\Models;

class RememberTokenModel extends Model
{
    public function create(
        int $userId,
        string $token,
        string $expiresAt
    ): bool {

        $sql = "
            INSERT INTO remember_tokens
                (user_id, token, expires_at)
            VALUES
                (?, ?, ?)
        ";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param(
            'iss',
            $userId,
            $token,
            $expiresAt
        );

        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }


    public function findValidToken(string $token): ?array
    {
        $sql = "
        SELECT
            remember_tokens.*,
            users.id AS user_id,
            users.name,
            users.email

        FROM remember_tokens

        INNER JOIN users
            ON users.id = remember_tokens.user_id

        WHERE remember_tokens.token = ?

        AND remember_tokens.expires_at > NOW()

        LIMIT 1
    ";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param(
            's',
            $token
        );

        $stmt->execute();

        $result = $stmt->get_result();

        $rememberToken = $result->fetch_assoc();

        $stmt->close();

        return $rememberToken ?: null;
    }


    public function delete(
        string $token
    ): bool {

        $sql = "
            DELETE FROM remember_tokens
            WHERE token = ?
        ";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param(
            's',
            $token
        );

        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }
}
