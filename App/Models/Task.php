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
                tasks.id,
                tasks.user_name,
                tasks.user_email,
                tasks.task_description,
                task_statuses.title AS task_status_title
            FROM
                tasks
            LEFT JOIN
                task_statuses
            ON
                tasks.task_status_id = task_statuses.id
            ORDER BY
                :order
            LIMIT
                :page, :limit
            ",
            $params
        )->fetchAll();
    }
    
    public function getTasksCount() : int
    {
        return $this->execute("
            SELECT
                COUNT(*)
            FROM
                tasks
            ",
        )->fetchColumn();
    }
    
    public function getTaskById(int $id) : array
    {
        $params = [
            'id' => $id,
        ];
        
        return $this->execute("
            SELECT
                tasks.id,
                tasks.user_name,
                tasks.user_email,
                tasks.task_description,
                tasks.task_status_id,
                task_statuses.title AS task_status_title
            FROM
                tasks
            LEFT JOIN
                task_statuses
            ON
                tasks.task_status_id = task_statuses.id
            WHERE
                tasks.id = :id
            ",
            $params
        )->fetch();
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
                    task_status_id,
                    task_admin_edited
                )
            VALUES
                (
                    :user_name,
                    :user_email,
                    :task_description,
                    :task_status_id,
                    ''
                )
            ",
            $data
        )->errorCode();
    }
    
    public function editTask(array $data) : bool
    {
        return $this->execute("
            UPDATE
                tasks
            SET
                user_name = :user_name,
                user_email = :user_email,
                task_description = :task_description,
                task_status_id = :task_status_id
            WHERE
                id = :id
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