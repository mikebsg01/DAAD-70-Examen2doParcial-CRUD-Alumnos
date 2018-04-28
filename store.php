<?php

require_once 'helpers.php';

$student = $_POST['student'];

if (is_null($student)) {
  return header('Location: create.php?error=1');
}

dd('Hola');