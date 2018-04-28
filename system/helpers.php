<?php

if (! function_exists('env')) {
  function env($enviromentVariable, $defaultValue = null) {
    global $env;

    return (property_exists($env, $enviromentVariable) and ! empty($env->{$enviromentVariable})) ? $env->{$enviromentVariable} : $defaultValue;
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