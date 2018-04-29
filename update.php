<?php if (!file_exists('system/core.php')) exit("Sorry, has been ocurred an error trying to load the system.");

require_once 'system/core.php';
require_once 'libraries/Validation/Validation.php';

$careers = getGlobalVar('careers');

if (! empty($_GET['file_number'])) {
  $file_number = (int) $_GET['file_number'];

  $result = dbQuery("SELECT * FROM `school`.`students` ".
                    "WHERE `students`.`file_number` = '{$file_number}' LIMIT 1");
  
  if ($result->num_rows == 0) {
    return header('Location: index.php');
  }

  $student = $result->fetch_assoc();
}

if (! empty($_POST['student'])) {
  $student = $_POST['student'];

  $studentRequest = filterData($_POST['student'], [
    'file_number',
    'first_name',
    'last_name',
    'career'
  ]);

  $validation = Validation::make($studentRequest, [
    'file_number' => ['required', 'numeric', 'size' => 6],
    'first_name'  => ['required', 'max' => 25],
    'last_name'   => ['required', 'max' => 25],
    'career'      => ['required', 'in' => array_keys($careers)]
  ], 'es');

  if ($validation->fails()) {
    $errors = $validation->errors();
  } else {
    $isDifferentFileNumber = $studentRequest['file_number'] != $file_number;

    if ($isDifferentFileNumber) {
      $result = dbQuery("SELECT count(*) as `counter` FROM `school`.`students` ".
                        "WHERE `students`.`file_number` = '{$studentRequest['file_number']}'");
    }

    if ($isDifferentFileNumber and getCounter($result) > 0) {
      makeFlash('STATUS_ERROR', 'El expediente ingresado ya existe.');
    } else {
      $result = dbQuery("UPDATE `school`.`students` SET ".
                        "`students`.`file_number` = \"{$studentRequest['file_number']}\", ".
                        "`students`.`first_name` = \"{$studentRequest['first_name']}\", ".
                        "`students`.`last_name` = \"{$studentRequest['last_name']}\", ".
                        "`students`.`career` = \"{$studentRequest['career']}\" ".
                        "WHERE `students`.`file_number` = '{$file_number}'");

      makeFlash('STATUS_SUCCESS', 'El alumno ha sido actualizado exitosamente! :)');
      return header('Location: index.php');
    }
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Ingresar Alumno | Panel de Alumnos</title>
  <?php include 'templates/header.php'; ?>
</head>
<body>
<?php include 'templates/navbar.php'; ?>
<div class="create-page row">
  <div class="container">
    <div class="row">
      <?php if (existsFlash('STATUS_ERROR')): ?>
        <div class="alert-status col s6 offset-s3">
          <div class="card-panel red darken-2 blue-grey-text text-lighten-5">
            <span><?php echo getFlash('STATUS_ERROR'); ?></span>
          </div>
        </div>
      <?php endif; ?>
      <div class="col s6 offset-s3">
        <div class="card card-form">
          <div class="card-content">
            <div class="row">
              <div class="col s12">
                <h1 class="card-title">Ingresar alumno</h1>
              </div>
              <form action="update.php?file_number=<?php echo $file_number; ?>" method="POST">
                <div class="input-field col s12 <?php echo ((isset($errors) and $errors->has('file_number')) ? 'input-error' : '') ?>">
                  <input type="text" name="student[file_number]" id="file_number" class="validate" required="required" <?php echo (! empty($studentRequest['file_number']) ? "value=\"{$studentRequest['file_number']}\"" : (! empty($student['file_number']) ? "value=\"{$student['file_number']}\"" : ""))?>>
                  <label for="file_number">Expediente</label>
                  <?php if (isset($errors) and $errors->has('file_number')): ?>
                    <span class="lbl-error"><?php echo $errors->first('file_number') ?></span>
                  <?php endif; ?>
                </div>
                <div class="input-field col s12 <?php echo ((isset($errors) and $errors->has('first_name')) ? 'input-error' : '') ?>">
                  <input type="text" name="student[first_name]" id="first_name" class="validate" required="required" <?php echo(! empty($studentRequest['first_name']) ? "value=\"{$studentRequest['first_name']}\"" : (! empty($student['first_name']) ? "value=\"{$student['first_name']}\"" : ""))?>>
                  <label for="first_name">Nombre(s)</label>
                  <?php if (isset($errors) and $errors->has('first_name')): ?>
                    <span class="lbl-error"><?php echo $errors->first('first_name') ?></span>
                  <?php endif; ?>
                </div>
                <div class="input-field col s12 <?php echo ((isset($errors) and $errors->has('last_name')) ? 'input-error' : '') ?>">
                  <input type="text" name="student[last_name]" id="last_name" class="validate" required="required" <?php echo (! empty($studentRequest['last_name']) ? "value=\"{$studentRequest['last_name']}\"" : (! empty($student['last_name']) ? "value=\"{$student['last_name']}\"" : ""))?>>
                  <label for="last_name">Apellido(s)</label>
                  <?php if (isset($errors) and $errors->has('last_name')): ?>
                    <span class="lbl-error"><?php echo $errors->first('last_name') ?></span>
                  <?php endif; ?>
                </div>
                <div class="input-field col s12">
                  <select name="student[career]" id="career" class="validate" required="required">
                  <option disabled="disabled" hidden="hidden" value="" <?php echo ((isset($errors) and $errors->has('career') and in_array($studentRequest['career'], array_keys($careers))) ? '' : ((!empty($student['career']) and in_array($student['career'], array_keys($careers))) ? '' : "selected=\"selected\"")) ?>>Elige una opción...</option>
                    <?php foreach ($careers as $career_slug => $career_name): ?>
                      <option value="<?php echo $career_slug; ?>" <?php echo ((!empty($studentRequest['career']) and ($career_slug === $studentRequest['career'])) ? "selected=\"selected\"" : ((!empty($student['career']) and ($career_slug === $student['career'])) ? "selected=\"selected\"" : '')) ?>><?php echo $career_name; ?></option>
                    <?php endforeach; ?>
                  </select>
                  <label for="career">Carrera</label>
                  <?php if (isset($errors) and $errors->has('career')): ?>
                    <span class="lbl-error"><?php echo $errors->first('career') ?></span>
                  <?php endif; ?>
                </div>
                <div class="input-field center-align col s12">
                  <button type="submit" class="waves-effect waves-light btn btn-primary btn-large">Guardar <i class="material-icons right">send</i></button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php include 'templates/footer.php'; ?>
    </div>
  </div>
</div>
<?php include 'templates/scripts.php'; ?>
</body>
</html>