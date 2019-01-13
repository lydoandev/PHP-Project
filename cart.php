<?php
	session_start();
	 include "function.php";
	 $url = $_SESSION['last_url'] = $_SERVER['REQUEST_URI'];
	 if (isset($_GET['deleteProd_id'])) {
	 	$sql = "DELETE FROM ords_prods WHERE order_id = '".$_GET['deleteOrder_id']."' AND prod_id = '". $_GET['deleteProd_id']."'";
	 	$connect->query($sql);
	 }
	 if (isset($_GET['changeProd_id'])) {
	 	$sql = "UPDATE ords_prods SET quantity = ";
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
		<div class="container" style="height: 700px; margin-top: 320px;">
			<?php showCart($connect, $_SESSION['username']); ?>
		</div>
	</div>
	
	<?php include "footer.php" ?>
</body>
<script>
	//var quantity = 1;
	function plusProductQuantity(input) {
	   var quantity = input.value;
	   quantity++;
	   document.getElementById(input.id).value = quantity;
	}

	function minusProductQuantity(input) {
	  var quantity = input.value;
	  if (quantity >= 1) {
		  quantity--;
		  document.getElementById(input.id).value = quantity;
  	}
	}

</script>
</html>