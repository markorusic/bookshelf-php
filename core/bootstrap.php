<?php

use App\Core\App;
use App\Core\Database\{QueryBuilder, Connection};

error_reporting(0);
ob_start();
session_start();

App::bind('config', require 'config.php');

App::bind('database', new QueryBuilder(
    Connection::make(App::get('config')['database'])
));
