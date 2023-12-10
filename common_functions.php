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

if (! function_exists('getPagination')) {
    function getPagination(int $page, int $pages_count, int $max_neighbors_pages_count) : string
    {
        $pagination = '';
        $request_uri = $_SERVER['REQUEST_URI'];
        $url_path = parse_url($request_uri, PHP_URL_PATH);
        $url_query = parse_url($request_uri, PHP_URL_QUERY);
        parse_str($url_query ?? '', $get_params);
        $previous_pages_count = min($page - 1, $max_neighbors_pages_count);
        $next_pages_count = min($pages_count - $page, $max_neighbors_pages_count);
        
        if ($previous_pages_count > 0) {
            if ($page - $previous_pages_count > 1) {
                $get_params['page'] = 1;
                $pagination .= '<li class="page-item"><a class="page-link" href="' . $url_path . '?' . http_build_query($get_params) . '">&laquo;</a></li>';
            }
            
            for ($i = $page - $previous_pages_count; $i < $page; $i++) {
                $get_params['page'] = $i;
                $pagination .= '<li class="page-item"><a class="page-link" href="' . $url_path . '?' . http_build_query($get_params) . '">' . $i . '</a></li>';
            }
        }
        
        $pagination .= '    <li class="page-item active" aria-current="page"><span class="page-link">' . $page . '</span></li>';
        
        if ($next_pages_count > 0) {
            for ($i = $page + 1; $i <= $page + $next_pages_count; $i++) {
                $get_params['page'] = $i;
                $pagination .= '<li class="page-item"><a class="page-link" href="' . $url_path . '?' . http_build_query($get_params) . '">' . $i . '</a></li>';
            }
        }
        
        if ($page + $next_pages_count < $pages_count) {
            $get_params['page'] = $pages_count;
            $pagination .= '<li class="page-item"><a class="page-link" href="' . $url_path . '?' . http_build_query($get_params) . '">&raquo;</a></li>';
        }
        
        return $pagination;
    }
}