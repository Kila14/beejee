<?php

namespace App\Models;

class Task extends Model
{
    public function getTasks(int $offset = 0, int $count = 3, string $order_field = 'tasks.id', string $order_direction = 'asc') : array
    {
        $params = [
            'offset' => $offset,
            'count' => $count,
        ];
        
        $order_field = in_array($order_field, ['tasks.id', 'tasks.user_name', 'tasks.user_email', 'tasks.task_description', 'task_statuses.title']) ? $order_field : 'tasks.id';
        $order_direction = in_array($order_direction, ['asc', 'desc']) ? $order_direction : 'asc';
        
        return $this->execute("
            SELECT
                tasks.id,
                tasks.user_name,
                tasks.user_email,
                tasks.task_description,
                tasks.task_admin_edited,
                task_statuses.title AS task_status_title
            FROM
                tasks
            LEFT JOIN
                task_statuses
            ON
                tasks.task_status_id = task_statuses.id
            ORDER BY
                $order_field $order_direction
            LIMIT
                :offset, :count
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
    
    public function getTaskById(int $id) : array | bool
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
                    :task_admin_edited
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
                task_status_id = :task_status_id,
                task_admin_edited = :task_admin_edited
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