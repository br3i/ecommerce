<?php

include_once("db-ecommerce.php");

$con = mysqli_connect($host, $user, $pass, $db);

if (!$con) {
  exit("Error de conexión: " . mysqli_connect_error());
}

if (isset($_REQUEST['idBorrar'])) {
  $id = $_REQUEST['idBorrar'];
  $stmt = mysqli_prepare($con, "DELETE FROM usuarios WHERE id = ?");
  mysqli_stmt_bind_param($stmt, "i", $id);
  if (mysqli_stmt_execute($stmt)) {
    echo '
    <div class="alert alert-primary alert-dismissible float-right" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        Usuario eliminado con éxito
    </div>
    ';
  } else {
    echo '<div class="alert alert-danger float-right" role="alert">Error al eliminar el usuario: ' . mysqli_error($con) . '</div>';
  }
  mysqli_stmt_close($stmt);
}

mysqli_close($con);

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Usuarios</h1>
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
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Foto de Perfil</th>
                    <th>Acciones
                      <a href="panel.php?modulo=crearUsuario"><i class="fa fa-plus" style="margin-left: 10px;"></i></a>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  include_once("db-ecommerce.php");

                  $con = mysqli_connect($host, $user, $pass, $db);
                  $query = "SELECT id, email, nombre, fotoPerfil FROM usuarios; ";
                  $res = mysqli_query($con, $query);

                  while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                    <tr>
                      <td>
                        <?php echo $row['nombre'] ?>
                      </td>
                      <td>
                        <?php echo $row['email'] ?>
                      </td>
                      <td>
                        <?php
                        echo "<img src='data:image/png;base64," . base64_encode($row['fotoPerfil']) . "' alt='Imagen de Usuario' style='width: 150px;'>";
                        ?>
                      </td>
                      <td>
                        <a href="panel.php?modulo=editarUsuario&id=<?php echo $row['id'] ?>" class="btn btn-secondary">
                          <i class="fas fa-marker"></i>
                        </a>
                        <a href="panel.php?modulo=usuarios&idBorrar=<?php echo $row['id'] ?>"
                          class="btn btn-danger borrarU">
                          <i class="far fa-trash-alt"></i>
                        </a>
                      </td>
                    </tr>
                    <?php
                  }
                  ?>
              </table>
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