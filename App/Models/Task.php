<?php

namespace App\Models;

class Task extends Model
{
    public function getTasks(int $page = 0, int $limit = 3, string $order = 'tasks.id ASC') : array
    {
        $params = [
            'page' => $page,
            'limit' => $limit,
            'order' => $order,
        ];
        
        return $this->execute("
            SELECT
                tasks.user_name,
                tasks.user_email,
                tasks.task_description,
                task_statuses.title AS task_status
            FROM
                tasks
            LEFT JOIN
                task_statuses
            ON
                tasks.task_status = task_statuses.id
            ORDER BY
                :order
            LIMIT
                :page, :limit
            ",
            $params
        )->fetchAll();
    }
    
    public function addTask(array $data) : bool
    {
        return $this->execute("
            INSERT INTO
                tasks
                (
                    user_name,
                    user_email,
                    task_description,
                    task_status,
                    task_admin_edited
                )
            VALUES
                (
                    :user_name,
                    :user_email,
                    :task_description,
                    :task_status,
                    ''
                )
            ",
            $data
        )->errorCode();
    }
    
    public function getTaskStatuses() : array
    {
        return $this->execute("
            SELECT
                *
            FROM
                task_statuses
            "
        )->fetchAll();
    }
}