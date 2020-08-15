<?php
$link = mysqli_connect('localhost', 'root', '', 'db_em');
function pdo_connect_mysql()
{
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'db_em';
    try {
        return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
        // If there is an error with the connection, stop the script and display the error.
        exit('Failed to connect to database!');
    }
}
function template_header($title)
{
    echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <title>$title</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link href="bs/css/bootstrap.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
    <body>
    <nav class="navbar navbar-dark bg-info">
        <a class="navbar-brand" href="index.php">Log Keuangan</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Beranda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="read.php">Buat atau Edit Log</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="readPemasukan.php">Log Pemasukan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="readPengeluaran.php">Log Pengeluaran</a>
            </li>
        </ul>
        </div>
    </nav>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
EOT;
}
function template_login()
{
    echo <<<EOT
    <div class="card border-primary mb-3" style="max-width: 18rem;">
    <div class="card-header">Login</div>
        <div class="card-body text-primary">
        <h5 class="card-title">Sudah Login</h5>
        <p class="card-text">Anda sudah login klik tautan untuk membuat/mengedit/menghapus catatan.</p>
        <a href="read.php" class="btn btn-primary">Buat LOG</a>
        </div>
    </div>
    EOT;
}
function template_footer()
{
    echo <<<EOT
    </body>
</html>
EOT;
}
