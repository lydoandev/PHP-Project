
<?php
	session_start();
	include "function.php";
	$_SESSION['page'] = "listLoveByUser";
	$_SESSION['last_url'] = $_SERVER['REQUEST_URI'];
	if (isset($_GET['addProd_id'])) {
		if (!isset($_SESSION['username'])) {
			echo "
			<script>
			 alert('Vui Lòng Đăng Nhập');
			 window.location.replace('./home.php');
			</script>";
		}else{
			$_SESSION['last_url'] = "listLoveByUser.php";
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
			$_SESSION['last_url'] = "listLoveByUser.php";
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
		<div class="container">
			<div class="productHot">
				<div class="row">
					<div class="solugan">
						<div class="box-product-head">
							<span class="box-title">
								DANH SÁCH YÊU THÍCH CỦA BẠN
							</span>
							<span class="af-ter">
								
							</span>
						</div>
					</div>
					<?php  
						$prod = new product();
						$prod->showListLoveByUser($connect, $_SESSION['username']);
					?>
				</div>
			</div>
			<div class="productPromotion">
				<div class="row">
					<div class="solugan">
						<div class="box-product-head">
							<span class="box-title">
								SẢN PHẨM SIÊU KHUYẾN MÃI
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
</html>


