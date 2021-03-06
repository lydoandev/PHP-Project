
<?php
	session_start();
	include "function.php";
	$_SESSION['page'] = "product";
	if (isset($_GET['addProd_id'])) {
		if (!isset($_SESSION['username'])) {
			echo "
			<script>
			 alert('Vui Lòng Đăng Nhập');
			 window.location.replace('./home.php');
			</script>";
		}else{
			$_SESSION['last_url'] = "product.php";
			addToCart($connect, $_SESSION['username'], $_GET['addProd_id'], 1);
		}
	}
	
	if (isset($_GET['likeProd_id'])) {
		if (!isset($_SESSION['username'])){
			echo "
			<script>
			 alert('Vui Lòng Đăng Nhập');
			 window.location.replace('./home.php');
			</script>";
		}else{
			$_SESSION['last_url'] = "product.php";
			insertToListProductLove($connect, $_SESSION['username'], $_GET['likeProd_id']);
		}
	}
   ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
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
		include "header.php";
	 ?>
	 
	<div class="content"> 
	  <div id="myCarousel" class="carousel slide" data-ride="carousel">
	    <!-- Indicators -->
	    <ol class="carousel-indicators">
	      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
	      <li data-target="#myCarousel" data-slide-to="1"></li>
	      <li data-target="#myCarousel" data-slide-to="2"></li>
	      <li data-target="#myCarousel" data-slide-to="3"></li>
	    </ol>

	    <!-- Wrapper for slides -->
	    <div class="carousel-inner">
	      <?php showSlide($connect); ?>
	    </div>

	    <!-- Left and right controls -->
	    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
	      <span class="glyphicon glyphicon-chevron-left"></span>
	      <span class="sr-only">Previous</span>
	    </a>
	    <a class="right carousel-control" href="#myCarousel" data-slide="next">
	      <span class="glyphicon glyphicon-chevron-right"></span>
	      <span class="sr-only">Next</span>
	    </a>
		</div>
		<div class="container">
			<div class="productHot">
				<div class="row">
					<div class="solugan">
						<div class="box-product-head">
							<span class="box-title">
								VÍ DA
							</span>
							<span class="af-ter">
								
							</span>
						</div>
					</div>
					<?php  
						$sql = "SELECT * FROM products, categories WHERE products.cate_id = categories.cate_id AND categories.cate_name = 'Ví da' AND products.delete_at IS NULL LIMIT 8;";
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
				<div class="viewMore text-center" style="padding-top: 40px;">
					<a href="productByCate.php?cate_id=CATE_02&cate_name=Ví Da"><button class="btn">XEM THÊM</button></a>
				</div>
			</div>

			<div class="productHotSell">
				<div class="row">
					<div class="solugan">
						<div class="box-product-head">
							<span class="box-title">
								TÚI & CLUTCH
							</span>
							<span class="af-ter">
								
							</span>
						</div>
					</div>
					<?php  
						$sql = "SELECT * FROM products, categories WHERE products.cate_id = categories.cate_id AND categories.cate_name = 'Túi & clutch' AND products.delete_at IS NULL LIMIT 8;";
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
				<div class="viewMore text-center" style="padding-top: 40px;">
					<a href="productByCate.php?cate_id=CATE_01&cate_name=Túi & Clutch"><button class="btn">XEM THÊM</button></a>
				</div>
			</div>

			<div class="productPromotion">
				<div class="row">
					<div class="solugan">
						<div class="box-product-head">
							<span class="box-title">
								PHỤ KIỆN
							</span>
							<span class="af-ter">
								
							</span>
						</div>
					</div>
					<?php  
						$sql = "SELECT * FROM products, categories WHERE products.cate_id = categories.cate_id AND categories.cate_name = 'Phụ kiện' AND products.delete_at IS NULL LIMIT 8;";
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
				<div class="viewMore text-center" style="padding-top: 40px;">
					<a href="productByCate.php?cate_id=CATE_03&cate_name=Phụ Kiện"><button class="btn">XEM THÊM</button></a>
				</div>
			</div>
			
		</div>
		
		
	</div>

	<?php include "footer.php" ?>
</body>
</html>


