<?php
	$connect = mysqli_connect("localhost","root","","sell_leather");
	mysqli_set_charset($connect,'UTF8');

	class user
	{
		var $username;
		var $password;
		var $avatar_url;
		var $first_name;
		var $last_name;
		var $birthday;
		var $gender;
		var $email;
		var $address;
		var $phone;
		function __construct()
		{

		}

		function newInsert_update($username,$password,$avatar_url,$first_name,$last_name, $birthday,$gender,$email,$address,$phone){
			$this->username = $username;
			$this->password = $password;
			$this->avatar_url = $avatar_url;
			$this->first_name = $first_name;
			$this->last_name = $last_name;
			$this->birthday = $birthday;
			$this->gender = $gender;
			$this->email = $email;
			$this->address = $address;
			$this->phone = $phone;
		}

		function newLogin($username, $password){
			$this->username = $username;
			$this->password = $password;
		}

		function showInfo($connect, $username){
			$sql = "SELECT * FROM users WHERE username = '" . $username . "'";
			$result = $connect->query($sql);
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				return $row;
			}
			return 0;
		}

		function check_username($connect, $username){
			if ($connect) {
				$sql = "SELECT username FROM users WHERE username = '$username' ";
				$result = $connect->query($sql);
				if ($result->num_rows > 0) {
					return 0;
				} else return 1;
			} else echo "Failed to connect to MySQL:" .mysqli_connect_error();
			
		}

		function check_email($connect, $email){
			if ($connect) {
				$sql = "SELECT * FROM users WHERE email = '$email' ";
				$result = $connect->query($sql);
				if ($result->num_rows > 0) {
					return 0;
				} else return 1;
			} else echo "Failed to connect to MySQL:" .mysqli_connect_error();
			
		}

		function insert_user($connect, $last_name, $first_name, $email, $address, $phone, $gender, $birthday, $username, $password, $avatar_url, $u_role, $person){
			if ($connect) {
				$url = $_SESSION['last_url'];
				if ($u_role == "") {
					$u_role = 'customer';
				}
				if ($avatar_url == "avatars/" || $avatar_url == "") {
					$avatar_url = 'Image/acount.png';
				}
				$hashed_password = password_hash($password, PASSWORD_DEFAULT);
				$sql = "INSERT INTO users(username,password,avatar_url,first_name,last_name,birthday,gender,email,address,phone,creation_date,u_role,last_access,is_active)
						VALUES ('$username', '$hashed_password', '$avatar_url', '$first_name', '$last_name', '$birthday', '$gender', '$email', '$address', '$phone', NOW(),'$u_role', NOW(), 1);";
				if ($this->check_username($connect, $username)) {
					if ($this->check_email($connect, $email)) {
						if ($connect->query($sql)) {
							if ($person == 'customer') {
								$_SESSION['username'] = $username;
								$_SESSION['avatar_url'] = 'Image/acount.png';
								echo "<script>
								 alert('Chào mừng $username đến với LEONARDO Shop');
								 window.location.replace('..$url');
								 </script>";
							}
							
						}
					}else echo "<script> alert('Email đã được đăng kí');</script>";
				}else echo "<script> alert('User name đã tồn tại');</script>";
			} else echo "Failed to connect to MySQL:" .mysqli_connect_error();
		}

		function updateIs_active($connect, $username, $is_active){
			if ($connect) {
				$sql = "UPDATE users SET is_active = '$is_active' WHERE username = '$username'";
				if ($connect->query($sql)) {
					echo "<script>
						 alert('Cập nhật tình trạng thành công.');
						</script>";
				}
			}
		}

		function check_login($connect, $username, $password){
			
	    $sql = "SELECT * FROM users WHERE username = '" . $username . "' LIMIT 1";

			$result = $connect->query($sql);

			$url = $_SESSION['last_url'];

			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				if ($row['is_active'] == 0) {
					echo "<script>
						 alert('Tài khoản này hiện đang bị khóa hoặc không đăng nhập quá lâu. Xin lỗi vì điều này. Vui lòng quay lại sau.');
						 window.location.replace('./home.php');
						</script>";
				} else {
					if (password_verify($password, $row['password'])) {
						$_SESSION['username'] = $username;
						$test = $_SESSION['username'];
						$_SESSION['role'] = $row['u_role'];
						$_SESSION['avatar_url'] = $row['avatar_url'];
						if (isset($_POST['remember'])) {
							setcookie("username", "", time() - 3600); // Cho thằng cookie sống trong 0s :))
							setcookie("password", "", time() - 3600);
							setcookie('username', $_POST['username'], time() + (86400 * 30), "/");
							setcookie('password', $_POST['password'], time() + (86400 * 30), "/");
						}
						$sql = "UPDATE users SET last_access = NOW() WHERE username = '$username'";
						$connect->query($sql);
						if ($row['u_role'] == "admin") {
							echo "<script>
							 alert('Chào Mừng Bạn Đến Với Trang Quản Lí Của Admin');
							 window.location.replace('./administrator.php');
							</script>";
						}else if ($row['u_role'] == "stocker") {
							echo "<script>
							 alert('Chào Mừng Bạn Đến Với Trang Quản Lí Của Thủ Kho');
							 window.location.replace('./stocker.php');
							</script>";
						} else 
							echo "<script>
							 alert('Chào Mừng $test Đến Với Trang Mua Sắm LENARDO');
							 window.location.replace('..$url');
							</script>";
					} else {
						echo "<script>
										alert('Password không chính xác');
									</script>";
					}
				}
			} else {
				echo "<script> alert('User name không tồn tại');</script>";
			}
  		}

		function updateInfo($connect, $username, $avatar_url, $last_name, $first_name, $email, $address, $phone, $gender, $birthday){
			if ($connect) {
				if ($avatar_url != 'avatars/') {
					$sql = "UPDATE users SET avatar_url= '$avatar_url', last_name = '$last_name', first_name = '$first_name', email = '$email', address = '$address', phone = '$phone', gender = '$gender', birthday = '$birthday' WHERE username = '$username'";
					if ($connect->query($sql)) {
						echo "<script>
						 alert('Update thành công');
						 window.location.replace('./profile.php');
						</script>";
					}
				}else{
					$sql = "UPDATE users SET last_name = '$last_name', first_name = '$first_name', email = '$email', address = '$address', phone = '$phone', gender = '$gender', birthday = '$birthday' WHERE username = '$username'";
					if ($connect->query($sql)) {
						echo "<script>
						 alert('Update thành công');
						 window.location.replace('./profile.php');
						</script>";
					}
				}
				
				
			}
		}

		function updatePassword($connect, $username, $oldPassword, $newPassword){
			if ($connect) {
				$err = "";
				$hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
				$check_old_pass = "SELECT password FROM users WHERE username = '" . $username . "' LIMIT 1";
				$result = $connect->query($check_old_pass);
				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					if (password_verify($oldPassword, $row['password'])) {
						$sql = "UPDATE users SET password = '$hashed_password' WHERE username = '$username'";
						if ($connect->query($sql)) {
							echo "<script> alert('Cập Nhật Password Thành Công');</script>";
						}
					} else {
						$err = "* Password cũ không chính xác";
					}
				}
				return $err;
			}
		}

	}

	/**
	 * 
	 */
	class product
	{

		function changeViews($connect, $prod_id){
			if ($connect) {
				$info = $this->showProduct($connect, $prod_id);
				$views = $info['views'] + 1;
				$sql = "UPDATE products SET views = '$views' WHERE prod_id = '$prod_id'";
				$connect->query($sql);
			}
		}

		function showCategoryOption($connect, $selected){
			$sql = "SELECT * FROM categories WHERE delete_at IS NULL";
			$result = $connect->query($sql);
			if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
					if ($selected == $row['cate_name']) {
						$s = "selected";
					}else $s="";
					echo "<option value='". $row['cate_id']. "'$s>". $row['cate_name'] . "</option>";
				}
			}
		}

		function showCategorya($connect){
			$sql = "SELECT * FROM categories WHERE delete_at IS NULL";
			$result = $connect->query($sql);
			if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
					echo "<li><a href='".$row['cate_id'].".php'>". $row['cate_name']. "</a></li>";
				}
			}
		}

		function check_prod_id($connect, $prod_id){
			if ($connect) {
				$sql = "SELECT prod_id FROM products WHERE prod_id = '$prod_id' ";
				$result = $connect->query($sql);
				if ($result->num_rows > 0) {
					return 0;
				} else return 1;
			} else echo "Failed to connect to MySQL:" .mysqli_connect_error();
			
		}

		function insert_products($connect, $prod_id, $prod_name, $material, $image, $price_in, $price_out, $quantity, $description, $cate_id, $views, $new_price, $date_start, $date_end){
			if ($connect) {
				$url = $_SESSION['last_url'];
				if ($this->check_prod_id($connect, $prod_id)) {
					$sql1 = "INSERT INTO products (prod_id, prod_name, material, image, price_in, price_out, date_add, quantity, description, cate_id, views, status)
					VALUES ('$prod_id', '$prod_name', '$material', '$image', '$price_in', '$price_out', NOW(), '$quantity', '$description', '$cate_id', '$views',1)";
					$sql2 = "INSERT INTO promotion VALUES ('$prod_id', '$new_price', '$date_start', '$date_end')";
					if ($connect->query($sql1)) {
						if ($connect->query($sql2)) {
						echo "<script> 
							alert('Thêm Sản Phẩm Thành Công');
							window.location.replace('..$url');
						</script>";
						}else echo "<script> alert('Đã xảy ra lỗi');</script>";
					}else echo "<script> alert('Đã xảy ra lỗi');</script>";
				}else echo "<script> alert('ID Sản Phẩm Đã Tồn Tại');</script>";
				
			}
		}

		function update_products($connect, $prod_id, $prod_name, $material, $image, $price_in, $price_out, $quantity, $date_add, $description, $cate_id, $views, $status, $new_price, $date_start, $date_end){
			if ($connect) {
				$url = $_SESSION['last_url'];
				$sql = "UPDATE products SET prod_name = '$prod_name', material = '$material', image = '$image', price_in = '$price_in', price_out = '$price_out', date_add = '$date_add', quantity = '$quantity', description = '$description', cate_id = '$cate_id', views = '$views',status = '$status' WHERE prod_id = '$prod_id';";
				$sql .= "UPDATE promotion SET new_price = '$new_price', date_start = '$date_start', date_end = '$date_end' WHERE prod_id = '$prod_id';";
				if (mysqli_multi_query($connect, $sql)) {
					echo "<script>
					 	alert('Cập Nhật Sản Phẩm Thành Công');
					 	window.location.replace('..$url');
					 </script>";
				}else echo "<script> alert('Đã xảy ra lỗi');</script>";
				
			}
		}

		function showInfoProducthtml($prod_id, $name, $image, $price, $new_price){
			$show = "show";
			if ($new_price == '') {
				$show = "hidden";
				$percent = 0;
				$new_price = $price;
			} else {
				$percent = round(($price - $new_price)/($price/100), 0);
				$show = "show";
			}
			echo "
				<div class='col-lg-3 col-md-3 col-sm-6 col-xs-6'>
					<div class='product-item'>
						<div class='product-image'>
							<img src='$image'>
						</div>
						<div class='promotion text-center $show'>
							$percent %
							GIẢM
						</div>
						<div class='product-control text-center'>
							<button class='btn'>
								<a href='home.php?addProd_id=" . $prod_id . "'><i class = 'fa fa-cart-plus fa-lg' style='color: #FFF;'></i> Giỏ hàng
							</button>
							<button class='btn'>
								<a href='productDetail.php?prod_id=" . $prod_id . "'><i class = 'fa fa-eye' style='color: #FFF;'></i></a>
							</button>
						</div>

						<div class='caption text-center'>
							<div class='col-xs-12 prod_name'>
							<h4 class = 'text-uppercase'>$name</h4>
							</div>
							<div class='col-xs-6'>
							<span class='price float-left'>".number_format($new_price)."đ</span>
							</div>
							<div class='col-xs-6'>
							<s class='$show float-left'>". number_format($price). "đ</s>
							</div>
						</div>
					</div>
				</div>
			";
		}

		function showProduct($connect, $prod_id){
			if ($connect) {
				$sql = "SELECT products.prod_id, prod_name, material, image, price_in, price_out, date_add, quantity, description, cate_name, views, status, products.delete_at, new_price, date_start, date_end FROM products LEFT JOIN categories ON products.cate_id = categories.cate_id LEFT JOIN promotion ON products.prod_id = promotion.prod_id  WHERE products.prod_id = '$prod_id'";
				$result = $connect->query($sql);
				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					return $row;
				}
				return 0;
				}
		}

		function showProductHot($connect){
			if ($connect) {
				$sql = "SELECT * FROM products WHERE delete_at IS NULL ORDER BY views DESC LIMIT 8";
				$result = $connect->query($sql);
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
							$info = $this->showProduct($connect, $row['prod_id']);
							$image = explode("|", $info['image']);
							$this->showInfoProducthtml($row['prod_id'], $info['prod_name'], $image[0], $info['price_out'], $info['new_price']);
					}
				}
			}
		}

		function showProductHotSell($connect){
			if ($connect) {
				$sql = "SELECT products.prod_id, SUM(ords_prods.quantity) FROM ords_prods, products WHERE products.prod_id = ords_prods.prod_id AND products.delete_at IS NULL GROUP BY(ords_prods.prod_id) ORDER BY SUM(ords_prods.quantity) DESC LIMIT 8;";
				$result = $connect->query($sql);
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$info = $this->showProduct($connect, $row['prod_id']);
						$image = explode("|", $info['image']);
						$this->showInfoProducthtml($row['prod_id'], $info['prod_name'], $image[0], $info['price_out'], $info['new_price']);
					}
				}
			}
		}

		function showProductPromotion($connect){
			if ($connect) {
				$sql = "SELECT * FROM promotion, products WHERE products.prod_id = promotion.prod_id AND products.delete_at IS NULL  ORDER BY new_price DESC LIMIT 8";
				$result = $connect->query($sql);
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$info = $this->showProduct($connect, $row['prod_id']);
						$image = explode("|", $info['image']);
						$this->showInfoProducthtml($row['prod_id'], $info['prod_name'], $image[0], $info['price_out'], $info['new_price']);
					}
				}
			}
		}

	}


	function showSlide($connect){
		if ($connect) {
			$sql = "SELECT * FROM slides";
			$result = $connect->query($sql);
			if ($result->num_rows > 0) {
				$count = 1;
			while($row = $result->fetch_assoc()) {
					if ($count == 1) {
						$active = "active";
					}else $active = "";
					echo "
						<div class='item $active'>
					        <img src='".$row['img_url']."' style='width:100%;'>
					    </div>
					";
					$count++;
				}
			}
		}
	}

	function chooseImage($target, $name){
		$target_dir = $target."/";
		if ($target == "avatars") {
			$target_file = $target_dir . basename($_FILES["$name"]["name"]);
		}else $target_file = $target_dir . basename($_FILES["$name"]["name"])."|";
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		// Check file size
		if ($_FILES["$name"]["size"] > 500000) {
			echo "<script>console.log('Sorry, your file is too large.')</script>";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "<script>console.log('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
		    $uploadOk = 0;
		}
		if ($uploadOk == 0) {
			echo "<script>console.log('Sorry, your file was not uploaded.')</script>";
		} else{
			if (move_uploaded_file($_FILES["$name"]["tmp_name"], $target_file)) {
				echo "<script>console.log('The file has been uploaded.')</script>";
		    } else {
		    	echo "<script>console.log('Sorry, there was an error uploading your file.')</script>";
		    }
		}
		return $target_file;
	}

	function showAllUsers($connect){
		if ($connect) {
			$sql = "SELECT * FROM users";
			$result = $connect->query($sql);
			$stt = 1;
			if ($result->num_rows > 0) {
				echo "<table class='table table-bordered'>
							    <thead style='background: #c299ff'>
							      <tr>
							      	<th>STT</th>
							        <th>UserName</th>
							        <th>Họ Tên</th>
							        <th>Ngày Sinh</th>
							        <th>Giới Tính</th>
							        <th>Vai Trò</th>
							        <th>Tình Trạng</th>
							        <th>Đăng Nhập Cuối</th>
							        <th>Thao Tác</th>
							      </tr>
							    </thead>
							    <tbody>";
			    while($row = $result->fetch_assoc()) {
			    	$show = "show";
			    	if ($row['is_active'] == 0 & $row['delete_at'] != "") {
			    		$show = "hidden";
			    	}
			    	if ($row['is_active'] == 0) {
			    		$color = 'red';
			    	}else $color = '#1ac6ff';
			    	$deleteUrl = "administrator.php?username=" . $row['username'];
			    	echo "
			    		<tr style='color: $color'> <td>$stt</td>
				        <td>" . $row['username'] . "</td>
				        <td>" . $row['last_name']." " .$row['first_name']. "</td>
				        <td>" . $row['birthday'] . "</td>
				        <td>" . $row['gender'] . "</td>
				        <td>" . $row['u_role'] . "</td>
				        <td>" . $row['is_active'] . "</td>
				        <td>" . $row['last_access'] . "</td>
				        <td class = 'text-center'>
				        	<a href='administrator.php?viewUsername=" . $row['username'] . "#views'><i class = 'fa fa-eye' style='color: #3399ff;'></i></a>
									<a class = '$show' type=\"button\" name=\"delete\" value=\"Delete\" onClick=\"confirmDelete('" .$deleteUrl. "')\" ><i class = 'fa fa-trash-o' style='color: red;'></i></a>
				        </td>
				      </tr>
			    	";
			    	$stt++;
			    }
			    echo "</tbody>
							  </table>";
			} else {
			    echo "0 results";
			}
		}
	}

	function showCart($connect, $username){
		if ($connect) {
			$sql = "SELECT orders.order_id, prod_id, quantity FROM ords_prods, orders WHERE ords_prods.order_id = orders.order_id AND username = '$username' AND orders.status = 0";
			$result = $connect->query($sql);
			$user = new user();
			$infoUser = $user->showInfo($connect, $username);
			$order_id = getOrderIDNotYetOrder($connect, $username);
			if ($result->num_rows > 0) {
				$_SESSION['order_id'] = $order_id;
			  $_SESSION['ajaxs'] = [];
				
				$total = totalPriceInOrder($connect, getOrderIDNotYetOrder($connect, $username));
				echo "<table class='table'>
							    <thead style='background: #c299ff'>
							      <tr class = 'text-center'>
							        <th><input type='checkbox'></th>
							        <th>Sản Phẩm</th>
							        <th>Đơn Giá</th>
							        <th>Số Lượng</th>
							        <th>Số Tiền</th>
							        <th>Thao tác</th>
							      </tr>
							    </thead>
							    <tbody>";
			    while($row = $result->fetch_assoc()) {
						array_push($_SESSION['ajaxs'], $row['prod_id']);
			    	$prod_id = $row['prod_id'];
			    	$prod = new product();
			    	$info = $prod->showproduct($connect, $row['prod_id']);
			    	$image = explode("|", $info['image']);
			    	if ($info['new_price'] == "") {
					 		$show = "hidden";
					 		$percent = 0;
					 		$info['new_price'] = $info['price_out'];
					 	}else $show = "show";
					 $deleteurl = "cart.php?deleteProd_id=$prod_id&deleteOrder_id=".$row['order_id'];
			    	echo "
			    		
		             	<form method = 'GET' action='' name = 'form'>
			    		<tr>
			    			<td> <input type='checkbox' value = '".$row['prod_id'] ."'> </td>
				        <td> <img src='$image[0]' width = '150px'>". $info['prod_name'] . "</td>
				        <td id='price".$row['prod_id']."'> <s class = '$show'>" . number_format($info['price_out'])." đ</s>". number_format($info['new_price']). "đ</td>
				        <td>
		             	<button type='button' id='minus" . $row['prod_id'] . "'class='btn minus'>-</button>&nbsp;
		             		<input id='".$row['prod_id']."' type='text' name='quantity' style='width:50px;' value='".$row['quantity']."'>
		             	<button type='button' id='plus" . $row['prod_id'] . "'class='btn plus' id='plus'>+</button> 
		             	</td>
				        <td id='total".$row['prod_id']."'>" . number_format($info['new_price']* $row['quantity']). "</td>
				        <td class = 'text-center'>
									<a type=\"button\" name=\"delete\" value=\"Delete\" onClick=\"confirmDelete('" .$deleteurl. "')\"><i class = 'fa fa-trash-o' style='color: red;'></i></a>
				        </td>
				      </tr>
				     </form>
			    	";
			    }
			    echo "</tbody>
							  </table>";
					if ($total=="") {
						echo "<h3>CHƯA CÓ SẢN PHẨM TRONG GIỎ HÀNG</h3>";
					}else{
						echo "<div class='col-xs-5'>
									
							 	</div>
							 <div class='col-xs-7 float-right' id='totalPrice'>
							 	<form method='POST' action=''>
							 	<div id='address' class='col-sm-12' style = 'margin-bottom: 30px;'>
			           	Địa chỉ giao hàng:
			             <input type='text' name='address' class='form-control' placeholder='Địa chỉ giao hàng' value = '".$infoUser['address']."'>
			           </div>
							 		<b>TỔNG TIỀN: </b>". number_format($total)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							 		<button class = 'btn' type = 'submit' name='order'>ĐẶT HÀNG</button>
							 	</form>
							 </div>
							 ";
					}
					
			} else {
			    echo "<div class = 'solugan'>
			    <h3 style='color:red;'>CHƯA CÓ SẢN PHẨM TRONG GIỎ HÀNG</h3>
			    </div>
			    ";
			}
		}
	}	

	function order($connect, $username, $order_address, $prod_id, $quantity){
		if ($connect) {
			$url = $_SESSION['last_url'];
			$sql = "INSERT INTO orders(username, order_date, order_address, status) VALUES('$username', NOW(), '$order_address', 1);";
			if ($connect->query($sql)) {
				$order_id = $connect->insert_id;
				$sql = "INSERT INTO ords_prods VALUES($order_id, '$prod_id', $quantity);";
				$prod = new product();
				$info = $prod->showProduct($connect, $prod_id);
				$updateQuantity = $info['quantity'] - $quantity;
				$sql .= "UPDATE products SET quantity = $updateQuantity WHERE prod_id = '$prod_id'";
				if (mysqli_multi_query($connect, $sql)) {
						echo "<script>
						 alert('Đặt hàng thành công');
						 window.location.replace('..$url');
						</script>";
				}else echo "<script> alert('Có lỗi');</script>";
			}else echo "<script> alert('Có lỗi');</script>";
		}
	}

	function totalPriceInOrder($connect, $order_id){
		if ($connect) {
			$totalPrice = 0;
			$sql = "SELECT * FROM  ords_prods WHERE order_id = $order_id";
			$result = $connect->query($sql);
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					$prod = new product();
					$info = $prod->showproduct($connect, $row['prod_id']);
					if ($info['new_price'] == "") {
						$totalPrice += $info['price_out'] * $row['quantity'];
					}else $totalPrice += $info['new_price'] * $row['quantity'];
				}
				return $totalPrice;
			}else return "";
		}
		return "";
	}

	function showAllProduct($connect, $cate_id){
		if ($connect) {
			if ($cate_id == "") {
				$sql = "SELECT products.prod_id, prod_name, material, image, price_in, price_out, date_add, quantity, description,products.cate_id, cate_name, views, status, products.delete_at, new_price, date_start, date_end FROM products LEFT JOIN categories ON products.cate_id = categories.cate_id LEFT JOIN promotion ON products.prod_id = promotion.prod_id;";
			}else $sql = "SELECT products.prod_id, prod_name, material, image, price_in, price_out, date_add, quantity, description,products.cate_id, cate_name, views, status, products.delete_at, new_price, date_start, date_end FROM products LEFT JOIN categories ON products.cate_id = categories.cate_id LEFT JOIN promotion ON products.prod_id = promotion.prod_id WHERE products.cate_id = '$cate_id';";
			
			$result = $connect->query($sql);
			if ($result->num_rows > 0) {
				echo "<table class='table table-bordered'>
							    <thead style='background: #c299ff'>
							      <tr>
							        <th>ID</th>
							        <th>Tên</th>
							        <th>Vật Liệu</th>
							        <th>Giá Bán</th>
							        <th>Số Lượng</th>
							        <th>Danh Mục</th>
							        <th>Status</th>
							        <th>Thao Tác</th>
							      </tr>
							    </thead>
							    <tbody>";
			    while($row = $result->fetch_assoc()) {
			    	$show = "show";
			    	if ($row['status'] == 0 & $row['delete_at'] != "") {
			    		$show = "hidden";
			    	}
			    	if ($row['status'] == 0) {
			    		$color = 'red';
			    	}else $color = '#1ac6ff';
			    	$deleteUrl = "stocker.php?prod_id=" . $row['prod_id'];
			    	echo "
			    		<tr style='color: $color'>
				        <td>" . $row['prod_id'] . "</td>
				        <td>" . $row['prod_name']. "</td>
				        <td>" . $row['material'] . "</td>
				        <td>" . $row['price_out'] . "</td>
				        <td>" . $row['quantity'] . "</td>
				        <td>" . $row['cate_name'] . "</td>
				        <td>" . $row['status'] . "</td>
				        <td class = 'text-center'>
				        	<a href='stocker.php?cate_id=".$row['cate_id']."&viewProd_id=" . $row['prod_id'] . "#views'><i class = 'fa fa-pencil-square-o' style='color: #3399ff;'></i></a> 
				        	<a class = '$show' type=\"button\" name=\"delete\" value=\"Delete\" onClick=\"confirmDelete('" .$deleteUrl. "')\" ><i class = 'fa fa-trash-o' style='color: red;'></i></a>
				        </td>
				      </tr>
			    	";
			    }
			    echo "</tbody>
							  </table>";
			} else {
			    echo "0 results";
			}
		}
	}

	function getOrderIDNotYetOrder($connect, $username){
		if ($connect) {
			$sql = "SELECT order_id FROM orders WHERE username = '$username' AND status = 0 LIMIT 1;";
			$result=$connect->query($sql);
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				return $row['order_id'];
			}else return "";
		}
		return "";
	}

	function getQuantityProductInOrder($connect, $order_id, $prod_id){
		if ($connect) {
			$sql = "SELECT quantity FROM ords_prods WHERE order_id = '$order_id' AND prod_id = '$prod_id'";
			$result=$connect->query($sql);
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				return $row['quantity'];
			}else return "";
		}
		return "";
	}

	function getTotalQuantityInCartByUser($connect, $username){
		if ($connect) {
			$sql = "SELECT SUM(ords_prods.quantity) AS total FROM ords_prods, orders WHERE ords_prods.order_id = orders.order_id AND username = '$username' AND status = 0";
			$result=$connect->query($sql);
				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					return $row['total'];
				}else return "";
		}
		return "";
	}


	function addToCart($connect, $username, $prod_id, $quantity){
		$url = $_SESSION['last_url'];
		if ($connect) {
			$prod = new product();
			$info = $prod->showproduct($connect, $prod_id);
			$order_id = getOrderIDNotYetOrder($connect, $username);
			if ($order_id == "") {
				$sql = "INSERT INTO orders(username, status) VALUES ('$username', 0)";
				if ($connect->query($sql)) {
					$order_id = getOrderIDNotYetOrder($connect, $username);
					if ($quantity>$info['quantity']) {
						echo "<script>
							 alert('Số Lượng Sản Phẩm Không Đủ');
							</script>";
					}else {
						$sql = "INSERT INTO ords_prods VALUES ('$order_id', '$prod_id', '$quantity')";
						if ($connect->query($sql)) {
							echo "<script>
								 alert('Thêm vào giỏ hàng thành công');
								</script>";
						}else {
							echo "<script>
								 alert('Đã xảy ra lỗi');
								</script>";
							}
					}
				}
			}else {
				$qtt = getQuantityProductInOrder($connect, $order_id, $prod_id);
					if ($qtt == "") {
						if ($quantity>$info['quantity']) {
							echo "<script>
								 alert('Số Lượng Sản Phẩm Không Đủ');
								 window.location.replace('..$url');
								</script>";
						}
						else {
							$sql = "INSERT INTO ords_prods VALUES ('$order_id', '$prod_id', '$quantity')";
							if ($connect->query($sql)) {
								echo "<script>
									 alert('Thêm vào giỏ hàng thành công');
									 window.location.replace('..$url');
									</script>";
							}else {
								echo "<script>
									 alert('Đã xảy ra lỗi');
									 window.location.replace('..$url');
									</script>";
							}
						}
					}else {
						$quantity = $quantity + $qtt;
						if ($quantity>$info['quantity']) {
							echo "<script>
								 alert('Số Lượng Sản Phẩm Không Đủ');
								 window.location.replace('..$url');
								</script>";
						}
						else {
							$sql = "UPDATE ords_prods SET quantity = '$quantity' WHERE order_id = '$order_id' AND prod_id = '$prod_id'";
							if ($connect->query($sql)) {
								echo "<script>
									 alert('Thêm vào giỏ hàng thành công');
									 window.location.replace('..$url');
									</script>";
							}
						}
					}
			}
		}
	}

	function showProductInOrder($connect, $order_id){
		$sql = "SELECT * FROM ords_prods WHERE order_id = '$order_id'";
		$result = $connect->query($sql);
			if ($result->num_rows > 0) {
				echo "<table class='table' style = 'margin-top: 100px;'>
					 <tbody>";
			    while($row = $result->fetch_assoc()) {
			    	$prod = new product();
			    	$info = $prod->showproduct($connect, $row['prod_id']);
			    	$image = explode("|", $info['image']);
			    	if ($info['new_price'] == "") {
					 		$show = "hidden";
					 		$info['new_price'] = $info['price_out'];
					 	}else $show = "show";
			    	echo "
			    		
			    		<tr>
				        <td> <img src='$image[0]' width = '150px'>". $info['prod_name'] . "</td>
				        <td> <s class = '$show'>" . number_format($info['price_out'])." đ</s>". number_format($info['new_price']). "đ</td>
				        <td>". $row['quantity'] . "</td>
				        <td>" . number_format($info['new_price']* $row['quantity']). "</td>
				      </tr>
			    	";
			    }
			    echo "</tbody>
						</table>";
				
			}
	}

	function showOrdered($connect, $username){
		if ($connect) {
			$sql = "SELECT * FROM orders WHERE username = '$username' AND status = 1 AND ship_date < NOW()";
			$result = $connect->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					showProductInOrder($connect, $row['order_id']);

					$total = totalPriceInOrder($connect, $row['order_id']);
					echo "
					<div class= 'col-xs-6'>
					</div>
					<div class= 'col-xs-3' style= 'color: red'>
						Ngày Giao: ".$row['ship_date']. "
					</div>
					<div class= 'col-xs-3'>
						TỔNG TIỀN: ".number_format($total)."
					</div>
				";
				}
			}else echo "
					<div class = 'solugan' style='margin-top: 100px;'>
					<h3>HIỆN TẠI CHƯA CÓ BẤT KÌ ĐƠN HÀNG NÀO</h3>
					</div>
				";
		}
	}

	function deleteOrdering($connect, $order_id){
		if ($connect) {
			$sql = "SELECT prod_id FROM ords_prods WHERE order_id = $order_id";
			$result = $connect->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$prod = new product();
					$info = $prod->showProduct($connect, $row['prod_id']);
					$updateQuantity = $info['quantity'] + getQuantityProductInOrder($connect, $order_id, $row['prod_id']);
					$sql = "UPDATE products SET quantity = $updateQuantity WHERE prod_id = '".$row['prod_id']. "'";
					$connect->query($sql);
				}
			}
			$sql = "DELETE FROM ords_prods WHERE order_id = $order_id";
			if ($connect->query($sql)) {
				$sql= " DELETE FROM orders WHERE order_id = $order_id";
				if ($connect->query($sql)) {
					echo "<script> alert('Hủy đơn hàng thành công');</script>";
				}else echo "<script> alert('Chưa hủy được');</script>";
			}
		}
	}

	function showOrdering($connect, $username){
		if ($connect) {
			$sql = "SELECT * FROM orders WHERE username = '$username' AND status = 1 AND (ship_date > NOW() OR ship_date IS NULL)";
			$result = $connect->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					showProductInOrder($connect, $row['order_id']);
					if ($row['ship_date'] == "") {
						$ship_date = " 2 - 3 ngày sau";
					}else $ship_date = $row['ship_date'];
					$total = totalPriceInOrder($connect, $row['order_id']);
					$deleteUrl = "profile.php?order_id=".$row['order_id'];
					echo "
						<div class= 'col-xs-4'>
						Ngày Đặt Hàng: ".$row['order_date']. "
						</div>
						<div class= 'col-xs-4' style= 'color: red'>
							Ngày Giao: $ship_date
						</div>
						<div class= 'col-xs-3'>
							TỔNG TIỀN: ".number_format($total)."
						</div>
						<div class= 'col-xs-1'>
							<a type=\"button\" name=\"delete\" value=\"Delete\" onClick=\"confirmDelete('" .$deleteUrl. "')\" ><i class = 'fa fa-trash-o fa-2x' style='color: red;'></i></a>
						</div>
						
						<hr style = 'border: 1px solid #333333'>;
					";
				}
			}else echo "
					<div class = 'solugan' style='margin-top: 100px;'>
					<h3>HIỆN TẠI CHƯA CÓ BẤT KÌ ĐƠN HÀNG NÀO</h3>
					</div>
				";
		}
	}

	function searchUser($connect, $object, $content){
		if ($connect) {
			unset($_GET['viewUsername']);
			if ($object == "username") {
				$sql = "SELECT * FROM users WHERE username LIKE '%$content%'";
			}else
				$sql = "SELECT * FROM users WHERE first_name LIKE '%$content%' OR last_name LIKE '%$content%'";
			
			$result = $connect->query($sql);
			$stt = 1;
			if ($result->num_rows > 0) {
				echo "<table class='table table-bordered'>
							    <thead style='background: #c299ff'>
							      <tr>
							      	<th>STT</th>
							        <th>UserName</th>
							        <th>Họ Tên</th>
							        <th>Ngày Sinh</th>
							        <th>Giới Tính</th>
							        <th>Vai Trò</th>
							        <th>Tình Trạng</th>
							        <th>Đăng Nhập Cuối</th>
							        <th>Thao Tác</th>
							      </tr>
							    </thead>
							    <tbody>";
			    while($row = $result->fetch_assoc()) {
			    	$show = "show";
			    	if ($row['is_active'] == 0 & $row['delete_at'] != "") {
			    		$show = "hidden";
			    	}
			    	if ($row['is_active'] == 0) {
			    		$color = 'red';
			    	}else $color = '#1ac6ff';
			    	$deleteUrl = "administrator.php?username=" . $row['username'];
			    	echo "
			    		<tr style='color: $color'> <td>$stt</td>
				        <td>" . $row['username'] . "</td>
				        <td>" . $row['last_name']." " .$row['first_name']. "</td>
				        <td>" . $row['birthday'] . "</td>
				        <td>" . $row['gender'] . "</td>
				        <td>" . $row['u_role'] . "</td>
				        <td>" . $row['is_active'] . "</td>
				        <td>" . $row['last_access'] . "</td>
				        <td class = 'text-center'>
				        	<a href='administrator.php?viewUsername=" . $row['username'] . "#views'><i class = 'fa fa-eye' style='color: #3399ff;'></i></a>
									<a class = '$show' type=\"button\" name=\"delete\" value=\"Delete\" onClick=\"confirmDelete('" .$deleteUrl. "')\" ><i class = 'fa fa-trash-o' style='color: red;'></i></a>
				        </td>
				      </tr>
			    	";
			    	$stt++;
			    }
			    echo "</tbody>
							  </table>";
			} else {
			    echo "Không Tìm Thấy";
			}
		}
	}

	function searchProduct($connect, $prod_name){
		if ($connect) {
			$sql = "SELECT products.prod_id, prod_name, material, image, price_in, price_out, date_add, quantity, description,products.cate_id, cate_name, views, status, products.delete_at, new_price, date_start, date_end FROM products LEFT JOIN categories ON products.cate_id = categories.cate_id LEFT JOIN promotion ON products.prod_id = promotion.prod_id WHERE prod_name LIKE '%$prod_name%';";
			
			$result = $connect->query($sql);
			if ($result->num_rows > 0) {
				echo "<table class='table table-bordered'>
							    <thead style='background: #c299ff'>
							      <tr>
							        <th>ID</th>
							        <th>Tên</th>
							        <th>Vật Liệu</th>
							        <th>Giá Bán</th>
							        <th>Số Lượng</th>
							        <th>Danh Mục</th>
							        <th>Status</th>
							        <th>Thao Tác</th>
							      </tr>
							    </thead>
							    <tbody>";
			    while($row = $result->fetch_assoc()) {
			    	$show = "show";
			    	if ($row['status'] == 0 & $row['delete_at'] != "") {
			    		$show = "hidden";
			    	}
			    	if ($row['status'] == 0) {
			    		$color = 'red';
			    	}else $color = '#1ac6ff';
			    	$deleteUrl = "stocker.php?prod_id=" . $row['prod_id'];
			    	echo "
			    		<tr style='color: $color'>
				        <td>" . $row['prod_id'] . "</td>
				        <td>" . $row['prod_name']. "</td>
				        <td>" . $row['material'] . "</td>
				        <td>" . $row['price_out'] . "</td>
				        <td>" . $row['quantity'] . "</td>
				        <td>" . $row['cate_name'] . "</td>
				        <td>" . $row['status'] . "</td>
				        <td class = 'text-center'>
				        	<a href='stocker.php?viewProd_id=" . $row['prod_id'] . "#views'><i class = 'fa fa-pencil-square-o' style='color: #3399ff;'></i></a> 
				        	<a class = '$show' type=\"button\" name=\"delete\" value=\"Delete\" onClick=\"confirmDelete('" .$deleteUrl. "')\" ><i class = 'fa fa-trash-o' style='color: red;'></i></a>
				        </td>
				      </tr>
			    	";
			    }
			    echo "</tbody>
							  </table>";
			} else {
			    echo "0 results";
			}
		}
	}

	function changeQuantityControl($order_id, $id) {
	   echo "
	     <script type='text/javascript'>
	       $('#minus" . $id . "').click(function(){
	         $.ajax({
	           url: 'cart.php?action=minus&order_id=" . $order_id . "&prod_id=" . $id . "',
	           type: 'GET',
	           dataType: 'html',
	           success: function(){
	             if(document.getElementById('" . $id . "').value < 0) {
	               
			          }else {
			          	document.getElementById('" . $id . "').value--;
		              $('#total" . $id . "').load('cart.php #total" . $id . "');
			            $('#totalPrice').load('cart.php #totalPrice');
		              $('#header-right').load('cart.php #header-right');
			          }
	           }
	         });
	       });
	       $('#plus" . $id . "').click(function(){
	         $.ajax({
	           url: 'cart.php?action=plus&order_id=" . $order_id . "&prod_id=" . $id . "',
	           type: 'GET',
	           dataType: 'html',
	           success: function(){
	             document.getElementById('" . $id . "').value++;
	             $('#total" . $id . "').load('cart.php #total" . $id . "');
	             $('#totalPrice').load('cart.php #totalPrice');
	             $('#header-right').load('cart.php #header-right');
		          }
	         });
	       });
	     </script>
	   ";
	}

 	function updateQuantityOnOrder($connect, $order_id, $prod_id, $operator) {
	 	$new_quantity = getQuantityProductInOrder($connect, $order_id, $prod_id);
	 	$url = $_SESSION['last_url'];
	  if ($operator == "minus") {
	    if ($new_quantity > 0) {
	      $new_quantity--;
	    }
	  } elseif ($operator == "plus") {
	    $new_quantity++;
	  }
	  $sql = "UPDATE ords_prods SET quantity = " . $new_quantity . " WHERE order_id = " . $order_id . " AND prod_id = '$prod_id'";
	  if ($connect->query($sql)) {
	    showCart($connect, $_SESSION['username']);
	  }
 	}
 	function searchProductCate($connect, $cate_id, $price, $prod_name){
 		if ($connect) {
 			if ($price == "0") {
 				$str = "";
 			}else if ($price == "1") {
 				$str = "AND (price_out < 300000 OR new_price < 300000)";
 			}else if ($price == "2") {
 				$str = "AND (price_out BETWEEN 300000 AND 500000 OR new_price BETWEEN 300000 AND 500000)";
 			}else if ($price == "3") {
 				$str = "AND (price_out BETWEEN 500000 AND 750000 OR new_price BETWEEN 500000 AND 750000)";
 			}else if ($price == "4") {
 				$str = "AND (price_out BETWEEN 750000 AND 1000000 OR new_price BETWEEN 750000 AND 1000000)";
 			}else if ($price == "5") {
 				$str = "AND (price_out > 1000000 OR new_price > 1000000)";
 			}
 			$sql = "SELECT products.prod_id FROM products LEFT JOIN promotion ON products.prod_id = promotion.prod_id WHERE delete_at IS NULL AND prod_name LIKE '%$prod_name%' AND cate_id LIKE '%$cate_id%' ".$str;
				$result = $connect->query($sql);
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$prod = new product();
							$info = $prod->showProduct($connect, $row['prod_id']);
							$image = explode("|", $info['image']);
							$prod->showInfoProducthtml($row['prod_id'], $info['prod_name'], $image[0], $info['price_out'], $info['new_price']);
					}
				}else echo "
					<div class = 'solugan'>
					<h3>KHÔNG TÌM THẤY SẢN PHẨM NÀO</h3>
					</div>
					";
 		}
 	}
?>	
