<?php 
	session_start();
	include "function.php";
	$_SESSION['page'] = "profile";
	$user = new user();
	$info = $user->showInfo($connect, $_SESSION['username']);
	$_SESSION['avatar_url'] = $info['avatar_url'];
	$_SESSION['last_url'] = $_SERVER['REQUEST_URI'];
	$errConfirm = "";
	$errOldPass = "";
	if(isset($_POST['updatePass'])) {
		$user = new user();

		if ($_POST['newPassword'] != $_POST['confirmPassword']) {
			echo "<script> alert('Nhập Lại Mật Khẩu Không Chính Xác');</script>";
			$errConfirm = "* Nhập Lại Mật Khẩu Không Chính Xác";
		}else {
			$errOldPass = $user->updatePassword($connect, $_SESSION['username'], $_POST['oldPassword'], $_POST['newPassword']);
			if ($errOldPass !="") {
				echo "<script> alert('Mật Khẩu Cũ Không Chính Xác');</script>";
			}
		}
	}

	if(isset($_POST['update'])) {
		$avatar_url = chooseImage("avatars", "file");
		$user = new user();
		$user->updateInfo($connect, $_SESSION['username'], $avatar_url, $_POST['last_name'], $_POST['first_name'], $_POST['email'], $_POST['address'], $_POST['phone'], $_POST['gender'], $_POST['birthday']);
	}

	if (isset($_GET['order_id'])) {
		deleteOrdering($connect, $_GET['order_id']);
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
							<img src="<?php echo $info['avatar_url']; ?>">
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
	            <li><a href="#profile" data-toggle="tab" aria-expanded="true" class="active">Hồ sơ</a></li>
	            <li><a href="#changePass" data-toggle="tab" aria-expanded="true">Đổi mật khẩu</a></li>
	          </ul>
					</li>
					<li><a href="#order" data-toggle="tab" aria-expanded="true"><span><i class="fa fa-list-alt" style="color: #3399ff;"></i></span> Đơn hàng</a></li>
					<li><a href="#" data-toggle="tab" aria-expanded="true"><span><i class="fa fa-bell-o" style="color: red;"></i></span> Thông Báo</a></li>
				</ul>
			</div>
			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
				<div class="info">
					<div class="tab-content">
						<div id="profile" class="tab-pane active">
              <h4>Hồ Sơ Của Tôi</h4>
							Quản Lí Thông Tin Hồ Sơ Để Bảo Mật
							<hr>
							<form method="POST" action="" enctype="multipart/form-data">
								<div class="row">
									<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7" style="border-right: 1px solid #d9d9d9;">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 home">
											<input type="text" name="last_name" class="form-control" placeholder="Họ" value="<?php echo $info['last_name'] ;?>" required>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 home">
											<input type="text" name="first_name" class="form-control" placeholder="Tên" value="<?php echo $info['first_name'] ;?>" required>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 home">
											<input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $info['email'] ;?>" required>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 home">
											<input type="text" name="address" class="form-control" placeholder="Địa chỉ" value="<?php echo $info['address'] ;?>" required>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 home">
											<input type="text" name="phone" class="form-control" placeholder="Số điện thoại" value="<?php echo $info['phone'] ;?>" required>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 home">
											<input type="radio" name="gender" value="Male" <?php if ($info['gender']=="Male") { echo "checked";} ?> >Male
											<input type="radio" name="gender" value="Female" <?php if ($info['gender']=="Female") { echo "checked";} ?> >Female
										</div>
										<div class="col-md-12 home">
											<input type="date" name="birthday" class="form-control" value="<?php echo $info['birthday']; ?>">
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 home">
											<button class="btn" name="update">UPDATE</button>
										</div>
									</div>
									<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
										<img class="avatar" src="<?php echo $info['avatar_url']; ?>">
										<input type="file" name="file" class="form-control home">
									</div>
								</div>
							</form>
          	</div>

	          <div id="changePass" class="tab-pane fade" style="height: 500px;">
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

	          <div id="order" class="tab-pane fade">
	            <div class="tablist row">
		            <ul role="tablist" class="nav nav-tabs small">
		              <li class=" nav-item active col-lg-4 col-md-4 col-sm-4 col-xs-4">
		                <a href="#ordering" data-toggle="tab" aria-expanded="true"><h4>Đang Giao</h4></a>
		              </li>
		              <li class="nav-item col-lg-4 col-md-4 col-sm-4 col-xs-4">
		                <a href="#ordered" data-toggle="tab" aria-expanded="true"><h4><h4>Đã Giao</h4></a>
		              </li>
		              <li class="nav-item col-lg-4 col-md-4 col-sm-4 col-xs-4">
		                <a href="#orderCancel" data-toggle="tab" aria-expanded="true"><h4><h4>Đã Hủy</h4></a>
		              </li>
		            </ul>
		          </div>

		          <div class="tab-content">
		            <div id="ordering" class="tab-pane active">
		              <?php showOrdering($connect, $_SESSION['username']); ?>
		            </div>

		            <div id="ordered" class="tab-pane fade">
		              <?php showOrdered($connect, $_SESSION['username']); ?>
		            </div>
		            <div id="orderCancel" class="tab-pane fade">
		              <?php showOrderCancel($connect, $_SESSION['username']); ?>
		            </div>
		          </div>
	          </div>

					</div>
					
					
				</div>
			</div>
		</div>
	</div>
</div>
<?php include "footer.php" ;?>
</body>
</html>
<script>
	function confirmDelete(url) {
	    if (confirm("Bạn có chắc chắn muốn hủy không?")) {
	        window.location.replace(url);
	    } else {
	        false;
	    }       
	}
</script>