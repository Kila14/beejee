<?php

namespace App\Controllers;

class Tasks
{
    private null | \App\Models\Task $taskModel = null;
    
    public function __construct()
    {
        $this->taskModel = new \App\Models\Task();
    }
    
    public function addTask() : void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post_data = $this->filterPostData($_POST);
            
            if (empty($errors = $this->validatePostData($post_data))) {
                if (($this->taskModel->addTask($post_data)) === true) {
                    setcookie('task_add_edit_result', 'Задача успешно добавлена');
                    header('Location: /');
                } else {
                    $errors[] = 'При добавлении задачи произошла ошибка';
                }
            }
        }
        
        $task_statuses = $this->taskModel->getTaskStatuses();
        
        echo template('templates/task_item.php', ['h1' => 'Добавление задачи', 'data' => $post_data ?? [], 'task_statuses' =>$task_statuses, 'errors' => $errors ?? []]);
    }
    
    protected function filterPostData(array $data = []) : array
    {
        if (! empty($data['user_name']))
            $data['user_name'] = htmlspecialchars($data['user_name'], ENT_QUOTES, 'UTF-8');
        
        if (! empty($data['task_description']))
            $data['task_description'] = htmlspecialchars($data['task_description'], ENT_QUOTES, 'UTF-8');
        
        if (! empty($data['task_status']))
            $data['task_status'] = (int) htmlspecialchars($data['task_status'], ENT_QUOTES, 'UTF-8');
        
        return $data;
    }
    
    protected function validatePostData(array $data = []) : array
    {
        $errors = [];
        
        $user_name = $data['user_name'] ?? '';
        if (empty($user_name))
            $errors['user_name'] = 'Имя пользователя не указано';
        
        $user_email = $data['user_email'] ?? '';
        if (empty($user_email))
            $errors['user_email'] = 'Email пользователя не указан';
        elseif (! filter_var($user_email, FILTER_VALIDATE_EMAIL))
            $errors['user_email'] = 'Email пользователя не валиден';
        
        $task_description = $data['task_description'] ?? '';
        if (empty($task_description) && $task_description != '0')
            $errors['task_description'] = 'Задача не заполнена';
        
        $task_status = $data['task_status'] ?? '';
        if (empty($task_status) && $task_status !== 0)
            $errors['task_status'] = 'Статус задачи не указан';
        elseif (! is_int($task_status))
            $errors['task_status'] = 'Статус задачи не валиден';
        
        return $errors;
    }
}