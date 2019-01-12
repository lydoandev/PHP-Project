<?php 
	session_start();
	include "connectMySQL.php";
	
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
	            <li><a href="changePass.php">Đổi mật khẩu</a></li>
	          </ul>
					</li>
					<li><a href="order.php" class="active"><span><i class="fa fa-list-alt" style="color: #3399ff;"></i></span> Đơn hàng</a></li>
					<li><a href="#"><span><i class="fa fa-bell-o" style="color: #ff0000;"></i></span> Thông báo</a></li>
				</ul>
			</div>
			<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
				<div class="info">
					<div class="tablist row">
            <ul role="tablist" class="nav nav-tabs small">
              <li class=" nav-item active col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <a href="#tabs-1" data-toggle="tab" aria-expanded="true"><h4>Đang Giao</h4></a>
              </li>
              <li class="nav-item col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <a href="#tabs-2" data-toggle="tab" aria-expanded="true"><h4><h4>Đã Giao</h4></a>
              </li>
            </ul>
          </div>

          <div class="tab-content">
            <div id="tabs-1" class="tab-pane active">
              
            </div>

            <div id="tabs-2" class="tab-pane fade">
              
            </div>

            <div id="tabs-3" class="tab-pane fade">
              
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