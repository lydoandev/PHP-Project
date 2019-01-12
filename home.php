
<?php
	session_start();
	include "function.php";

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
								SẢN PHẨM NỔI BẬT
							</span>
							<span class="af-ter">
								
							</span>
						</div>
					</div>
					<?php  
						$prod = new product();
						$prod->showProductHot($connect);
					?>
				</div>
			</div>

			<div class="productHotSell">
				<div class="row">
					<div class="solugan">
						<div class="box-product-head">
							<span class="box-title">
								SẢN PHẨM BÁN CHẠY
							</span>
							<span class="af-ter">
								
							</span>
						</div>
					</div>
					<?php  
						$prod = new product();
						$prod->showProductHotSell($connect);
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


