<?php
include_once "db-ecommerce.php";
$con = mysqli_connect($host, $user, $pass, $db);

$id = mysqli_real_escape_string($con, $_REQUEST['id'] ?? '');
$query = "SELECT * FROM usuarios WHERE id = '" . $id . "';";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$passAuxiliar = $row['pass'];

if (isset($_POST['canEditar'])) {
  echo "<meta http-equiv='refresh' content='0;url=panel.php?modulo=usuarios'/>";
} elseif (isset($_POST['editar'])) {
  $nombre = mysqli_real_escape_string($con, $_POST['nombre'] ?? '');
  $email = mysqli_real_escape_string($con, $_POST['email'] ?? '');
  $password = mysqli_real_escape_string($con, $_POST['passw'] ?? '');
  if ($password == '') {
    $password = $passAuxiliar;
  } else {
    $password = password_hash($password, PASSWORD_DEFAULT);
  }
  $id = mysqli_real_escape_string($con, $_POST['id'] ?? '');


  if ($nombre == '' || $email == '') {
    ?>
    <div class="alert alert-danger" role="alert">
      No se admiten valores en blanco
      <?php echo mysqli_error($con); ?>
    </div>
    <?php

    return;
  } else {
    $fotoPerfil = $row['fotoPerfil'];
    $queryFields = "email = '" . $email . "', pass = '" . $password . "', nombre = '" . $nombre . "'";


    if (isset($_FILES['fperfilEditar']) && $_FILES['fperfilEditar']['error'] == 0) {
      if ($_FILES['fperfilEditar']['size'] <= 10485760) {
        $fotoPerfilType = $_FILES['fperfilEditar']['type'];
        if ($fotoPerfilType == "image/x-icon" || $fotoPerfilType == "image/jpg" || $fotoPerfilType == "image/jpeg" || $fotoPerfilType == "image/png" || $fotoPerfilType == "image/gif") {
          $fotoPerfil = addslashes(file_get_contents($_FILES['fperfilEditar']['tmp_name']));
          $queryFields .= ", fotoPerfil = '" . $fotoPerfil . "'";
        } else {
          ?>
          <div class="alert alert-danger alert-dismissible fade show content-wrapper" role="alert">
            <p style="font-size: 25px;">
              <strong>Error:</strong>
              El tipo de archivo seleccionado no es válido, por favor seleccione un archivo de imagen. (Ej: jpg, jpeg, png, gif)
            </p>
          </div>
          <script>
            setTimeout(function () {
              window.location.href = "panel.php?modulo=editarUsuario&id=<?php echo $id; ?>";
            }, 4500);
          </script>
          <?php
          return;
        }
      } else {
        ?>
        <div class="alert alert-danger alert-dismissible fade show content-wrapper" role="alert">
          <p style="font-size: 25px;">
            <strong>Error:</strong>
            El peso de la imagen seleccionada supera los 10MB, por favor seleccione una imagen más pequeña.
          </p>
        </div>
        <script>
          setTimeout(function () {
            window.location.href = "panel.php?modulo=editarUsuario&id=<?php echo $id; ?>";
          }, 4500);
        </script>
        <?php
        return;
      }
    }

    $query = "UPDATE usuarios SET " . $queryFields . " WHERE id = '" . $id . "';";


    $result = mysqli_query($con, $query);
    if ($result) {
      echo "<meta http-equiv='refresh' content='0;url=panel.php?modulo=usuarios&mensaje=Usuario " . $nombre . " editado exitosamente'/>";
    } else {
      ?>
      <div class="alert alert-danger" role="alert">
        Error al editar el usuario
        <?php echo mysqli_error($con); ?>
      </div>
      <?php
    }
    mysqli_close($con);
  }
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Editar Usuario</h1>
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
              <form action="panel.php?modulo=editarUsuario" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="">Nombre</label>
                  <input type="text" name="nombre" class="form-control" value="<?php echo $row['nombre'] ?>" required>
                </div>
                <div class="form-group">
                  <label for="">Email</label>
                  <input type="email" name="email" class="form-control" value="<?php echo $row['email'] ?>" required>
                </div>
                <div class="form-group">
                  <label for="">Password</label>
                  <div class="input-group">
                    <input type="password" name="passw" class="form-control" id="passwordInput"
                      onfocus="verifyPassword()">
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="fa fa-eye" id="passwordEye"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Foto de Perfil</label>
                  <br>
                  <div style="display: flex;
                       justify-content: space-evenly;
                       border: 1px solid #ced4da;border-radius: .25rem;
                       box-shadow: inset 0 0 0 transparent;
                       align-items: center;">
                    <img src="data:image/jpg;base64,<?php echo base64_encode($row['fotoPerfil']); ?>" alt=""
                      style="width: 125px;">
                    <input type="file" name="fperfilEditar" class="form-control" value="UPLOAD">
                  </div>
                  <div class="form-group">
                    <br>
                    <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                    <button type="submit" class="btn btn-success" name="editar">Guardar</button>
                    <button type="button" class="btn btn-primary" name="canEditar"
                      onclick="window.location.href='panel.php?modulo=usuarios'">Cancelar</button>
                  </div>
              </form>
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