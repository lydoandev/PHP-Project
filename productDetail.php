<?php
	session_start();
	 include "function.php";
	 $_SESSION['page'] ="productDetail";
	 $info = array();
	if (isset($_GET['prod_id'])) {
	  $url = $_SESSION['last_url'] = $_SERVER['REQUEST_URI'];
	 	$prod = new product();
	 	$prod->changeViews($connect, $_GET['prod_id']);
	 	$info = $prod->showProduct($connect, $_GET['prod_id']);
	 	$cate_name = $info['cate_name'];
	 	$image = explode("|", $info['image']);
	 	if ($info['new_price'] == "") {
	 		$showPromotion = "hidden";
	 		$percent = 0;
	 		$info['new_price'] = $info['price_out'];
	 	}else {
	 		$percent = round(($info['price_out'] - $info['new_price'])/($info['price_out']/100), 0);
			$showPromotion = "show";
	 	}
  }
	if (isset($_POST['addCart'])) {
		if (!isset($_SESSION['username'])) { 
		echo "
			<script>
			 alert('Vui Lòng Đăng Nhập');
			 window.location.replace('$url');
			</script>";
		}else{
			addToCart($connect, $_SESSION['username'], $_GET['prod_id'], $_POST['quantity']);	
		}

	}

	if (isset($_GET['addProd_id'])) {
		if (!isset($_SESSION['username'])) {
			echo "
			<script>
			 alert('Vui Lòng Đăng Nhập');
			 window.location.replace('./home.php');
			</script>";
		}else{
			addToCart($connect, $_SESSION['username'], $_GET['addProd_id'], 1);
		}
	}

	if (isset($_SESSION['username'])) {
			$user = new user();
	 		$infoUser = $user->showInfo($connect, $_SESSION['username']); 
	}else $infoUser['address']="";

	if (isset($_POST['order'])) {
		if (!isset($_SESSION['username'])) {
			echo "
				<script>
				 alert('Vui Lòng Đăng Nhập');
				 window.location.replace('$url');
				</script>";
		} else {
			order($connect, $_SESSION['username'], $_POST['address'], $_GET['prod_id'], $_POST['quantity']);
		}
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
	<?php 
		include "header.php";
	 ?>

	<div class="content">
		<div class="container">
			<div class="productDetail" style="margin: 50px 0px 50px 0px;">
				<form method="POST" action="">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 image">
							<div class="imageMain col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<img id="expandedImg" src="<?php echo $image[0] ?>" width="100%">
							</div>
							<div class="row">
							  <div class="col-xs-3" style="margin-top: 30px;">
							    <img src="<?php echo $image[0] ?>" style="width:100%" onclick="changeImage(this);">
							  </div>
							  <div class="col-xs-3" style="margin-top: 30px;">
							    <img src="<?php echo $image[1] ?>" style="width:100%" onclick="changeImage(this);">
							  </div>
							  <div class="col-xs-3" style="margin-top: 30px;">
							    <img src="<?php echo $image[2] ?>" style="width:100%" onclick="changeImage(this);">
							  </div>
							  <div class="col-xs-3" style="margin-top: 30px;">
							    <img src="<?php echo $image[3] ?>"  style="width:100%" onclick="changeImage(this);">
							  </div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 detail">
							<div class="row">
							<p class="prod_name"><?php echo $info['prod_name']; ?></p>
							<div class="col-xs-6 float-left">
								Mã Hàng:
							</div>
							<div class="col-xs-6 float-right">
								<b><?php echo $info['prod_id']; ?></b>
							</div>
							<hr>
							<div class="col-xs-6 float-left">
								Nhóm Sản Phẩm:
							</div>
							<div class="col-xs-6 float-right">
								<b><?php echo $info['cate_name']; ?></b>
							</div>
							<hr>
							<div class="col-xs-6 float-left">
								Chất liệu:
							</div>
							<div class="col-xs-6 float-right">
								<b><?php echo $info['material']; ?></b>
							</div>
							<hr>
							<div class="col-xs-6 float-left">
								Số Lượt Xem:
							</div>
							<div class="col-xs-6 float-right">
								<b><?php echo $info['views']; ?></b>
							</div>
							<hr>
							<div class="col-xs-12">
								<?php echo $info['description']; ?>
							</div>
							<hr>
							<div class="row" style="font-size: 20px;">
								<div class="col-xs-3">
									&nbsp; Giá bán:
								</div>
								<div class="col-xs-3">
									<?php echo number_format($info['new_price']); ?> đ
								</div>
								<div class="col-xs-3">
									<s  class="<?php echo $showPromotion; ?>" style="color: red;"><?php echo number_format($info['price_out']); ?> đ</s>
								</div>
								<div class="col-xs-2">
									<span style="background: #c51a1d;" class="<?php echo $showPromotion; ?>"><i class="fa fa-sort-amount-desc"></i><?php echo $percent; ?>%</span>
								</div>
							</div>
								<hr>
								<div class="input-quantity row">
		             <div class='col-sm-2'>
		             	&nbsp; Số lượng: 
		             </div>
		             <div class='col-sm-1'>
		             	<button type="button" class="btn minus" onclick="minusProductQuantity()">-</button>
		             </div>
		             <div class='col-sm-2'>
		             	<input id="quantity" type="text" name="quantity" value="1" class="form-control" onchange="updateQuantity(this.value)">
		             </div>
		             <div class='col-sm-1'>
		             	<button type="button" class="btn plus" onclick="plusProductQuantity()">+</button> 
		             </div>
		             <div class='col-sm-6'>
		             	<?php echo  $info['quantity']?> sản phẩm có sẵn
		             </div>
			           </div>
			           <hr>
			           <div id="address" class="col-sm-12">
			           	Địa chỉ giao hàng:
			             <input type="text" name="address" class="form-control" placeholder="Địa chỉ giao hàng" value="<?php echo $infoUser['address'] ?>">
			           </div>
			           <hr>
			           <div class="col-sm-3">
			           </div>
			           <div class="col-sm-3">
			             <button class="btn btn-info text-uppercase" name="addCart">Thêm vào giỏ</button>
			           </div>
			           <div class="col-sm-3">
			             <button class="btn btn-info text-uppercase" name="order">Mua ngay</button>
			           </div>
							</div>
						</div>

					</div>
				</form>
				
			</div>
			<div class="productHot">
				<div class="row">
					<div class="solugan">
						<div class="box-product-head">
							<span class="box-title text-uppercase">
								SẢN PHẨM CÙNG NHÓM <?php echo $info['cate_name']; ?>
							</span>
							<span class="af-ter">
								
							</span>
						</div>
					</div>
					<?php  
						$sql = "SELECT * FROM products, categories WHERE products.cate_id = categories.cate_id AND categories.cate_name = '$cate_name' AND products.delete_at IS NULL LIMIT 8;";
						$result = $connect->query($sql);
						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
								$prod = new product();
								$info = $prod->showProduct($connect, $row['prod_id']);
								$image = explode("|", $info['image']);
								$prod->showInfoProducthtml($row['prod_id'], $info['prod_name'], $image[0], $info['price_out'], $info['new_price']);
							}
						}
					?>
				</div>
			</div>
			<div class="productPromotion">
				<div class="row">
					<div class="solugan">
						<div class="box-product-head">
							<span class="box-title text-uppercase">
								sản phẩm bạn có thể quan tâm
							</span>
							<span class="af-ter">
								
							</span>
						</div>
					</div>
					<?php  
						$prod = new product();
						$prod->showProductPromotion($connect);
					?>
				</div>
			</div>
		</div>
	</div>
	
	<?php include "footer.php" ?>
</body>
<script>
	var quantity = 1;
	function plusProductQuantity() {
	   quantity++;
	   document.getElementById("quantity").value = quantity;
	}

	function minusProductQuantity() {
	   if (quantity > 1) {
	    quantity--;
	    document.getElementById("quantity").value = quantity;
	   }
	}
	function updateQuantity(qtt) {
		document.getElementById("quantity").value = qtt;
		quantity = qtt;
	}
	function changeImage(imgs) {
	  var expandImg = document.getElementById("expandedImg");
	  expandImg.src = imgs.src;
	  expandImg.parentElement.style.display = "block";
	}
</script>
</html>