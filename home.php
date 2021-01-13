<?php

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">


<head>


    <title>Website</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">

</head>
<style type="text/css">
    button:hover {
        cursor: pointer;
    }

    #inputbtn:hover {
        cursor: pointer;
    }
</style>

<body>
    <?php
    require 'navbar.php';
    ?>
    <div class="container-fluid" style="margin-top:50px;">
        <h3 style="margin-left: 40%; padding-bottom: 20px;font-family:'IBM Plex Sans', sans-serif;"> Selamat Datang Admin </h3>
        <div class="row">
            <div class="col-md-4" style="max-width:18%;margin-top: 3%;">
                <div class="list-group" id="list-tab" role="tablist">
                    <a class="list-group-item list-group-item-action active" href="#list-dash" role="tab" aria-controls="home" data-toggle="list">Dashboard</a>
                    <a class="list-group-item list-group-item-action" href="#upload" id="sec-upload" role="tab" data-toggle="list" aria-controls="home">Upload</a>
                    <a class="list-group-item list-group-item-action" href="#view" id="sec-view" role="tab" data-toggle="list" aria-controls="home"> Lihat Data </a>

                </div><br>
            </div>
            <div class="col-md-8" style="margin-top: 3%;">
                <div class="tab-content" id="nav-tabContent" style="width: 950px;">
                    <div class="tab-pane fade show active" id="list-dash" role="tabpanel" aria-labelledby="list-dash-list">

                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">

                                <div class="col-sm-4" style="left: 10%">
                                    <div class="panel panel-white no-radius text-center">
                                        <div class="panel-body">
                                            <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-list fa-stack-1x fa-inverse"></i> </span>
                                            <h4 class="StepTitle" style="margin-top: 5%;"> Upload Data</h4>
                                            <script>
                                                function clickDiv(id) {
                                                    document.querySelector(id).click();
                                                }
                                            </script>
                                            <p class="links cl-effect-1">
                                                <a href="#upload" onclick="clickDiv('#sec-upload')">
                                                    Upload Data
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4" style="left: 15%">
                                    <div class="panel panel-white no-radius text-center">
                                        <div class="panel-body">
                                            <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-list-ul fa-stack-1x fa-inverse"></i> </span>
                                            <h4 class="StepTitle" style="margin-top: 5%;"> Lihat Data </h4>

                                            <p class="links cl-effect-1">
                                                <a href="#view" onclick="clickDiv('#sec-view')">
                                                    Lihat Data
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="tab-pane fade" id="upload" role="tabpanel" aria-labelledby="sec-upload">

                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">

                                <div class="col-sm-4" style="left: 3%">
                                    <div class="panel panel-white no-radius text-center">
                                        <div class="panel-body">
                                            <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-list fa-stack-1x fa-inverse"></i> </span>
                                            <h4 class="StepTitle" style="margin-top: 5%;"> Upload Simpanan</h4>
                                            <!-- <script>
                                                function clickDiv(id) {
                                                    document.querySelector(id).click();
                                                }
                                            </script> -->
                                            <p class="links cl-effect-1">
                                                <a href="upload-simpanan.php">
                                                    Simpanan
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4" style="left: 3%">
                                    <div class="panel panel-white no-radius text-center">
                                        <div class="panel-body">
                                            <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-list-ul fa-stack-1x fa-inverse"></i> </span>
                                            <h4 class="StepTitle" style="margin-top: 5%;"> Upload Pairing-Fo </h4>

                                            <p class="links cl-effect-1">
                                                <a href="upload-pairing-fo.php">
                                                    Pairing-Fo
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4" style="left: 3%">
                                    <div class="panel panel-white no-radius text-center">
                                        <div class="panel-body">
                                            <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-list-ul fa-stack-1x fa-inverse"></i> </span>
                                            <h4 class="StepTitle" style="margin-top: 5%;"> Upload Debitur </h4>

                                            <p class="links cl-effect-1">
                                                <a href="upload-debitur.php">
                                                    Debitur
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>



                    <div class="tab-pane fade" id="view" role="tabpanel" aria-labelledby="sec-view">
                        <!-- <form action="" method="post" name="frefresh" id="frefresh">
                            <button type="submit" name="refresh" class="btn btn-primary">Refresh</button>
                        </form> -->
                        <button onclick="document.location='view.php'" class="btn btn-primary">Refresh</button>
                        <table class="table table-hover" style="margin-top: 2%;">
                            <thead>
                                <tr>

                                    <th scope=" col">Nama Debitur</th>
                                    <th scope="col">Total Exposur</th>
                                    <th scope="col">Total Simpanan</th>
                                    <th scope="col">Syarat Casa</th>
                                    <th scope="col">Selisih</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                require_once('./config.php');

                                $query = "SELECT pcd.nama_debitur, 
                                pcd.os, 
                                pcd.syarat_casa, 
                                sum(s.instanding) as total  
                                FROM pemenuhan_casa_debitur pcd 
                                INNER JOIN simpanan s 
                                ON pcd.cif = s.cif  
                                GROUP BY 
                                pcd.nama_debitur, 
                                pcd.os, 
                                pcd.syarat_casa ";

                                $result = mysqli_query($mysqli, $query);
                                if (!$result) {
                                    echo mysqli_error($mysqli);
                                }


                                while ($data = mysqli_fetch_array($result)) {

                                ?>
                                    <tr>
                                        <td><?php echo $data['nama_debitur'] ?></td>
                                        <td><?php echo $data['os'] ?></td>
                                        <td><?php


                                            echo $data['total'] ?></td>
                                        <td><?php echo $data['syarat_casa'] ?></td>
                                        <td><?php
                                            $syarat_casa = $data['syarat_casa'];
                                            $total = $data['total'];
                                            $hasil = $total - $syarat_casa;
                                            echo $hasil ?></td>
                                        <!-- <td><?php //echo $row['waktu']; 
                                                    ?></td> -->

                                    </tr>
                                <?php  }
                                ?>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js"></script>
</body>

</html>