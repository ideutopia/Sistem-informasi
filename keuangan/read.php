<?php
//cek session
session_start();
if ($_SESSION["loggedin"]) {
    //echo "Selamat Datang";
    $greeting = $_SESSION["username"];
    //echo $_SESSION["username"];
    $date1 = strtotime("now") . "<br>";
} else {
    echo "<script>alert('Silahkan Login terlebih dahulu!');
    document.location.href = 'index.php';</script>";
    die();
}
include 'func.php';
//Konek ke MySql
$pdo = pdo_connect_mysql();
//Get info halaman dari perintah GET url
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
//tentukan jumlah records dalam setiap halaman
$records_per_page = 10;
//Blok eksekusi SQL
$stmt = $pdo->prepare('SELECT * FROM keuangan ORDER BY log DESC LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
//fetch seleuruh record
$logKeuangan = $stmt->fetchAll(PDO::FETCH_ASSOC);
//Akhir blok eksekusi SQL
//dapatkan seluruh total kuantitas log dalama tabel, sehingga bisa ditentukan tombol next atau lanjut harus diposisikan/tampilkan
$num_log = $pdo->query('SELECT COUNT(*) FROM keuangan')->fetchColumn();
?>
<?= template_header('Read') ?>
<div class="container">
    <h2>Log Data dan perubahan</h2>
    <a href="create.php" class="btn btn-primary mb-3">Buat LOG</a>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <td scope="col">#</td>
                    <td scope="col">Admin</td>
                    <td scope="col">Tipe</td>
                    <td scope="col">Tanggal</td>
                    <td scope="col">Jumlah</td>
                    <td scope="col">Keterangan</td>
                    <td scope="col">Waktu dibuat</td>
                    <td scope="col">Aksi</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logKeuangan as $log) : ?>

                    <tr>
                        <td scope="row"><?= $log['id'] ?></td>
                        <td><?= $log['admin'] ?></td>
                        <td><?= $log['tipe'] ?></td>
                        <td><?= $log['tanggal'] ?></td>
                        <td><?= $log['jumlah'] ?></td>
                        <td><?= $log['keterangan'] ?></td>
                        <td><?= $log['log'] ?></td>
                        <td class="actions">
                            <a href="update.php?id=<?= $log['id'] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                            <a href="delete.php?id=<?= $log['id'] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="pagination">
        <?php if ($page > 1) : ?>
            <a href="read.php?page=<?= $page - 1 ?>"><i class="fas fa-angle-double-left fa-lg"></i></a>
        <?php endif; ?>
        <?php if ($page * $records_per_page < $num_log) : ?>
            <a href="read.php?page=<?= $page + 1 ?>"><i class="fas fa-angle-double-right fa-lg"></i></a>
        <?php endif; ?>
    </div>
</div>
<?= template_footer() ?>