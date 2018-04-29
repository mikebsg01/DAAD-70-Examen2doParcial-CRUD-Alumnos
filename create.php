<?php if (!file_exists('system/core.php')) exit("Sorry, has been ocurred an error trying to load the system.");

require_once 'system/core.php';
require_once 'libraries/Validation/Validation.php';

$careers = getGlobalVar('careers');

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
    $result = dbQuery("SELECT count(*) as `counter` FROM `school`.`students` ".
                      "WHERE `students`.`file_number` = '{$studentRequest['file_number']}'");

    if (getCounter($result) > 0) {
      makeFlash('STATUS_ERROR', 'El expediente ingresado ya existe.');
    } else {
      $result = dbQuery("INSERT INTO `school`.`students` ".
                        "(`students`.`file_number`, `students`.`first_name`, ".
                        "`students`.`last_name`, `students`.`career`) ".
                        "VALUES ({$studentRequest['file_number']}, ".
                        "\"{$studentRequest['first_name']}\", ".
                        "\"{$studentRequest['last_name']}\", ".
                        "\"{$studentRequest['career']}\")");

      makeFlash('STATUS_SUCCESS', 'El alumno ha sido registrado exitosamente! :)');
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
              <form action="create.php" method="POST">
                <div class="input-field col s12 <?php echo ((isset($errors) and $errors->has('file_number')) ? 'input-error' : '') ?>">
                  <input type="text" name="student[file_number]" id="file_number" class="validate" required="required" <?php echo (! empty($studentRequest['file_number']) ? "value=\"{$studentRequest['file_number']}\"" : '')?>>
                  <label for="file_number">Expediente</label>
                  <?php if (isset($errors) and $errors->has('file_number')): ?>
                    <span class="lbl-error"><?php echo $errors->first('file_number') ?></span>
                  <?php endif; ?>
                </div>
                <div class="input-field col s12 <?php echo ((isset($errors) and $errors->has('first_name')) ? 'input-error' : '') ?>">
                  <input type="text" name="student[first_name]" id="first_name" class="validate" required="required" <?php echo(! empty($studentRequest['file_number']) ? "value=\"{$studentRequest['first_name']}\"" : '')?>>
                  <label for="first_name">Nombre(s)</label>
                  <?php if (isset($errors) and $errors->has('first_name')): ?>
                    <span class="lbl-error"><?php echo $errors->first('first_name') ?></span>
                  <?php endif; ?>
                </div>
                <div class="input-field col s12 <?php echo ((isset($errors) and $errors->has('last_name')) ? 'input-error' : '') ?>">
                  <input type="text" name="student[last_name]" id="last_name" class="validate" required="required" <?php echo (! empty($studentRequest['file_number']) ? "value=\"{$studentRequest['last_name']}\"" : '')?>>
                  <label for="last_name">Apellido(s)</label>
                  <?php if (isset($errors) and $errors->has('last_name')): ?>
                    <span class="lbl-error"><?php echo $errors->first('last_name') ?></span>
                  <?php endif; ?>
                </div>
                <div class="input-field col s12">
                  <select name="student[career]" id="career" class="validate" required="required">
                  <option disabled="disabled" hidden="hidden" value="" <?php echo ((isset($errors) and $errors->has('career') and in_array($studentRequest['career'], $careers)) ? '' : "selected=\"selected\"") ?>>Elige una opción...</option>
                    <?php foreach ($careers as $career_slug => $career_name): ?>
                      <option value="<?php echo $career_slug; ?>" <?php echo (($career_slug === $studentRequest['career']) ? "selected=\"selected\"" : '') ?>><?php echo $career_name; ?></option>
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