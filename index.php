<!DOCTYPE html>
<html lang="es-Es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title></title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="sb-admin-2.min.css" rel="stylesheet">

</head>
<body id="page-top">
    <!-- Page Wrapper -->
<div id="wrapper">
        
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
        <div class="my-5"></div>
            <div class="container-fluid">

                <!--<form action="upload.php" method="post" enctype="multipart/form-data">
                    Seleccionar imagen para cargar:
                    <input type="file" name="image"/>
                    <br>
                    <input type="text" name="id" placeholder="Ingrese ID"/>
                    <br>
                    <input type="submit" name="submit" value="UPLOAD"/>
                </form>
                -->
                <?php
                    //DB details
                    $dbHost     = '';
                    $dbUsername = 'root';
                    $dbPassword = '';
                    $dbName     = '';
                    $dbport = 3306;

                    //Create connection and select DB
                    $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbport);

                    // Check connection
                    if($db->connect_error){
                        die("Connection failed: " . $db->connect_error);
                    }

                    /****/

                    //Preparar la orden SQL
                    $consulta= "SELECT * FROM causas.causas";

                    // Ejecutar la orden y obtener datos
                    $datos = $db->query($consulta);
                    /****/
                ?>

                <div class="row">
                    <div class="col-xl-6 col-md-6 mb-4 offset-3">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="font-weight-bold text-primary text-uppercase mb-2">
                                            Seleccionar imagen para cargar:
                                        </div>
                                            <form action="upload.php" method="post" enctype="multipart/form-data">
                                                <div class="form-group form-control-file">
                                                    <input type="file" name="image" class="btn btn-light btn-icon-split"/>
                                                </div>
                                                <div class="my-2"></div>
                                                <div class="form-group form-inline">
                                                    <!--<input type="text" name="id" placeholder="Ingrese ID" class="form-control"/>-->
                                                    <select class="form-control" name="id">
                                                        <option value="0">Seleccione Id</option>
                                                    <?php
                                                    // Ir Imprimiendo las filas resultantes
                                                        while ($fila = mysqli_fetch_array($datos)){
                                                            echo '<option value="'.$fila ["caus_id"].'">'.$fila ["caus_id"].'</option>';
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div class="my-2"></div>
                                                <div class="form-group">
                                                    <input type="submit" name="submit" value="UPLOAD" class="btn btn-primary"/>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-upload fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>
</html>
