<?php if (!file_exists('system/core.php')) exit("Sorry, has been ocurred an error trying to load the system.");

require_once 'system/core.php';

if (! empty($_GET['search'])) {
  $search = $_GET['search'];

  $result = dbQuery("SELECT * FROM `school`.`students` WHERE".
                    "(`students`.`file_number` LIKE \"%{$search}%\" OR ".
                    "`students`.`first_name` LIKE \"%{$search}%\" OR ". 
                    "`students`.`last_name`  LIKE \"%{$search}%\") ".
                    "ORDER BY `students`.`file_number` ASC");
} else {
  $result = dbQuery("SELECT * FROM `school`.`students` WHERE 1 ORDER BY `students`.`file_number` ASC");
}

if ($result->num_rows > 0) {
  $students = [];
  $careers = getGlobalVar('careers');

  while ($student = $result->fetch_assoc()) {
    $students[] = $student;
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Lista de Alumnos | Panel de Alumnos</title>
  <?php include 'templates/header.php'; ?>
</head>
<body>
<?php include 'templates/navbar.php'; ?>
<div class="index-page row">
  <div class="container">
    <div class="row">
      <?php if (existsFlash('STATUS_SUCCESS')): ?>
        <div class="alert-status col s12">
          <div class="card-panel green darken-1 white-text">
            <span><?php echo getFlash('STATUS_SUCCESS'); ?></span>
          </div>
        </div>
      <?php endif; ?>
      <?php if (existsFlash('STATUS_ERROR')): ?>
        <div class="alert-status col s12">
          <div class="card-panel red darken-2 blue-grey-text text-lighten-5">
            <span><?php echo getFlash('STATUS_ERROR'); ?></span>
          </div>
        </div>
      <?php endif; ?>
      <div class="col s12">
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s8">
                <h1 class="card-title">Lista de Alumnos</h1>
              </div>
              <div class="col s4 right-align add-btn-container">
                <a href="create.php" class="waves-effect waves-light btn btn-primary"><i class="material-icons left">add</i> Alumno</a>
              </div>
            </div>
            <div class="row">
              <div class="col s12">
                <table class="highlight">
                  <thead>
                    <tr>
                      <th>Expediente</th>
                      <th>Nombre(s)</th>
                      <th>Apellido(s)</th>
                      <th class="center-align">Carrera</th>
                      <th class="center-align">Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ($result->num_rows > 0): ?>
                      <?php foreach ($students as $student): ?>
                        <tr>
                          <td class="right-align">
                            <b><?php echo $student['file_number']; ?></b>
                          </td>
                          <td><?php echo $student['first_name']; ?></td>
                          <td><?php echo $student['last_name']; ?></td>
                          <td class="center-align"><?php echo $careers[$student['career']]; ?></td>
                          <td class="center-align">
                            <a href="update.php?file_number=<?php echo $student['file_number']; ?>" class="waves-effect waves-light btn btn-primary white grey-text text-darken-4"><i class="material-icons">edit</i></a>
                            <form action="delete.php" method="POST" class="inline-block">
                              <input type="hidden" name="_method" value="DELETE">
                              <input type="hidden" name="file_number" value="<?php echo $student['file_number']; ?>">
                              <button type="submit" class="waves-effect waves-light btn btn-primary"><i class="material-icons">delete</i></button>
                            </form>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="5">
                          <div class="col s12 alert-empty-data">
                              <p>No hay datos para mostrar.</p>
                          </div>
                        </td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
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