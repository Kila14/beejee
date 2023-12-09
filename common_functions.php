<?php

if (! function_exists('template')) {
    function template(string $template_path, array $variables = []) : string
    {
        $templates_root_path = ROOT_PATH . '/App/Views';
        $template_path = $templates_root_path . '/' . $template_path;
        
        if (! file_exists($template_path))
            return '';
        
        if (! empty($variables))
            extract($variables);
        
        ob_start();
        include $template_path;
        return ob_get_clean();
    }
}