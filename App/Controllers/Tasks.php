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
                $post_data['task_admin_edited'] = 0;
                
                if (($this->taskModel->addTask($post_data)) === true) {
                    setcookie('task_add_edit_result', 'Задача успешно добавлена', 0, buildLink());
                    header('Location: ' . buildLink());
                } else {
                    $errors[] = 'При добавлении задачи произошла ошибка';
                }
            }
        }
        
        $task_statuses = $this->taskModel->getTaskStatuses();
        
        echo template('templates/task_item.php', ['data' => ['h1' => 'Добавление задачи', 'submit_button_title' => 'Добавить', 'data' => $post_data ?? [], 'task_statuses' => $task_statuses, 'errors' => $errors ?? []]]);
    }
    
    public function editTask() : void
    {
        if (! \App\Models\User::isAdmin())
            \App\Controllers\Users::showForbidden();
        
        if (
            is_null($id = $_GET['id'] ?? null)
            || ((int) $id != $id)
            || empty($db_data = $this->taskModel->getTaskById((int) $id))
        )
            \App\Controllers\Users::showNotFound();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post_data = $this->filterPostData($_POST);
            
            if (empty($errors = $this->validatePostData($post_data))) {
                $post_data['task_admin_edited'] = $post_data['task_description'] !== $db_data['task_description'] ? 1 : 0;
                
                if (($this->taskModel->editTask($post_data)) === true) {
                    setcookie('task_add_edit_result', 'Задача успешно обновлена', 0, buildLink());
                    header('Location: ' . buildLink());
                } else {
                    $errors[] = 'При редактировании задачи произошла ошибка';
                }
            }
        }
        
        $task_statuses = $this->taskModel->getTaskStatuses();
        
        echo template('templates/task_item.php', ['data' => ['h1' => 'Редактирование задачи', 'submit_button_title' => 'Обновить', 'data' => $post_data ?? $db_data, 'task_statuses' => $task_statuses, 'errors' => $errors ?? []]]);
    }
    
    protected function filterPostData(array $data = []) : array
    {
        if (! empty($data['user_name']))
            $data['user_name'] = htmlspecialchars($data['user_name'], ENT_QUOTES, 'UTF-8');
        
        if (! empty($data['task_description']))
            $data['task_description'] = htmlspecialchars($data['task_description'], ENT_QUOTES, 'UTF-8');
        
        if (! empty($data['task_status_id']))
            $data['task_status_id'] = (int) htmlspecialchars($data['task_status_id'], ENT_QUOTES, 'UTF-8');
        
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
        
        $task_status_id = $data['task_status_id'] ?? '';
        if (empty($task_status_id) && $task_status_id !== 0)
            $errors['task_status_id'] = 'Статус задачи не указан';
        elseif (! is_int($task_status_id))
            $errors['task_status_id'] = 'Статус задачи не валиден';
        
        return $errors;
    }
}