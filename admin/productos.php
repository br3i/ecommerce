<?php

include_once("db-ecommerce.php");

$con = mysqli_connect($host, $user, $pass, $db);

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Productos</h1>
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
                            <table id="tablaProductos" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Existencia</th>
                                        <th>Acciones
                                            <a href="#" id="nuevoProductoBtn"><i class="fa fa-plus"
                                                    style="margin-left: 10px;"></i></a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT id, nombre, precio, existencia FROM productos; ";
                                    $res = mysqli_query($con, $query);
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $row['nombre'] ?>
                                            </td>
                                            <td>
                                                <?php echo $row['precio'] ?>
                                            </td>
                                            <td>
                                                <?php echo $row['existencia'] ?>
                                            <td>
                                                <!-- Botones para editar y eliminar -->
                                                <a href="#" class="btn btn-secondary editar"
                                                    onclick="btnEditarProducto(<?php echo $row['id'] ?>)">
                                                    <i class="fas fa-marker"></i>
                                                </a>
                                                <a href="#" class="btn btn-danger borrarP"
                                                    onclick="btnEliminarProducto(<?php echo $row['id'] ?>)">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    mysqli_close($con);
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