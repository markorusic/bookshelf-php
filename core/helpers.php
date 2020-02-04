<?php

use App\Core\Http\Response;
use App\Core\{App, Error, Auth};

/**
 * Require a view.
 *
 * @param  string $name
 * @param  array  $data
 */
function view($name, $data = [])
{
    extract($data);
    return require "app/views/{$name}.view.php";
}

function require_view($path)
{
    return require "app/views/{$path}.php";
}

function url($path)
{
    if (isset($_SERVER['HTTPS'])) {
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    } else {
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'] .  '/' . $path;
}

function asset($path)
{
    return url('public/' . $path);
}

/**
 * Redirect to a new page.
 *
 * @param  string $path
 */
function redirect($path)
{
    return header("Location: /{$path}");
}

function redirectBack()
{
    return header('Location: ' . $_SERVER['HTTP_REFERER']);
}

function errors()
{
    return Error::getInstance();
}

function auth()
{
    return Auth::getInstance();
}

/**
 * Shorter way of returing json response.
 *
 * @param  array $data
 * @param  int $status
 */
function json($data, $status = 200)
{
    return Response::json($data, $status);
}

/**
 * Aborts request with error status code.
 *
 * @param  int $status
 * @param  string $message
 */
function abort($status, $message = "Aborted!")
{
    return Response::abort($status, $message);
}

/**
 * Aborts request with error status code and coresponding view.
 *
 * @param  int $status
 */
function abort_view($status, $data = [])
{
    http_response_code($status);
    view('errors/' . $status, $data);
    exit();
}

function env($key, $defaultValue = null) {
    $string = file_get_contents(".env.json");
    $data = json_decode($string, true);
    if (isset($data[$key])) {
        return $data[$key];
    }
    return $defaultValue;
}

/**
 * Returns app config
 * @param  string $path
 * @param  any $default
 */
function config($key, $default = null)
{
    $data = App::get('config');
    if (!is_string($key) || empty($key) || !count($data))
    {
        return $default;
    }
    if (strpos($key, '.') !== false)
    {
        $keys = explode('.', $key);

        foreach ($keys as $innerKey)
        {
            if (!array_key_exists($innerKey, $data))
            {
                return $default;
            }

            $data = $data[$innerKey];
        }

        return $data;
    }
    return array_key_exists($key, $data) ? $data[$key] : $default;
}


function _limit($string, $length = 70, $dots = "...") {
	return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
}

function _col ($string) {
	return implode(' ', explode('_', $string));
}

function _formatDate($date, $format = 'Y-m-d') {
    return  date($format, strtotime(str_replace('-', '/', $date)));
}

function form($config) {
    extract($config);
    return require "core/views/form.php";
}

function table($config) {
    extract($config);
    return require "core/views/table.php";
}
