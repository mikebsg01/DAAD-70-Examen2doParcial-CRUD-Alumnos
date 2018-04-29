<?php if (!file_exists('system/core.php')) exit("Sorry, has been ocurred an error trying to load the system.");

require_once 'system/core.php';

if (!empty($_POST['_method']) and $_POST['_method'] == 'DELETE' and
    !empty($_POST['file_number'])) {
    $file_number = $_POST['file_number'];

  $result = dbQuery("SELECT `students`.`id` FROM `school`.`students` ".                                               "WHERE `students`.`file_number` = '{$file_number}' ".
                    "ORDER BY created_at LIMIT 1;");

  if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    $id = (int) $student['id'];

    $erased = dbQuery("DELETE FROM `school`.`students` WHERE id = '$id'");
    
    if ($erased) {

    }
  }
}
return header('Location: index.php');