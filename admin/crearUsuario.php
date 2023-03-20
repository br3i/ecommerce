<?php
if (isset($_REQUEST['guardar'])) {
  include_once "db-ecommerce.php";
  $con = mysqli_connect($host, $user, $pass, $db);

  $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
  $email = mysqli_real_escape_string($con, $_POST['email'] ?? '');
  $password = mysqli_real_escape_string($con, $_POST['passw'] ?? '');

  if ($nombre == '' || $email == '' || $password == '') {
    echo "Todos los campos son obligatorios";
    exit;
  }

  $password = password_hash($password, PASSWORD_DEFAULT);

  $fotoPerfil = "";

  if (isset($_FILES['fperfil']['tmp_name']) && !empty($_FILES['fperfil']['tmp_name'])) {
    $fotoPerfil = addslashes(file_get_contents($_FILES['fperfil']['tmp_name']));
  } else if (isset($_POST['fotDefault']) && $_POST['fotDefault'] == 'ftDefault') {
    $fotoPerfil = addslashes(file_get_contents("dist\img\michiSandia.png"));
  } else if (isset($_POST['fotDefault']) && $_POST['fotDefault'] == 'ftDefault2') {
    $fotoPerfil = addslashes(file_get_contents("dist\img\avatar2.png"));
  }

  $query = "INSERT INTO usuarios (email, pass, nombre, fotoPerfil) VALUES ('$email', '$password', '$nombre', '$fotoPerfil');";
  $result = mysqli_query($con, $query);
  if ($result) {
    echo "<meta http-equiv='refresh' content='0;url=panel.php?modulo=usuarios&mensaje=Usuario creado exitosamente'/>";
  } else {
    ?>
    <div class="alert alert-danger" role="alert">
      Error al crear el usuario
      <?php echo mysqli_error($con); ?>
    </div>
    <?php
  }
  mysqli_close($con);
}
?>

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Crear Usuario</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <form action="panel.php?modulo=crearUsuario" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="">Nombre</label>
                  <input type="text" name="nombre" class="form-control">
                </div>
                <div class="form-group">
                  <label for="">Email</label>
                  <input type="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                  <label for="">Password</label>
                  <input type="password" name="passw" class="form-control">
                </div>
                <div class="form-group">
                  <label for="">Foto de Perfil</label>
                  <br>
                  <div style="display: flex;
           justify-content: space-evenly;
           border: 1px solid #ced4da;border-radius: .25rem;
           box-shadow: inset 0 0 0 transparent;">
                    <div>
                      <input type="radio" id="ftDeafault" name="fotDefault" value="ftDefault">
                      <img src="dist\img\michiSandia.png" alt="" style='width: 150px;'>
                    </div>
                    <div>
                      <input type="radio" id="ftDeafault2" name="fotDefault" value="ftDefault2">
                      <img src="dist\img\avatar2.png" alt="" style='width: 150px;'>
                    </div>
                    <button type="button" class="btn bg-gradient-info btn-sm" id="btnDeseleccionar"
                      style="position: absolute; left: 20px" onclick="uncheckRadioButtons()">X</button>
                  </div>
                </div>
                <br>
                <label for="">Seleccione una imagen por defecto o suba una a su gusto</label>
                <input type="file" name="fperfil" class="form-control" id="inpFoto" value="UPLOAD">
                <br>
                <div class="form-group">
                  <button type="submit" class="btn btn-success" name="guardar">Crear</button>
                  <button type="button" class="btn btn-primary" id="btnCancelar"
                    onclick="window.location.href='panel.php?modulo=usuarios'">Cancelar</button>
                </div>
              </form>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>