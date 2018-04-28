<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Insertar Alumno | Panel de Alumnos</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
  <link href="assets/css/materialize.min.css" rel="stylesheet" type="text/css" media="screen,projection">
  <link href="assets/css/style.css?v=<?php echo time() ?>" rel="stylesheet" type="text/css">
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
              <form action="store.php" method="POST">
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
    </div>
  </div>
</div>
<script type="text/javascript" src="assets/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="assets/js/materialize.min.js"></script>
<script type="text/javascript" src="assets/js/app.js?v=<?php echo time() ?>"></script>
</body>
</html>