<?php 
	session_start();
	include "function.php";
	if (!isset($_SESSION['role']) || $_SESSION['role'] !="stocker") {
		header('Location: home.php');
	}
	if (isset($_GET["prod_id"])) {
		$sql = "UPDATE products SET status = 0, delete_at = CURDATE() WHERE prod_id = '" . $_GET["prod_id"] . "'";
		if ($connect->query($sql)) {
			echo "<script>
			 alert('Xóa Sản Phẩm Thành Công');
			 window.location.replace('./stocker.php');
			 </script>";
		}
	}
	$info = array("prod_id"=>"", "prod_name"=>"", "material"=>"", "image"=>"", "price_in"=>"", "price_out"=>"", "date_add"=>"", "quantity"=>"", "description"=>"", "cate_name"=>"", "views"=>"", "new_price"=>"", "date_start"=>"",  "date_end"=>"");
	$image = explode("|", $info['image']);
	$showInfo = "hidden";
	if (isset($_POST['themmoi'])) {
		unset($_GET['viewProd_id']);
		$showAdd = "show";
		$showUpdate = "hidden";
		$showInfo = "show";
	}
	if (isset($_POST['add'])) {
		$image = chooseImage("Image/Product", "file");
		$product = new product();
		$product->insert_products($connect, $_POST['prod_id'], $_POST['prod_name'], $_POST['material'], $image, $_POST['price_in'], $_POST['price_out'], $_POST['quantity'], $_POST['description'], $_POST['cate_id'], $_POST['views'], $_POST['new_price'], $_POST['date_start'], $_POST['date_end']);
	}

	if (isset($_GET["viewProd_id"])) {
		$product = new product();
		$info = $product->showProduct($connect, $_GET["viewProd_id"]);
		$image = explode("|", $info['image']);
		$showInfo = "show";
		$showAdd = "hidden";
		$showUpdate = "show";
	}

	$_SESSION['last_url'] = $_SERVER['REQUEST_URI'];
	if (isset($_POST['update'])) {
		$image = chooseImage("Image/Product", "file");
		if ($image == "Image/Product/") {
			$image =$info['image'];
			echo "Ly $image";
		}
		$product = new product();
		$product->update_products($connect, $_POST['prod_id'], $_POST['prod_name'], $_POST['material'], $image, $_POST['price_in'], $_POST['price_out'], $_POST['quantity'], $_POST['date_add'], $_POST['description'], $_POST['cate_id'], $_POST['views'],  $_POST['status'], $_POST['new_price'], $_POST['date_start'], $_POST['date_end']);
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
          <h3>WELLCOME TO LEONARDO STOCKER</h3>
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
				  	 <li><a href=""><span><i class="fa fa-home" style="color: #ff661a;"></i></span> Trang chủ Stocker</a></li>
             <li class="active">
               <a href="stocker.php"><span><i class="fa fa-university e" style="color: #a31aff;"></i></span> Quản lí sản phẩm</a>
             </li>
             <li>
               <a href="qldanhmuc.php"><span><i class="fa fa-credit-card" style="color: #ffcc00;"></i></span> Quản lí danh mục</a>
             </li>
             <li>
               <a href="home.php"><span><i class="fa fa-user-circle-o" style="color: #c51a1d;"></i></span> Hoạt động như user bình thường</a>
             </li>
           </ul>
				</div>

				<div class="text col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-9 col-xs-offset-3">
					<div class="info">
			        <div id="qlsanpham">
			        	<h3>THÔNG TIN SẢN PHẨM</h3>
			        	Quản Lí Thông Tin Sản Phẩm Dễ Dàng Hơn
			        	<hr>
			        	<form method="POST" action="">
			        		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 home" style="float: right;">
										<button class="btn" name="themmoi">THÊM MỚI</button>
									</div>
			        	</form>
			        	<?php 
			        		showAllProduct($connect);
			        	 ?>
			        	 <div class="feature <?php echo $showInfo ?>">
										<hr>
										<h3>Thông Tin</h3>
										<form method="POST" action="" enctype="multipart/form-data">
											<div class="col-xs-3">
												<img src="<?php echo $image[0]; ?>" width = "150px;" height = "150px;">
												<input type="file" name="file" class="form-control home"  >
											</div>
											<div class="col-xs-9">
												<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 home">
														<p class="<?php echo $showUpdate?>"><b>ID:</b></p>
														<input type="text" name="prod_id" class="form-control" value="<?php echo $info['prod_id']?>" placeholder = "ID">
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 home">
														<p class="<?php echo $showUpdate?>"><b>Danh Mục:</b></p>
														<select class="form-control" name="cate_id">
															<option value="">Danh Mục</option>
														  <?php 
														  	$product = new product();
														  	$product->showCategoryOption($connect,$info['cate_name']); 
														  ?>
														</select> 
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 home">
														<p class="<?php echo $showUpdate?>"><b>Tên Sản Phẩm:</b></p>
														<input type="text" name="prod_name" class="form-control" value="<?php echo $info['prod_name']?>" placeholder = "Tên sản phẩm">
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 home">
														<p class="<?php echo $showUpdate?>"><b>Vật Liệu:</b></p>
														<input type="text" name="material" class="form-control" value="<?php echo $info['material']?>" placeholder = "Vật Liệu">
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 home">
														<p class="<?php echo $showUpdate?>"><b>Giá Nhập:</b></p>
														<input type="text" name="price_in" class="form-control" value="<?php echo $info['price_in']?>" placeholder = "Giá Nhập">
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 home">
														<p class="<?php echo $showUpdate?>"><b>Giá Bán:</b></p>
														<input type="text" name="price_out" class="form-control" value="<?php echo $info['price_out']?>" placeholder = "Giá Bán">
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 home">
														<p class="<?php echo $showUpdate?>"><b>Số Lượng:</b></p>
														<input type="text" name="quantity" class="form-control" value="<?php echo $info['quantity']?>" placeholder = "Số Lượng">
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 home">
														<p class="<?php echo $showUpdate?>"><b>Ngày Nhập:</b></p>
														<input type="date" name="date_add" class="form-control <?php echo $showUpdate ?>" value="<?php echo $info['date_add']?>">
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 home <?php echo $showUpdate?>">
														<p class="<?php echo $showUpdate?>"><b>Tình Trạng:</b></p>
														<select class="form-control" name="status">
														  <option value="1" <?php if ($info['status'] == 1) { echo "selected";} ?>>Còn Hàng</option>
														  <option value="0" <?php if ($info['status'] == 0) { echo "selected";} ?>>Hết Hàng</option>
														</select>
													</div>
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 home">
														<p class="<?php echo $showUpdate?>"><b>Miêu Tả:</b></p>
														<textarea class="form-control rounded-0" name="description" rows="4" value="<?php echo $info['description']?>" placeholder = "Miêu Tả Sản Phẩm"><?php echo $info['description']?></textarea>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 home">
														<p class="<?php echo $showUpdate?>"><b>Lượt Xem:</b></p>
														<input type="text" name="views" class="form-control" value="<?php echo $info['views']?>" placeholder = "Lượt xem">
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 home">
														<p class="<?php echo $showUpdate?>"><b>Giá KM:</b></p>
														<input type="text" name="new_price" class="form-control" value="<?php echo $info['new_price']?>" placeholder = "Giá Khuyến Mãi">
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 home">
														<p class="<?php echo $showUpdate?>"><b>Ngày bắt đầu KM::</b></p>
														<input type="date" name="date_start" class="form-control" value="<?php echo $info['date_start']?>">
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 home">
														<p class="<?php echo $showUpdate?>"><b>Ngày kết thúc KM::</b></p>
														<input type="date" name="date_end" class="form-control" value="<?php echo $info['date_end']?>">
													</div>
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 home">
														<button class="btn <?php echo $showAdd; ?>" name="add" >THÊM</button>
													</div>
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 home">
														<button class="btn <?php echo $showUpdate ?>" name="update" >SỬA</button>
													</div>
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