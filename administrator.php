<?php 
	session_start();
	include "function.php";

	if (!isset($_SESSION['role']) || $_SESSION['role'] !="admin") {
		header('Location: home.php');
	}


	$_SESSION['last_url'] = $_SERVER['REQUEST_URI'];

	if (isset($_GET["username"])) {
		$sql = "UPDATE users SET delete_at = CURDATE(), is_active = 0 WHERE username = '" . $_GET["username"] . "'";
		if ($connect->query($sql)) {
			echo "<script>
			 alert('Xóa Thành Công Tài Khoản');
			 window.location.replace('./administrator.php');
			 </script>";
		}else echo "<script>
			 alert('Xóa không Thành Công Tài Khoản');
			 window.location.replace('./administrator.php');
			 </script>";
	}

	$readonly = "";
	$showPass = "";
	$disable = "";
	$showActive = "hidden";
	$info= array("username"=>"", "password"=>"", "avatar_url"=>"", "last_name"=>"", "first_name"=>"", "birthday"=>"", "gender"=>"", "email"=>"", "address"=>"", "phone"=>"", "u_role"=>"", "is_active"=>"");
	$showInfo = "hidden";

	if (isset($_POST['themmoi'])) {
		unset($_GET['viewUsername']);
		$showInfo = "show";
		$showActive = "hidden";
		$showPass = "show";
	}	

	if (isset($_GET["viewUsername"])) {
		$u = new user();
		$info = $u->showInfo($connect, $_GET["viewUsername"]);
		$showInfo = "show";
		$showPass = "hidden";
		$showActive = "show";
		$disable = "disabled";
		$readonly ="readonly";
	}

	if (isset($_POST['add'])) {
		echo "<script>
			 alert('Thêm Thành Công Tài Khoản');
			 </script>";
		$user = new user();
		$avatar_url = chooseImage();
		$user->insert_user($connect, $_POST['last_name'], $_POST['first_name'], $_POST['email'], $_POST['address'], $_POST['phone'], $_POST['gender'], $_POST['birthday'],$_POST['username'], $_POST['password'],$avatar_url, $_POST['u_role'],"admin");
	}	

	if (isset($_POST['update'])) {
		$user = new user();
		$user->updateIs_active($connect, $_POST['username'], $_POST['is_active']);
	}		
	
 ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="jquery-3.3.1.min.js"></script>
</head>
<body>
			
	<div class="admin">
		<div class="header">
			<div class="container">
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center">
					<img src="Image/logo.png" width="80px" height="60px">
        </div>
				<div class="solugan col-lg-5 col-md-5 col-sm-5 col-xs-5 text-center">
          <h3>WELLCOME TO LEONARDO ADMIN</h3>
        </div>
        <div class="header-right col-lg-5 col-md-5 col-sm-5 col-xs-5">
          <ul class="nav navbar-nav">
            <li>
              <a href=""><span><i class="fa fa-bell-o "></i></span> THÔNG BÁO </a>
            </li>
            <li>
              <a href="">
                <span>
                  <i class="fa fa-question-circle  "></i>
                </span>TRỢ GIÚP
              </a>
            </li>
            <li class="dropdown" class="<?php echo $showUsername;?>">
                <a href="#" id="user" class="<?php echo $showUsername;?> ?>" data-toggle="dropdown">
                  <img src="<?php echo $_SESSION['avatar_url']; ?>">
                  <?php echo $_SESSION['username']; ?>
                </a>
                <ul class="dropdown-menu text-capitalize" role="menu">
                    <li><a href="logout.php"><span><i class="fa fa-sign-out"></i></span> Đăng xuất</a></li>
                  </ul>
            </li>
          </ul>
        </div>
			</div>
		</div>

		

		<div class="content">

			<div class="container">

				<div class="sidenav col-lg-3 col-md-3 col-sm-3 col-xs-3">
				  <ul role="tablist" class="">
				  	 <li><a href=""><span><i class="fa fa-home" style="color: #ff661a;"></i></span> Trang chủ Admin</a></li>
		             <li class="active">
		               <a href="qluser.php"><span><i class="fa fa-address-card-o" style="color: #a31aff;"></i></span> Quản lí khách hàng</a>
		             </li>
		             <li>
		               <a href="home.php"><span><i class="fa fa-user-circle-o" style="color: #c51a1d;"></i></span> Hoạt động như user bình thường</a>
		             </li>
		           </ul>
				</div>

				<div class="text col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-9 col-xs-offset-3">
					<div class="info">
		        <div id="qluser">
	          <h3>THÔNG TIN NGƯỜI DÙNG</h3>
	        	Quản Lí Thông Tin Người Dùng Dễ Dàng Hơn
	        	<hr>
	        	<form method="POST" action="">
	        		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 home" style="float: left;">
								<select class="form-control" name="object">
								  <option value="username">Username</option>
								  <option value="name">Họ Tên</option>
								</select>
							</div>
							<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 home" style="float: left;">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Search..." name="content">
								      <span class="input-group-btn">
								        <button class="btn" type="submit" name="search" ><i class="fa fa-search fa-fw"></i></button>
								      </span>
								</div>
							</div>
							
			        		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 home" style="float: right;">
								<a href="#views"><button class="btn" name="themmoi"><span><i class="fa fa-plus-square"></i></span>  THÊM MỚI</button></a>
							</div>
	        	</form>
	        	
	          <?php
		          if (isset($_POST['search'])) {
		          	searchUser($connect, $_POST['object'], $_POST['content']);
		          }else
	           		showAllUsers($connect); 
	           ?>
						<div id="views" class="feature <?php echo $showInfo ?>">
							<hr>
							<h3>Thông Tin</h3>
							<form method="POST" action="" enctype="multipart/form-data">
								<div class="col-xs-3">
									<img class="img-circle" src="<?php echo $info['avatar_url']; ?>" width = "150px;" height = "150px;">
									<input type="file" name="file" class="form-control home <?php echo $showPass; ?>"  >
								</div>
								<div class="col-xs-9">

									<div class="col-md-4 home">
										<select class="form-control" name="u_role" <?php echo $disable ?>>
										  <option value="admin" <?php if ($info['u_role'] == "admin") { echo "selected";} ?>>Admin</option>
										  <option value="stocker" <?php if ($info['u_role'] == "stocker") { echo "selected";} ?>>Stocker</option>
										  <option value="customer" <?php if ($info['u_role'] == "customer") { echo "selected";} ?>>Customer</option>
										</select>
									</div>
									<div class="col-md-4 home <?php echo $showActive ?>">
										<select class="form-control" name="is_active">
										  <option value="1" <?php if ($info['is_active'] == 1) { echo "selected";} ?>>Đang hoạt động</option>
										  <option value="0" <?php if ($info['is_active'] == 0) { echo "selected";} ?>>Ngừng hoạt động</option>
										</select>
									</div>
									<div class="col-md-12 home">
										<input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $info['username']; ?>" <?php echo $readonly ?> required>
									</div>
									<div class="col-md-12 home <?php echo $showPass; ?>">
										<input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo $info['username']; ?>" <?php echo $readonly ?>  required>
									</div>
									<div class="col-md-6 home">
										<input type="text" name="last_name" class="form-control" placeholder="Họ" value="<?php echo $info['last_name']; ?>" <?php echo $readonly ?> required>
									</div>
									<div class="col-md-6 home">
										<input type="text" name="first_name" class="form-control" placeholder="Tên" value="<?php echo $info['first_name']; ?>" <?php echo $readonly ?> required>
									</div>
									<div class="col-md-12 home">
										<input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $info['email']; ?>" <?php echo $readonly ?> required>
									</div>
									<div class="col-md-12 home">
										<input type="text" name="address" class="form-control" placeholder="Địa chỉ" value="<?php echo $info['address']; ?>" <?php echo $readonly ?> required>
									</div>
									<div class="col-md-12 home">
										<input type="text" name="phone" class="form-control" placeholder="Số điện thoại" value="<?php echo $info['phone']; ?>" <?php echo $readonly ?> required>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 home">
										<input type="radio" name="gender" value="Male" <?php if ($info['gender']=="Male") { echo "checked";} ?> <?php echo $disable ?> >Male
										<input type="radio" name="gender" value="Female" <?php if ($info['gender']=="Female") { echo "checked";} ?> <?php echo $disable ?> >Female
									</div>
									<div class="col-md-12 home">
										<input type="date" name="birthday" class="form-control" value="<?php echo $info['birthday']; ?>" <?php echo $readonly ?> >
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 home">
										<button class="btn <?php echo $showPass; ?>" name="add" >THÊM</button>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 home">
										<button class="btn <?php echo $showActive; ?>" name="update" >SỬA</button>
									</div>
								</div>
							</form>
						</div>
						</div>
        	</div>
		    </div>
					
				</div>
			</div>
		</div>
	</div>
	
</body>
<script>
	function confirmDelete(url) {
	    if (confirm("Bạn có chắc chắn muốn xóa không?")) {
	        window.location.replace(url);
	    } else {
	        false;
	    }       
	}
</script>

</html>