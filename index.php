<?php
session_start();
include 'config/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', 'sans-serif';
        }

        section {
            display: flex;
            justify-content: center;
            width: 100%;
            height: 100vh;
            background: url('bg2.jpg') no-repeat;
            background-size: cover;
            align-items: center;
            background-size: cover;
            background-position: center;
            animation: animateBg 5s linear infinite;
        }

    

        .login-box {
            position: relative;
            width: 400px;
            height: 450px;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, .5);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(5px);
        }

        h2 {
            font-size: 2em;
            color: #fff;
            text-align: center;
        }

        .input-box {
            position: relative;
            width: 300px;
            margin: 30px;
            border-bottom: 2px solid #fff;
        }

        .input-box label {
            position: absolute;
            top: 50%;
            left: 5px;
            transform: translateY(-50%);
            font-size: 1em;
            color: #fff;
            pointer-events: none;
            transition: .6s;
        }

        .input-box input:focus~label,
        .input-box input:valid~label {
            top: -5px;
        }

        .input-box input {
            width: 100%;
            height: 50px;
            background: transparent;
            border: none;
            outline: none;
            font-size: 1em;
            color: #fff;
            padding: 0 35px 0 5px;
        }

        .input-box .icon {
            position: absolute;
            right: 8px;
            color: #fff;
            font-size: 1.2em;
            line-height: 57px;
        }

        .remember-forgot {
            margin: -15px 0 15px;
            font-size: .9em;
            color: #fff;
            display: flex;
            justify-content: space-between;
        }

        .remember-forgot label input {
            margin-right: 3px;
        }

        .remember-forgot a {
            color: #fff;
            text-decoration: none;
        }

        .remember-forgot a:hover {
            text-decoration: none;
        }

        button {
            width: 100%;
            height: 40px;
            border: none;
            outline: none;
            border-radius: 40px;
            cursor: pointer;
            font-size: 1em;
            color: #000;
            font-weight: 500;
        }

        .Register-link {
            font-size: .9em;
            color: #fff;
            text-align: center;
            margin: 25px 0 10px;
        }

        .Register-link p a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link p a:hover {
            text-decoration: underline;
        }

        @media (max-width: 360px) {
            .login-box {
                width: 100%;
                height: 100vh;
                border: none;
                border-radius: 0%;
            }

            .input-box {
                width: 290px;
            }
        }
    </style>
</head>
<body>
    <section>
        <div class="login-box">
            <form action="" method="POST">
                <h2>Login</h2>
                <div class="input-box">
                    <span class="icon"><ion-icon name="person"></ion-icon></span>
                    <input type="text" name="username" id="username" required>
                    <label> Username </label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" name="password" id="password" required>
                    <label>Password</label>
                </div>
                <div class="input-box">
                        
                        <select class="form-control" name="level">
                            <option>Level</option>
                            <option value="1">Dosen</option>
                            <option value="2">Mahasiswa</option>
                            <option value="3">Kepala Prodi</option>
                            <option value="4">Dosen PA</option>
                        </select>
                    </div>
                <div class="remember-forgot">
                    <label><input type="checkbox">Remember Me</label>
                </div>
                
                <button type="submit" class="btn btn-primary">
                                Login
                            </button>
                
                <div class="Register-link">
                    <p>Don't have an account? <a href="#">Register</a></p>
                </div>
            </form>
        </div>
    </section>

    <?php 
				if ($_SERVER['REQUEST_METHOD']=='POST') {
					$level = $_POST['level'];
					$pass= sha1($_POST['password']);
					if ($level==1) {
						// Guru
						$sqlCek = mysqli_query($con,"SELECT * FROM tb_guru WHERE nip='$_POST[username]' AND password='$pass' AND status='Y'");
						$jml = mysqli_num_rows($sqlCek);
						$d = mysqli_fetch_array($sqlCek);
						
						if ($jml > 0) {
						$_SESSION['guru']= $d['id_guru'];
						echo "
						<script type='text/javascript'>
						setTimeout(function () { 
						
						swal('($d[nama_guru]) ', 'Login berhasil', {
						icon : 'success',
						buttons: {        			
						confirm: {
						className : 'btn btn-success'
						}
						},
						});    
						},10);  
						window.setTimeout(function(){ 
						window.location.replace('./guru/');
						} ,3000);   
						</script>";					
						
						}else{
						echo "
						<script type='text/javascript'>
						setTimeout(function () { 
						
						swal('Sorry!', 'Username / Password Salah', {
						icon : 'error',
						buttons: {        			
						confirm: {
						className : 'btn btn-danger'
						}
						},
						});    
						},10);  
						window.setTimeout(function(){ 
						window.location.replace('./');
						} ,3000);   
						</script>";
						}
						
					}elseif ($level==2) {
						// Mahasiswa
								$sqlCek = mysqli_query($con,"SELECT * FROM tb_siswa WHERE nis='$_POST[username]' AND password='$pass' AND status='1'");
								$jml = mysqli_num_rows($sqlCek);
								$d = mysqli_fetch_array($sqlCek);
								
								if ($jml > 0) {
								$_SESSION['siswa']= $d['id_siswa'];
								
								
								echo "
								<script type='text/javascript'>
								setTimeout(function () { 
								
								swal('($d[nama_siswa]) ', 'Login berhasil', {
								icon : 'success',
								buttons: {        			
								confirm: {
								className : 'btn btn-success'
								}
								},
								});    
								},10);  
								window.setTimeout(function(){ 
								window.location.replace('./siswa/');
								} ,3000);   
								</script>";
								
								}else{
								echo "
								<script type='text/javascript'>
								setTimeout(function () { 
								
								swal('Salah Kocak!', 'Username / Password Salah', {
								icon : 'error',
								buttons: {        			
								confirm: {
								className : 'btn btn-danger'
								}
								},
								});    
								},10);  
								window.setTimeout(function(){ 
								window.location.replace('./');
								} ,3000);   
								</script>";
								}

								
								}elseif ($level==3) {
						// Kepsek
								$sqlCek = mysqli_query($con,"SELECT * FROM tb_kepsek WHERE nip='$_POST[username]' AND password='$pass' AND status='Y'");
								$jml = mysqli_num_rows($sqlCek);
								$d = mysqli_fetch_array($sqlCek);
								
								if ($jml > 0) {
								$_SESSION['kepsek']= $d['id_kepsek'];
								
								
								echo "
								<script type='text/javascript'>
								setTimeout(function () { 
								
								swal('($d[nama_kepsek]) ', 'Login berhasil', {
								icon : 'success',
								buttons: {        			
								confirm: {
								className : 'btn btn-success'
								}
								},
								});    
								},10);  
								window.setTimeout(function(){ 
								window.location.replace('./kepsek/');
								} ,3000);   
								</script>";
								
								}else{
								echo "
								<script type='text/javascript'>
								setTimeout(function () { 
								
								swal('Sorry!', 'Username / Password Salah', {
								icon : 'error',
								buttons: {        			
								confirm: {
								className : 'btn btn-danger'
								}
								},
								});    
								},10);  
								window.setTimeout(function(){ 
								window.location.replace('./');
								} ,3000);   
								</script>";
								}

					}else{
						echo "Tidak ada level yg dipilih";
					}

				}
				?>
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>

    <!--===============================================================================================-->
    <script src="assets/_login/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="assets/_login/vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="assets/_login/vendor/bootstrap/js/popper.js"></script>
    <script src="assets/_login/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="assets/_login/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="assets/_login/vendor/daterangepicker/moment.min.js"></script>
    <script src="assets/_login/vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="assets/_login/vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->

    <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script src="assets/_login/js/main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
