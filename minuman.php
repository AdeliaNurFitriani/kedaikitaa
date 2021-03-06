<?php
$row;
$cntrid = 1;
function f_ConnMysqliObj()
{

    //get variable global
    global $servername, $username, $password;

    //get conn global
    global $conn;

    //create connection
    $dbname = "kedai";
    $servername = "localhost";
    $dsn = "pgsql:host=$servername;dbname=$dbname";
    $username = "postgres";
    $password = "adelia";

    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Berhasil";
    } catch (PDOExeption $e) {
        echo "Error: " . $e->getMessage();
    }
}

function closeConnectionPDO()
{
    global $conn;
    $conn = null;
}

function insertData($data)
{
    global $conn;
    global $result;
    try {
        $stm = $conn->prepare("INSERT INTO public.minuman(mi_id, nama_mi,  qty, create_date, harga_mi)
								VALUES((select coalesce(max(mi_id),0)+1 
                                from public.minuman), 
                                :nama_mi, 
                                :qty, 
                                current_date, 
                                :harga_mi)
                                ");


        $stm->bindParam('nama_mi', $data["nama_mi"], PDO::PARAM_INT);
        $stm->bindParam('qty', $data["qty"], PDO::PARAM_INT);
        $stm->bindParam('harga_mi', $data["harga_mi"], PDO::PARAM_INT);


        $stm->execute();

        echo "<script>alert('Ok, Berhasil Insert);
				document.location.href = 'minuman.php';
			</script>";
    } catch (PDOException $e) {
        echo "<script>alert('No, Gagal Insert');
		document.location.href = 'minuman.php';
	</script>";
    }
}



function nama_minuman()
{
    global $conn;
    global $result;

    try {
        $stm = $conn->prepare("SELECT * FROM public.nama_mi");
        $stm->execute();
        $result = $stm->fetchAll();
    } catch (PDOException $e) {
        echo "Error";
    }
}

function harga()
{
    global $conn;
    global $res;

    try {
        $stm = $conn->prepare("SELECT * FROM public.harga");
        $stm->execute();
        $res = $stm->fetchAll();
    } catch (PDOException $e) {
        echo "Error";
    }
}

f_ConnMysqliObj();
nama_minuman();
harga();

if (isset($_POST["submit"])) {
    f_ConnMysqliObj();
    insertData($_POST);
    closeConnectionPDO();
    // print_r($_POST);
}


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Jumbotron Template · Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* .content>div {
            display: inline-block;
            /* margin-left: 10px; */
        /* margin-bottom: 35px;
        margin-right: 25px; */
        /* } */

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Custom styles for this template -->
    <!-- <link href="jumbotron.css" rel="stylesheet"> -->
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#">KEDAI KITA</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="kedai.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Manage</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="home.php">Makanan</a>
                        <a class="dropdown-item" href="minuman.php">Minuman</a>
                        <!-- <a class="dropdown-item" href="#">Order</a> -->
                    </div>
                </li>
            </ul>
            <!-- <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search Products" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form> -->
        </div>
    </nav>

    <main role="main" class="container ">

        <div class="my-5">
            <!-- <form action=""></form> -->
            <br>
            <div><center>  <img src="logo2.png" width="150xp"></center></div>
            <br>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">MINUMAN</a>
                    
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <br>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Nama Minuman</label>
                                <select id="inputState" name="nama_mi" class="form-control">
                                    <?php foreach ($result as $row) : ?>
                                        <option value="<?= $row["mi_id"]; ?>"><?= $row["nama_mi"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <!-- <input type="password" class="form-control" id="inputPassword4"> -->
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Harga Minuman</label>
                                <select id="inputState" name="harga_mi" class="form-control">
                                    <?php foreach ($res as $row) : ?>
                                        <option value="<?= $row["harga_id"]; ?>"><?= $row["jml_harga"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputCity">QTY</label>
                                <input type="text" class="form-control" id="inputCity" name="qty">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputState">Tanggal Dibuat</label>
                                <input type="date" class="form-control" id="inputCity" name="create_date">
                            </div>
                        </div>
                        
                        <input type="submit" class="btn btn-primary" name="submit" value="Submit" />
                    </form>

                    <!-- <br> -->
                    <hr>
                    <!-- <br> -->

                    <div class="form-row ">
                        <div class="form-group col-md-4">
                            <input type="email" class="form-control " placeholder="Search Keyword" id="inputEmail4">
                        </div>
                    </div>

                    <table class="table table-sm ">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nama Minuman</th>
                                <th scope="col">Harga Minuman</th>
                                <th scope="col">QTY</th>
                                <th scope="col">Total</th>
                                <th scope="col">Tanggal Dibuat</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            f_ConnMysqliObj();
                            $stm = $conn->prepare("SELECT  c.nama_mi, b.jml_harga, a.qty, a.create_date
                            FROM public.minuman a 
                            INNER JOIN public.harga b 
                                        ON a.harga_mi = b.harga_id
                                        INNER JOIN public.nama_mi c
                                        ON a.mi_id = c.mi_id ");

                            $stm->execute();
                            $result = $stm->fetchAll();

                            

                            foreach ($result as $row) : ?>
                                <tr>
                                    <td><?= $cntrid; ?></td>
                                    <td><?= $row["nama_mi"]; ?></td>
                                    <td><?= $row["jml_harga"]; ?></td>
                                    <td><?= $row["qty"]; ?></td>
                                    <td><?= $row["jml_harga"]*$row["qty"]; ?></td>
                                    <td><?= $row["create_date"]; ?></td>
                                    
                                    <td><a href="updatemanage.php?product_id=<?= $row["product_id"]; ?>">Update</a> ||
                                        <a href="delete_minuman.php?mi_id=<?= $row["mi_id"]; ?>" onclick="return confirm('Yakin Delete')">Delete</a></td>
                                </tr>
                                <?php $cntrid++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- <-- productdetiles -->
                
            </div>

    </main><!-- /.container -->

    <footer class="container">
        <p>&copy; Company 2017-2019</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script src="/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')
    </script>
    <script src="assets/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
</body>

</html>