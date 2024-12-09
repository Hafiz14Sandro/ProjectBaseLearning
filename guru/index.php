
<?php
@session_start();
 include '../config/db.php';

if (!isset($_SESSION['guru'])) {
?> <script>
    alert('Maaf ! Anda Belum Login !!');
    window.location='../user.php';
 </script>
<?php
}
 ?>


<?php
// Memulai session
session_start();
include '../config/db.php';

// Cek apakah guru sudah login
$id_login = @$_SESSION['guru'];
if (!$id_login) {
    echo "<script>
            alert('Maaf ! Anda Belum Login !!');
            window.location='../user.php';
          </script>";
    exit();
}

// Menggunakan prepared statement untuk keamanan
$stmt = $con->prepare("SELECT * FROM tb_guru WHERE id_guru = ?");
$stmt->bind_param("i", $id_login);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

// Menampilkan data mengajar guru menggunakan prepared statement
$query = "
    SELECT tb_mengajar.*, tb_master_mapel.*, tb_mkelas.*, tb_semester.*, tb_thajaran.*
    FROM tb_mengajar
    INNER JOIN tb_master_mapel ON tb_mengajar.id_mapel = tb_master_mapel.id_mapel
    INNER JOIN tb_mkelas ON tb_mengajar.id_mkelas = tb_mkelas.id_mkelas
    INNER JOIN tb_semester ON tb_mengajar.id_semester = tb_semester.id_semester
    INNER JOIN tb_thajaran ON tb_mengajar.id_thajaran = tb_thajaran.id_thajaran
    WHERE tb_mengajar.id_guru = ? AND tb_thajaran.status = 1
";
$stmt_mengajar = $con->prepare($query);
$stmt_mengajar->bind_param("i", $data['id_guru']);
$stmt_mengajar->execute();
$mengajar = $stmt_mengajar->get_result();
$stmt_mengajar->close();


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Guru | Aplikasi Presensi</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	
	<!-- Fonts and icons -->
	<script src="../assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../assets/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/atlantis.min.css">

</head>
<style>
  .multiline-text {
    white-space: pre-line;
  }
</style>
<body>
	<div class="wrapper">
		<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" data-background-color="red">
				
				<a href="index.php" class="logo">
					<b class="text-white">Presensi Mahasiswa</b>
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="icon-menu"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
				<div class="nav-toggle">
					<button class="btn btn-toggle toggle-sidebar">
						<i class="icon-menu"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg" data-background-color="red2">
				
				<div class="container-fluid">
					<div class="collapse" id="search-nav">
						<form class="navbar-left navbar-form nav-search mr-md-3">
							<div class="input-group">
								<div class="input-group-prepend">
									<button type="submit" class="btn btn-search pr-1">
										<i class="fa fa-search search-icon"></i>
									</button>
								</div>
								<input type="text" placeholder="Search ..." class="form-control">
							</div>
						</form>
					</div> 	
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						 <li class="nav-item toggle-nav-search hidden-caret">
							<a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
								<i class="fa fa-search"></i>
							</a>
						</li>
						
						
						
						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<div class="avatar-sm">
									<img src="../assets/img/user/<?=$data['foto'] ?>" alt="..." class="avatar-img rounded-circle">
								</div>
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<div class="dropdown-user-scroll scrollbar-outer">
									<li>
										<div class="user-box">
											<div class="avatar-lg"><img src="../assets/img/user/<?=$data['foto'] ?>" alt="image profile" class="avatar-img rounded"></div>
											<div class="u-text">
												<h4><?=$data['nama_guru'] ?></h4>
												<p class="text-muted"><?=$data['email'] ?></p>
												<a href="?page=jadwal" class="btn btn-xs btn-secondary btn-sm">Jadwal Mengajar</a>
											</div>
										</div>
									</li>
									<li>
									
										<a class="dropdown-item" href="?page=akun" >Akun Saya</a>
										
										<a class="dropdown-item" href="logout.php">Logout</a>
									</li>
								</div>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<!-- End Navbar -->
		</div>

		<!-- Sidebar -->
		<div class="sidebar sidebar-style-2">			
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<img src="../assets/img/user/<?=$data['foto'] ?>" alt="..." class="avatar-img rounded-circle">
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<!-- nama user -->
								<span>
									<?=$data['nama_guru'] ?>
									<span class="user-level"><?=$data['nip'] ?></span>
									<span class="caret"></span>
								</span>
							</a>
							<div class="clearfix"></div>

							<div class="collapse in" id="collapseExample">
								<ul class="nav">
									<li>
										<a href="?page=akun">
											<span class="link-collapse">Akun Saya</span>
										</a>
									</li>
									
								</ul>
							</div>
						</div>
					</div>
					<ul class="nav nav-primary">
						<li class="nav-item active">
							<a href="index.php" class="collapsed">
								<i class="fas fa-home"></i>
								<p>Dashboard</p>
							</a>							
						</li>
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class=""></i>
							</span>
							<h4 class="text-section">Main Utama</h4>
						</li>
						<li class="nav-item">
							<a href="?page=jadwal">
								<i class="fas fa-clipboard-check"></i>
								<p>Jadwal Mengajar</p>
							</a>
						
						</li>
						<li class="nav-item">
							<a data-toggle="collapse" href="#sidebarLayouts">
								<i class="fas fa-clipboard-list
"></i>
								<p>Presensi</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarLayouts">
								<ul class="nav nav-collapse">
									<?php


									foreach ($mengajar as $dm) { ?>
									<li>
										<a href="?page=absen&pelajaran=<?=$dm['id_mengajar'] ?> ">
											<span class="sub-item"><!-- <?=strtoupper($dm['mapel']); ?> -->KELAS (<?=strtoupper($dm['nama_kelas']); ?>)</span>
										</a>
									</li>
								<?php } ?>
								</ul>
							</div>
						</li>
							<li class="nav-item">
							<a data-toggle="collapse" href="#rekapAbsen">
								<i class="fas fa-list-alt"></i>
								<p>Rekap Absen</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="rekapAbsen">
								<ul class="nav nav-collapse">
									<?php


									foreach ($mengajar as $dm) { ?>
									<li>
										<a href="?page=rekap&pelajaran=<?=$dm['id_mengajar'] ?> ">
											<span class="sub-item"><!-- <?=strtoupper($dm['mapel']); ?> -->KELAS (<?=strtoupper($dm['nama_kelas']); ?>)</span>
										</a>
									</li>
								<?php } ?>
								</ul>
							</div>
						</li>
						<li class="nav-item active mt-3">
							<a href="logout.php" class="collapsed">
								<i class="fas fa-arrow-alt-circle-left"></i>
								<p>Logout</p>
							</a>							
						</li>
	
					
						
				</div>
			</div>
		</div>
		<!-- End Sidebar -->

		<div class="main-panel">
			<div class="content">

				<!-- Halaman dinamis -->
				<?php 
				error_reporting();
				$page= @$_GET['page'];
				$act = @$_GET['act'];

				if ($page=='absen') {
					if ($act=='') {
						include 'modul/absen/absen_kelas.php';
					}elseif ($act=='surat_view') {
						include 'modul/absen/view_surat_izin.php';
					}elseif ($act=='konfirmasi') {
						include 'modul/absen/konfirmasi_izin.php';
					}elseif ($act=='update') {
						include 'modul/absen/absen_kelas_update.php';
					}					
				}elseif ($page=='rekap') {
					if ($act=='') {
						include 'modul/rekap/rekap_absen.php';

					}					
				}elseif ($page=='jadwal') {
					if ($act=='') {
						include 'modul/jadwal/jadwal_megajar.php';

					}					
				}elseif ($page=='akun') {
					include 'modul/akun/akun.php';
				}

				elseif ($page=='') {
					include 'modul/home.php';
				}else{
					echo "<b>Tidak ada Halaman</b>";
				}


				 ?>


				<!-- end -->


				
			</div>
		<footer class="footer">
				<div class="container">
					<div class="copyright ml-auto">
						&copy; <?php echo date('Y');?> Absensi Mahasiswa Teknologi Informasi (<a href="index.php">PBL Kelompok 1</a> | 2023)
					</div>				
				</div>
			</footer>
		</div>
		
	
	</div>
	<!--   Core JS Files   -->
	<script src="../assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="../assets/js/core/popper.min.js"></script>
	<script src="../assets/js/core/bootstrap.min.js"></script>

	<!-- jQuery UI -->
	<script src="../assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="../assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

	<!-- jQuery Scrollbar -->
	<script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>


	<!-- Datatables -->
	<script src="../assets/js/plugin/datatables/datatables.min.js"></script>



	<!-- Sweet Alert -->
	<script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>

	<!-- Atlantis JS -->
	<script src="../assets/js/atlantis.min.js"></script>


	

</body>
</html>