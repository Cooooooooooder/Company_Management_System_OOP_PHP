<?php

declare(strict_types=1);

namespace App\Models;

class DashboardModel extends Model
{
    public function statistics(): array
    {
        return [
            'users' => $this->countTable('users'),

            'departments' => $this->countTable('departments'),

            'employees' => $this->countTable('employees'),

            'projects' => $this->countTable('projects'),

            'tasks' => $this->countTable('tasks'),

            'completed_tasks' => $this->countTasksByStatus('Completed'),

            'pending_tasks' => $this->countTasksByStatus('Pending'),
        ];
    }


    private function countTable(string $table): int
    {
        $sql = "SELECT COUNT(*) AS total FROM `$table`";

        $result = $this->db->query($sql);

        $row = $result->fetch_assoc();

        return (int) $row['total'];
    }


    private function countTasksByStatus(string $status): int
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM tasks
            WHERE status = ?
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->bind_param('s', $status);

        $stmt->execute();

        $result = $stmt->get_result();

        $row = $result->fetch_assoc();

        $stmt->close();

        return (int) $row['total'];
    }
}