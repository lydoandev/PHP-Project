<?php 
 session_start();
 $page = "profile";
 //include("functions.php");
 if (isset($_POST['add_to_card'])) {
   
 }
?>
<!DOCTYPE html>
<html>
<head>
 <link rel="icon" href="img/logotitle.png" type="image/gif" sizes="16x16">
 <title>MUA SẮM - THÔNG TIN TÀI KHOẢN</title>
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <link rel="stylesheet" type="text/css" href="css/style.css">
 <link rel="stylesheet" type="text/css" href="css/product.css">
</head>
<body>

 <!-- <?php include("header.php"); ?> -->

 <div class="content">
   <div class="product-control">
     <div class="row">
       <div class="col-sm-6">
         <img src="img/mobile-6.png">
       </div>
       <div class="col-sm-6">
         <form method="POST">
           <h3 class="text-uppercase">Điện thoại iPhone 6s</h3>
           <p><span><s>9.000.000đ</s></span> - 4.500.000đ</p> 
           <div class="input-quantity">
             Số lượng: 
             <button type="button" class="btn minus" onclick="minusProductQuantity()">-</button>
             <input id="quantity" type="text" name="quantity" value="1">
             <button type="button" class="btn plus" onclick="plusProductQuantity()">+</button> 
             Còn <?php echo "10" ?> sản phẩm trong kho
           </div>
           <div class="col-sm-6">
             <button class="btn btn-info text-uppercase">Thêm vào giỏ</button>
           </div>
           <div class="col-sm-6">
             <button class="btn btn-info text-uppercase">Mua ngay</button>
           </div>
         </form>
       </div>
     </div>
   </div>
   <div class="product-detail">
     <div class="row">
       
     </div>
   </div>
 </div>

 <div class="clearfix"></div>

 <!-- <?php include("footer.php"); ?> -->

</body>
</html>
<script type="text/javascript">
 window.onscroll = function() {
   scrollMenu()
 };

 var header = document.getElementById("menu-hr");
 var sticky = header.offsetTop;

 function scrollMenu() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
 }

 function plusProductQuantity() {
   var quantity = document.getElementById("quantity").value;
   quantity++;
   document.getElementById("quantity").setAttribute('value', quantity);
 }

 function minusProductQuantity() {
   var quantity = document.getElementById("quantity").value;
   if (quantity > 1) {
     quantity--;
     document.getElementById("quantity").setAttribute('value', quantity);
   }
 }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
