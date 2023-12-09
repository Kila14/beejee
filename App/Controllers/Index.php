<?php

namespace App\Controllers;

class Index
{
    public function get() : void
    {
        $taskModel = new \App\Models\Task();
        $tasks = $taskModel->getTasks(0, 3, 'ASC');
        
        if (! empty($task_add_edit_result_cookie = $_COOKIE['task_add_edit_result'] ?? ''))
            setcookie('task_add_edit_result', '', time() - 3600);
        
        echo template('templates/home.php', ['tasks' => $tasks, 'task_add_edit_result_cookie' => $task_add_edit_result_cookie]);
    }
}