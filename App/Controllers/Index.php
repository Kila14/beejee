<?php

namespace App\Controllers;

class Index
{
    public function get() : void
    {
        $taskModel = new \App\Models\Task();
        $tasks_count = $taskModel->getTasksCount();
        $page = $_GET['page'] ?? 1;
        $count = $_GET['count'] ?? 3;
        $offset = ($page * $count) - $count;
        $order_field = $_GET['order-field'] ?? '';
        $order_direction = $_GET['order-direction'] ?? '';
        $tasks = $taskModel->getTasks((int) $offset, (int) $count, $order_field, $order_direction);
        
        if (! empty($task_add_edit_result_cookie = $_COOKIE['task_add_edit_result'] ?? ''))
            setcookie('task_add_edit_result', '', time() - 3600);
        
        echo template('templates/home.php', ['tasks' => $tasks, 'task_add_edit_result_cookie' => $task_add_edit_result_cookie]);
    }
}