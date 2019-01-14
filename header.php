<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
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
<?php 
  
  $errUserName = "";
  $errConfirmpassword = "";
  $showDangki_Dangnhap = "show";
  $showSwitch = "hidden";
  $showUsername = "hidden";
  $username = "";
  $password = "";
  $remember = "";

  if (isset($_COOKIE['username']) and isset($_COOKIE['password'])) {
    $username = $_COOKIE['username'];
    $password = $_COOKIE['password'];
    $remember = "checked";
  }

  if (isset($_SESSION['username'])) {
    $showDangki_Dangnhap = "hidden";
    $username = $_SESSION['username'];
    $avatar = $_SESSION['avatar_url'];
    $showUsername = "show";
  }

  $_SESSION['last_url'] = $_SERVER['REQUEST_URI'];
  if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    $showSwitch = "show";
  }

  if (isset($_POST['dangnhap'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = new user();
    $user->check_login($connect, $username, $password);
  }

  if (isset($_POST['dangki'])) {
    $last_name = $_POST['ho'];
    $first_name = $_POST['ten'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $user = new user();
    if ($confirmpassword == $password) {
      $user->insert_user($connect, $last_name, $first_name, $email, $address, $phone, $gender, $birthday, $username, $password,"","","customer");
    } else echo "<script> alert('Nhập lại mật khẩu không chính xác');</script>";
  }
 ?>
<div id="header">
      <div class="header-top">
        <div class="container">
          <div class="header-left col-lg-5 col-md-5 col-sm-6 col-xs-6">
            <div class="info">
              <span>
              <i class="glyphicon glyphicon-cloud"></i>
              27°C
              </span>
              <span>
                <i class="glyphicon glyphicon-map-marker"></i>
                101B Lê Hữu Trác
              </span>
              <span>
                <i class="glyphicon glyphicon-earphone"></i>
                +84 648 534 343
              </span>
            </div>
          </div>
          <div class="col-lg-2 col-md-1 col-sm-0 col-xs-0">
            
          </div>
          <div class="header-right col-lg-5 col-md-6 col-sm-6 col-xs-6">
            <ul class="nav navbar-nav">
              <li>
                <a href="" data-toggle="modal" data-target="#dangki"><span><i class="fa fa-bell-o "></i></span> THÔNG BÁO </a>
              </li>
              <li>
                <a href="" data-toggle="modal" data-target="#dangki">
                  <span>
                    <i class="fa fa-question-circle  "></i>
                  </span>TRỢ GIÚP
                </a>
              </li>
              <li class="<?php echo $showDangki_Dangnhap?>">
                <a href="" data-toggle="modal" data-target="#dangki">
                  <span>
                    <i class="fa fa-user-plus "></i>
                  </span> ĐĂNG KÍ
                </a>
              </li>
              <li class="<?php echo $showDangki_Dangnhap?>">
                <a href="" data-toggle="modal" data-target="#dangnhap">
                  <span>
                    <i class="fa fa-sign-in"></i>
                  </span> ĐĂNG NHẬP
                </a>
              </li>
              <li><a href="cart.php"><span><i class="fa fa-shopping-cart fa-2x <?php echo $showUsername;?>"></i></span></a></li>
              <li class="dropdown" class="<?php echo $showUsername;?>">
                  <a href="#" id="user" class="<?php echo $showUsername;?> ?>" data-toggle="dropdown">
                    <img class="img-circle" width="15" height="15" src="<?php echo $avatar ?>">
                    <?php echo $username; ?>
                  </a>
                  <ul class="dropdown-menu text-capitalize" role="menu">
                    <li><a href="profile.php"><span><i class="fa fa-user-circle-o"></i></span> Tài khoản của tôi</a></li>
                    <li><a href="logout.php"><span><i class="fa fa-sign-out"></i></span> Đăng xuất</a></li>
                  </ul>
              </li>
                          
            </ul>
          </div>

        </div>
      </div>
      
      <div class="header-content">
        <div class="container">
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 logo">
            <img src="Image/logo.png" width="120px" height="100px">
          </div>
          <div class="solugan col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <h3>PHONG ĐỘ LÀ TỨC THỜI. ĐẲNG CẤP LÀ MÃI MÃI</h3>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-0 ship" style="float: left;">
            <img src="Image/ship.png" width="200px" height="100px">
          </div>
        </div>
      </div>
      <div class="header-menu text-uppercase" id="myMenu">
        <nav class="navbar navbar-default">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span> 
              </button>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
              <ul class="nav navbar-nav">
                <li class="dropdown "> 
                  <a href="#" id="category" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-bars "></span>  DANH MỤC SẢN PHẨM</a>
                  <ul class="dropdown-menu text-capitalize" role="menu">
                    <?php
                      $product = new product();
                      $product->showCategorya($connect); 
                    ?>
                  </ul>
                </li>
                <li class="<?php if (isset($page) && $page == 'home' ) {
                  echo "active"; } ?>"><a href="home.php">TRANG CHỦ</span></a></li>
                <li class="<?php if (isset($page) && $page == 'product' ) {
                  echo "active"; } ?>"><a href="product.php">SẢN PHẨM </a></li>
                <li><a href="#">LIÊN HỆ </span></a></li>
                <li class="<?php echo $showSwitch; ?>"><a href="administrator.php"><i class="fa fa-hand-o-right"></i> ĐẾN ADMIN </span></a></li>
                <li>
                <form method="post" class="navbar-form">
                  <div class="input-group search-box">
                    <input type="text" class="form-control" placeholder="Search here...">
                    <span class="input-group-addon btn btn-primary"> <i class="glyphicon glyphicon-search"></i> </span>
                  </div>
                </form>
              </li>      
              </ul>
            </div>
          </div>
        </nav>
      </div>
</div>
<div id="dangki" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">ĐĂNG KÍ</h3>
          </div>
          <form method="POST" action="">
            <div class="modal-body">
              <div class="col-md-6 home">
            <input type="text" name="ho" class="form-control" placeholder="Họ" required>
          </div>
          <div class="col-md-6 home">
            <input type="text" name="ten" class="form-control" placeholder="Tên" required>
          </div>
          <div class="col-md-12 home">
            <input type="text" name="email" class="form-control" placeholder="Email" required>
          </div>
          <div class="col-md-12 home">
            <input type="text" name="address" class="form-control" placeholder="Địa chỉ" required>
          </div>
          <div class="col-md-12 home">
            <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" required>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 home">
            <input type="radio" name="gender" value="Male">Male
            <input type="radio" name="gender" value="Female">Female
          </div>
          <div class="col-md-12 home">
            <input type="date" name="birthday" class="form-control">
          </div>
          <div class="col-md-12 home">
            <input type="text" name="username" class="form-control" placeholder="User Name" required>
          </div>
          <div class="col-md-6 home">
            <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
          </div>
          <div class="col-md-6 home">
            <input type="password" name="confirmpassword" class="form-control" placeholder="Xác nhận mật khẩu" required>
          </div>
            </div>

            <div class="modal-footer">
              <button class="btn" name="dangki" > REGISTER </button>
            </div>
          </form>
        </div>

      </div>
  </div>

    <div id="dangnhap" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">ĐĂNG NHẬP</h3>
          </div>
          <form method="POST" action="">
            <div class="modal-body">
              <div class="col-md-12 home">
                Username:
                <input type="text" name="username" class="form-control" placeholder="User Name" value="<?php echo $username; ?>" required>
              </div>
              <div class="col-md-12 home">
                Mật Khẩu:
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu" value="<?php echo $password; ?>"required>
              </div>
              <div class="col-md-12 home">
                Nhớ mật khẩu  <input type="checkbox" <?php echo $remember; ?> name="remember">
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn" name="dangnhap" > LOG IN </button>
            </div>
          </form>
        </div>

      </div>
    </div>
</body>
<script>
  window.onscroll = function() {scrollMenu()};

  var header = document.getElementById("myMenu");
  var sticky = header.offsetTop;

  function scrollMenu() {
    if (window.pageYOffset > sticky) {
      header.classList.add("sticky");
    } else {
      header.classList.remove("sticky");
    }
  }
</script>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>