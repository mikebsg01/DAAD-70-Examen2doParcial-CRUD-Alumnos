<?php

if (! function_exists('env')) {
  function env($enviromentVariable, $defaultValue = null) {
    global $env;

    return (property_exists($env, $enviromentVariable) and ! empty($env->{$enviromentVariable})) ? $env->{$enviromentVariable} : $defaultValue;
  }
}

if (! function_exists('getGlobalVar')) {
  function getGlobalVar(string $var) {
    $variables = include 'global.variables.php';

    return (! empty($variables[$var]) ? $variables[$var] : null);
  }
}

if (! function_exists('cstrtolower')) {
  function cstrtolower($str) {
    return mb_strtolower($str, 'UTF-8');
  }
}

if (! function_exists('cstrtoupper')) {
  function cstrtoupper($str) {
    return mb_strtoupper($str, 'UTF-8');
  }
}

if (! function_exists('cucfirst')) {
  function cucfirst($str) {
    $initial  = cstrtoupper(mb_substr($str, 0, 1));
    $ucfirst  = $initial . mb_substr($str, 1);
    return $ucfirst;
  }
}

if (! function_exists('capitalize')) {
  function capitalize($str) {
    return cucfirst(cstrtolower($str));
  }
}

if (! function_exists('filterData')) {
  function filterData(array $data, $filter) {
    if (is_array($filter)) {
      $filterData = array_intersect_key($data, array_flip($filter));
      return $filterData;
    }
    return null;
  }
}

if (! function_exists('dbConnection')) {
  function dbConnection() {
    $conn = new mysqli(
      env('DB_HOST'), 
      env('DB_USER'),
      env('DB_PASSWORD'),
      env('DB_DATABASE')
    );

    if (mysqli_connect_errno()) {
      throw new Exception("Function \"dbConnection\": ".mysqli_connect_error());
    }
    return $conn;
  }
}

if (! function_exists('dbQuery')) {
  function dbQuery(string $query) {
    $conn   = dbConnection();
    $result = $conn->query($query . ';');
    $conn->close();

    return $result;
  }
}

if (! function_exists('getCounter')) {
  function getCounter($queryResult) {
    if ($queryResult->num_rows > 0) {
      $row = $queryResult->fetch_assoc();
      $counter = (int) $row['counter'];

      return $counter;
    }
    return null;
  }
}

if (! function_exists('makeFlash')) {
  function makeFlash(string $key, string $content) {
    $_SESSION[$key] = $content;
  }
}

if (! function_exists('existsFlash')) {
  function existsFlash(string $key) {
    return isset($_SESSION[$key]);
  }
}

if (! function_exists('getFlash')) {
  function getFlash(string $key) {
    $content = $_SESSION[$key];
    unset($_SESSION[$key]);

    return $content;
  }
}
