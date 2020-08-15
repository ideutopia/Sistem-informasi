<?php
// KONEKSI KE DATABASE
$koneksi = mysqli_connect("localhost", "root", "") or die("Tidak bisa terhubung ke Database!");
mysqli_select_db($koneksi, 'db_em') or die("Tidak ada Database yang dipilih!");
?>
 
<?php
// PROSES LOGIN
if ($_POST['login']) {
    $user    = $_POST['username'];
    $pass    = $_POST['password'];

    if ($user && $pass) {
        $cek_db    = "SELECT * FROM user WHERE username='$user'";
        $query    = mysqli_query($koneksi, $cek_db);
        if (mysqli_num_rows($query) != 0) {
            $row = mysqli_fetch_assoc($query);
            $db_user = $row['username'];
            $db_pass = $row['password'];

            if ($user == $db_user && $pass == $db_pass) {
                echo '<p><b>Anda berhasil Login!</b></p>';
                session_start();
                //data sesssion
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $username;
                header("Location: read.php");

                die();
            } else {
                echo '<p>Username dan Password tidak cocok!</p>';
                echo "<script>alert('Username dan Password tidak cocok !');
                        document.location.href = 'read.php';</script>";
            }
        } else {
            echo '<p>Username tidak ada dalam Database!</p>';
        }
    } else {
        echo '<p>Username dan Password masih kosong!</p>';
    }
}
?>