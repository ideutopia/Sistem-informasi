<?php
//Cek Session
session_start();
include 'func.php';
$pdo = pdo_connect_mysql();
$sqlPengeluran = "SELECT SUM(jumlah) FROM keuangan WHERE tipe = 'Pengeluaran'";
$sqlPemasukan = "SELECT SUM(jumlah) FROM keuangan WHERE tipe = 'Pemasukan'";
$fetchPengeluran  = mysqli_query($link, $sqlPengeluran);
$fetchPemasukan = mysqli_query($link, $sqlPemasukan);
$pemasukan = mysqli_fetch_array($fetchPemasukan);
$pengeluaran = mysqli_fetch_array($fetchPengeluran);
?>
<?= template_header('Home') ?>

<div class="container mt-3 mb-2">
    <h1 class="mb-3">Menu</h1>
    <div class="card-deck">
        <div class="card border-success mb-3" style="max-width: 18rem;">
            <div class="card-header">Pemasukan</div>
            <div class="card-body text-success">
                <h5 class="card-title">Catatan Pemasukan</h5>
                <p class="card-text">Klik tautan dibawah untuk melihat daftar pemasukan keuangan</p>
                <a href="readPemasukan.php" class="btn btn-success">GO</a>
            </div>
        </div>
        <div class="card border-danger mb-3" style="max-width: 18rem;">
            <div class="card-header">Pengeluaran</div>
            <div class="card-body text-danger">
                <h5 class="card-title">Catatan Pengeluaran</h5>
                <p class="card-text">Klik tautan dibawah untuk melihat daftar pengeluaran keuangan</p>
                <a href="readPengeluaran.php" class="btn btn-danger">GO</a>
            </div>
        </div>
        <?php
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            echo template_login();
        } else {
            echo <<< EOT
                        <div class="card border-warning mb-3" style="max-width: 18rem;">
                            <div class="card-header">Login</div>
                            <div class="card-body text-warning">
                                <h5 class="card-title">Belum Login</h5>
                                <p class="card-text">Masuk untuk membuat/mengedit/menghapus catatan.</p>
                                <a class="btn btn-warning" data-toggle="modal" data-target="#staticBackdrop">Masuk</a>
                            </div>
                        </div>
        EOT;
        }
        ?>
    </div>
    <h3>Ringkasan Keuangan</h3>
    <table class="table table-bordered">
        <thead>
        </thead>
        <tbody>
            <tr>
                <th scope="row">Total Pemasukan Keseluruhan: </th>
                <td>Rp. <?php echo $pemasukan[0] ?></td>

            </tr>
            <tr>
                <th scope="row">Total Pengeluaran Keseluruhan: </th>
                <td>Rp. <?php echo $pengeluaran[0] ?></td>
            </tr>
            <tr>
                <th scope="row">Total Saldo Keseluruhan: </th>
                <td>Rp. <?php echo $pemasukan[0] - $pengeluaran[0] ?></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Username</label>
                        <input type="text" class="form-control" id="username" name="username" aria-describedby="usernameHelp" required>
                        <small id="usernameHelp" class="form-text text-muted">Username Biro Keuangan</small>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <input type="submit" class="btn btn-warning" name="login" value="Masuk">
                </form>
            </div>
        </div>
    </div>
</div>

<?= template_footer() ?>