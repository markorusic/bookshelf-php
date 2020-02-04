<?php

namespace App\Services;

abstract class PageVisits {
  const Filename = 'page_visits_data.txt';
  const RowDelimiter = "\n";
  const ColDelimiter = "-----";
  const UriIndex = 0;
  const VisitTimeIndex = 1;
}

abstract class ErrorLog {
  const Filename = 'error_data.txt';
  const RowDelimiter = "\n";
  const ColDelimiter = " - ";
  const ErrorTimeIndex = 0;
  const ErrorMessageIndex = 1;
}

class LoggingService
{
  public static function trackPageVisit($uri) {
    $myfile = fopen(PageVisits::Filename, "a") or die("Unable to open file!");
    $content = implode(PageVisits::ColDelimiter, [$uri, date('Y-m-d H:i:s')]);
    fwrite($myfile, $content . "\n");
    fclose($myfile);
  }

  public static function getPageVisits() {
    $data = [];
    $lines = explode(PageVisits::RowDelimiter, file_get_contents(PageVisits::Filename));
    foreach ($lines as $index => $line) {
      $line_tuple = explode(PageVisits::ColDelimiter, $line);
      if (
        isset($line_tuple[PageVisits::UriIndex]) &&
        isset($line_tuple[PageVisits::VisitTimeIndex])
      ) {
        $uri = $line_tuple[PageVisits::UriIndex];
        $visit_time = $line_tuple[PageVisits::VisitTimeIndex];
        $isValidUri = !is_null($uri) && $uri != '';
        $isValidVisitTime = time() - strtotime($visit_time) < 60 * 60 * 24;
  
        if ($isValidUri && $isValidVisitTime) {
          if (!isset($data[$uri])) {
            $data[$uri] = [$visit_time];
          } else {
            array_push($data[$uri], $visit_time);
          }
        }
      }
    }
    return $data;
  }

  public static function trackError($message) {
    $myfile = fopen(ErrorLog::Filename, "a") or die("Unable to open file!");
    $content = implode(ErrorLog::ColDelimiter, [date('Y-m-d H:i:s'), $message]);
    fwrite($myfile, $content . "\n");
    fclose($myfile);
  }
}
