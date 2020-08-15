<?php
include 'func.php';

//Konek ke MySql
$pdo = pdo_connect_mysql();
//Get info halaman dari perintah GET url
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
//tentukan jumlah records dalam setiap halaman
$records_per_page = 10;
//Blok eksekusi SQL
$stmt = $pdo->prepare("SELECT * FROM keuangan WHERE tipe = 'Pemasukan' ORDER BY id LIMIT :current_page, :record_per_page");
$stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
//fetch seleuruh record
$logKeuangan = $stmt->fetchAll(PDO::FETCH_ASSOC);
//Akhir blok eksekusi SQL
//dapatkan seluruh total kuantitas log dalama tabel, sehingga bisa ditentukan tombol next atau lanjut harus diposisikan/tampilkan
$num_log = $pdo->query('SELECT COUNT(*) FROM keuangan')->fetchColumn();
?>
<?= template_header('Pemasukan') ?>
<div class="container">
    <h2 class="mb-3 mt-3">Log Data Pemasukan Keuangan</h2>
    <form class="form-inline my-2 ml-2 my-lg-0" action="readPemasukan.php" method="GET">
        <label for="filterBulan">Filter Bulan</label>
        <select class="form-control" id="filterBulan" name="bulan">
            <option selected>Pilih Bulan</option>
            <option value="Januari">Januari</option>
            <option value="Februari">Februari</option>
            <option value="Maret">Maret</option>
            <option value="April">April</option>
            <option value="Mei">Mei</option>
            <option value="Juni">Juni</option>
            <option value="Juli">Juli</option>
            <option value="Agustus">Agustus</option>
            <option value="September">September</option>
            <option value="Oktober">Oktober</option>
            <option value="November">November</option>
            <option value="Desember">Desember</option>
        </select>
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    <?php
    if (isset($_GET['bulan'])) {
        $filter = $_GET['bulan'];
        echo "Menampilkan data pemasukan pada bulan : " . "<b>" . $filter . "</b>";
    }
    ?>
    <div class="table-responsive mt-3">
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
                    <!-- <td scope="col">Aksi</td> -->
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_GET['bulan'])) {
                    $cari = $_GET['bulan'];
                    $stmt = $pdo->prepare("SELECT * FROM keuangan WHERE tipe = 'Pemasukan' AND bulan = '$cari' ORDER BY log DESC LIMIT :current_page, :record_per_page");
                    $stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
                    $stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
                    $stmt->execute();
                    //fetch seleuruh record
                    $logKeuangan = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $stmt = $pdo->prepare("SELECT * FROM keuangan WHERE tipe = 'Pemasukan' ORDER BY id LIMIT :current_page, :record_per_page");
                    $stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
                    $stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
                    $stmt->execute();
                    //fetch seleuruh record
                    $logKeuangan = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                ?>
                <?php foreach ($logKeuangan as $log) : ?>

                    <tr>
                        <td scope="row"><?= $log['id'] ?></td>
                        <td><?= $log['admin'] ?></td>
                        <td><?= $log['tipe'] ?></td>
                        <td><?= $log['tanggal'] ?></td>
                        <td><?= $log['jumlah'] ?></td>
                        <td><?= $log['keterangan'] ?></td>
                        <td><?= $log['log'] ?></td>
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