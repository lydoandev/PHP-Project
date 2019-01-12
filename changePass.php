<?php 
	session_start();
	include "connectMySQL.php";
	$errConfirm = "";
	$errOldPass = "";
	if(isset($_POST['updatePass'])) {
		$user = new user();
		$errOldPass = $user->updatePassword($connect, $_SESSION['username'], $_POST['oldPassword'], $_POST['newPassword']);
		if ($_POST['newPassword'] != $_POST['confirmPassword']) {
			$errConfirm = "* Nhập Lại Mật Khẩu Không Chính Xác";
		}
	}

	
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style>
		
	</style>
</head>
<body> 
<?php include "header.php" ;
?>
<div class="profile">
	<div class="container">
		<div class="content">
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
				<div class="acount">
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
							<img src="<?php echo $avatar ?>">
						</div>
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
							<p style="padding-top: 10px;"><b><?php echo $username; ?></b></p>
							<span><i class="fa fa-pencil-square-o "></i></span><a href="" style="text-decoration: none">Sửa Hồ Sơ</a>
						</div>
					</div>
				</div>
				<hr>
				<ul>
					<li class="dropdown">
						<a href="profile.php"><span><i class="fa  fa-user-circle-o" style="color: #ffff1a;"></i></span> Tài khoản của tôi</a>
	          <ul class="">
	            <li><a href="profile.php">Hồ sơ</a></li>
	            <li><a href="changePass.php" class="active" >Đổi mật khẩu</a></li>
	          </ul>
					</li>
					<li><a href="order.php"><span><i class="fa fa-list-alt" style="color: #3399ff;"></i></span> Đơn hàng</a></li>
					<li><a href="#"><span><i class="fa fa-bell-o" style="color: #ff0000;"></i></span> Thông báo</a></li>
				</ul>
			</div>
			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
				<div class="info">
					<h4>Đổi Mật Khẩu</h4>
					Để Bảo Mật Tài Khoản Vui Lòng Không Chia Sẻ Mật Khẩu Với Người Khác
					<hr>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						
					</div>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
						<form method="POST" action="">
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-2 home">
								Mật Khẩu Cũ:
							</div>
							<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 home">
								<input type="password" name="oldPassword" class="form-control" required>
								<p style="color: red;"><?php echo $errOldPass; ?></p>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 home">
								Mật Khẩu Mới:
							</div>
							<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 home">
								<input type="password" name="newPassword" class="form-control" required>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 home">
								Xác Nhận Mật Khẩu Mới:
							</div>
							<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 home">
								<input type="password" name="confirmPassword" class="form-control" required>
								<p style="color: red;"><?php echo $errConfirm; ?></p>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 home">
								<button class="btn" name="updatePass">UPDATE</button>
							</div>
						</form>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
						
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
<?php include "footer.php" ;?>
</body>
</html>