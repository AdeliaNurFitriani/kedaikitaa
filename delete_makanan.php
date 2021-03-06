
<?php

//global con
$conn;
//set connection PDO
function f_setConnectionPDO()
{
    global $servername, $username, $password, $dbname;

    //get conn global
    global $conn;

    $dbname = "kedai";
    $servername = "localhost";
    $dsn = "pgsql:host=$servername;dbname=$dbname";
    $username = "postgres";
    $password = "adelia";
    //get result global
    global $result;

    //set connetion
    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Success" . "<br>";
    } catch (PDOException $e) {
        //throw $th;
        echo "Error : " . $e->getMessage();
    }
}


function f_setCloseConnectionPDO()
{

    global $conn;
    $conn = null;
}

function deleteData($dataget)
{
    global $conn;
    global $result;
    $id = $dataget["makanan_id"];
    try {

        $stm = $conn->prepare("DELETE FROM public.makanan
                WHERE makanan_id = '$id' ");

        $stm->execute();
        echo "<script>alert('Ok,Berhasil Dihapus');
        document.location.href = 'home.php'
        </script>";
    } catch (PDOException $e) {
        // throw $th;
         echo "Error : " . $e->getMessage();
        echo "<script>alert('Gagal delete ');
    document.location.href = 'home.php'
    </script>";
    }
}



if (isset($_GET["makanan_id"])) {
    echo $_GET["makanan_id"];
    f_setConnectionPDO();
    deleteData($_GET);
    f_setCloseConnectionPDO();
    print_r($row);
    print_r($_POST);
} else {
    echo "silahkan pilih baris data";
}
?>
