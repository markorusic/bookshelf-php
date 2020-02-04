<?php

namespace App\Services;

class ExportService
{
  public static function excel($config) {
    $filename = $config['filename'];
    $columns = $config['columns'];
    $data = $config['data'];
    header("Content-Type: application/xls");    
    header("Content-Disposition: attachment; filename=$filename.xlsx");  
    header("Pragma: no-cache"); 
    header("Expires: 0");
    table([
        'hide_header' => true,
        'hide_actions' => true,
        'resource' => $filename,
        'cols' => $columns,
        'data' => $data
    ]);
  }
}
