<?php if (!file_exists('system/core.php')) exit("Sorry, has been ocurred an error trying to load the system.");

require_once 'system/core.php';

if (! empty($_POST['student'])) {
  $student = $_POST['student'];

  $studentRequest = filterData($_POST['user'], [
    'file_number',
    'first_name',
    'last_name',
    'career'
  ]);

  $validation = Validation::make($userRequest, [
    'file_number'           => ['required', 'email'],
    'password'              => ['required', 'min' => 6],
    'passwordConfirmation'  => ['required', 'equalTo' => 'password']
  ]);

  if ($validation->fails()) {
    $errors = $validation->errors();
    App::print($errors);
  } else {
    App::print("Jalo chido");
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
<div class="row">
  <div class="container">
    <div class="row">
      <div class="col s6 offset-s3">
        <div class="card card-form">
          <div class="card-content">
            <div class="row">
              <div class="col s12">
                <h1 class="card-title">Ingresar alumno</h1>
              </div>
              <form action="create.php" method="POST">
                <div class="input-field col s12">
                  <input type="text" name="student[file_number]" id="file_number" class="validate" required="required">
                  <label for="file_number">Expediente</label>
                </div>
                <div class="input-field col s12">
                  <input type="text" name="student[first_name]" id="first_name" class="validate" required="required">
                  <label for="first_name">Nombre(s)</label>
                </div>
                <div class="input-field col s12">
                  <input type="text" name="student[last_name]" id="last_name" class="validate" required="required">
                  <label for="last_name">Apellido(s)</label>
                </div>
                <div class="input-field col s12">
                  <select name="student[career]" id="career" class="validate" required="required">
                  <option selected="selected" disabled="disabled" hidden="hidden" value="">Elige una opción...</option>
                    <option value="software">Software</option>
                    <option value="telecommunications-and-networks">Telecomunicaciones y Redes</option>
                    <option value="computing">Computación</option>
                    <option value="informatics">Informática</option>
                    <option value="admin-in-information-technology">Administración en Tecnologías de Información</option>
                  </select>
                  <label for="career">Carrera</label>
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