<?php

/**
 * Global Settings
 */
$env = json_decode(file_get_contents(__DIR__.'/../env.json'));

# Helpers
require_once 'helpers.php';

if (env('APP_ENV', 'development') === 'development' or
    env('APP_ENV') == 'local') {
  error_reporting(E_ALL ^ E_NOTICE | E_STRICT);
  ini_set('display_errors', 1);
}

/**
 * Global Libraries
 */
require_once __DIR__.'/../libraries/Collection/Collection.php';
require_once __DIR__.'/../libraries/Lang/Lang.php';

/**
 * App Class
 */
class App {
  public static function getCurrentAction() {
    return basename($_SERVER["SCRIPT_FILENAME"], ".php");
  }

  public static function print() {
    $i = 0;

    echo "<pre class=\"app-print\">\n";

    foreach (func_get_args() as $var) {
      if ($i > 0) {
        echo "\n";
      }

      var_dump($var);
      ++$i;
    }

    echo "</pre>\n";
  }
}
