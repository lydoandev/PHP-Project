<?php
	session_start();
	 include "function.php"; 
	 $info = array();
	 
	if (isset($_GET['prod_id'])) {
	 	$show = "hidden";
	 	$prod = new product();
	 	$info = $prod->showProduct($connect, $_GET['prod_id']);
	 	$image = explode("|", $info['image']);
	 	if ($info['new_price'] == "") {
	 		$show = "hidden";
	 		$percent = 0;
	 		$info['new_price'] = $info['price_out'];
	 	}else {
	 		$percent = round(($info['price_out'] - $info['new_price'])/($info['price_out']/100), 0);
			$show = "show";
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
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 image">
					<div class="imageMain">
						<img src="<?php echo $image[0] ?>" width="100%">
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
								<s  class="<?php echo $show; ?>" style="color: red;"><?php echo number_format($info['price_out']); ?> đ</s>
							</div>
							<div class="col-xs-2">
								<span style="background: #c51a1d;" class="<?php echo $show; ?>"><i class="fa fa-sort-amount-desc"></i><?php echo $percent; ?>%</span>
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
	             	Còn <?php echo  $info['quantity']?> sản phẩm trong kho
	             </div>
	           </div>
	           <hr>
	           <div class="col-sm-3">
	           </div>
	           <div class="col-sm-3">
	             <button class="btn btn-info text-uppercase" name = "addCart">Thêm vào giỏ</button>
	           </div>
	           <div class="col-sm-3">
	             <button class="btn btn-info text-uppercase" name = "order">Mua ngay</button>
	           </div>
					</div>
				</div>
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
</script>
</html>