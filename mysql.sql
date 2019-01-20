DROP DATABASE IF EXISTS sell_leather;
CREATE DATABASE sell_leather;
ALTER DATABASE `sell_leather` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sell_leather;
DROP TABLE IF EXISTS `users`;

CREATE TABLE slides(
	slide_id INT(11) auto_increment PRIMARY KEY,
    img_url VARCHAR(255)
);



INSERT INTO slides(img_url)
VALUES
	('Image/slider1.png'),
    ('Image/slider2.png'),
    ('Image/slider3.png'),
    ('Image/slider4.png');

CREATE TABLE `users`(
	`username` VARCHAR(50) NOT NULL PRIMARY KEY,
	`password` VARCHAR(255) NOT NULL,
	`avatar_url` VARCHAR(255),
	`first_name` VARCHAR(50) NOT NULL,
	`last_name` VARCHAR(50) NOT NULL,
	`birthday` DATE,
	`gender` VARCHAR(10),
	`email` VARCHAR(100),
	`address` VARCHAR(100),
	`phone` VARCHAR(11),
	`creation_date` DATETIME,
	`u_role` VARCHAR(50) NOT NULL,
	`last_access` DATE,
	`is_active` BOOLEAN NOT NULL,
    `delete_at` date
);

CREATE TABLE employees(
	emp_id VARCHAR(10) PRIMARY KEY,
    emp_name VARCHAR(255),
    identify_card_num INT(11),
    address VARCHAR(255),
    email VARCHAR(255),
    salary INT(11)
);

CREATE TABLE shippers(
	ship_id VARCHAR(10) PRIMARY KEY,
    ship_name VARCHAR(255),
    company VARCHAR(255),
    phone VARCHAR(11)
);

CREATE TABLE orders(
	order_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    emp_id VARCHAR(10),
    ship_id VARCHAR(10),
    order_date DATE,
    ship_date DATE,
	delete_date DATE,
    order_address VARCHAR(255),
    status BOOLEAN,
    FOREIGN KEY (username) REFERENCES users (username),
    FOREIGN KEY (emp_id) REFERENCES employees (emp_id),
    FOREIGN KEY (ship_id) REFERENCES shippers (ship_id)
);

CREATE TABLE categories(
	cate_id VARCHAR(10) PRIMARY KEY,
    cate_name VARCHAR(255),
    delete_at date
);


CREATE TABLE products(
	prod_id VARCHAR(10) PRIMARY KEY,
    prod_name VARCHAR(255),
    material VARCHAR(255),
    image nVARCHAR(500),
    price_in INT(11),
    price_out INT(11),
    date_add DATE,
    quantity INT(11),
    description text,
    cate_id VARCHAR(10),
    views int(11),
    status BOOLEAN,
    delete_at date,
    FOREIGN KEY (cate_id) REFERENCES categories (cate_id)
);

/*CREATE TABLE products_detail(
	prod_id VARCHAR(10),
    type VARCHAR(20),
    color VARCHAR(20),
    quantity INT(11),
    FOREIGN KEY (prod_id) REFERENCES products (prod_id),
    PRIMARY KEY(prod_id, type, color)
);
*/

CREATE TABLE promotion(
	prod_id VARCHAR(10),
    new_price INT(11),
    date_start DATE,
    date_end DATE,
    FOREIGN KEY (prod_id) REFERENCES products (prod_id),
    PRIMARY KEY(prod_id,date_start)
);

CREATE TABLE ords_prods(
    order_id INT(11),
    prod_id VARCHAR(10),
    quantity int(11),
    FOREIGN KEY (order_id) REFERENCES orders (order_id),
    FOREIGN KEY (prod_id) REFERENCES products (prod_id),
    PRIMARY KEY(order_id, prod_id)
);

INSERT INTO `users`(username,password,avatar_url,first_name,last_name,birthday,gender,email,address,phone,creation_date,u_role,last_access,is_active)
 VALUES ('administrator', '$2y$10$8Re1K6.OTJ5aPrbMLLFq/e31YVwFaQg8P1s6rfsb96mpqR5v0/Z.W','Image/acount.png',
		 'Ly', 'Đoàn Thị', '1999-11-22', 'Female', 'lydoan.dev@gmail.com','101B Lê Hữu Trác','0348543343',NOW(), 'admin', NOW(), 1),
		 ('stocker', '$2y$10$79ywhulHRpeIB5oPhq0/L.W./lnVt58ahiRzbEGdf0Mwcs2A4mu8C','Image/acount.png',
		 'Ly', 'Đoàn Thị', '1999-11-22', 'Female', 'lydoan.dev@gmail.com','101B Lê Hữu Trác','0348543343',NOW(), 'stocker', NOW(), 1),
		 ('trangtran', '$2y$10$E25hWDbXsIsMxffSQEA6L.o3bCdkQh.1j0OX4UKIz7WE2s3/C240a','Image/cus1.png',
		 'Trang', 'Trần Thị', '1999-11-22', 'Female', 'trangtran.dev@gmail.com','101B Lê Hữu Trác','0348548546',NOW(), 'customer', NOW(), 1),
		 ('nguyenmy', '$2y$10$E25hWDbXsIsMxffSQEA6L.o3bCdkQh.1j0OX4UKIz7WE2s3/C240a','Image/cus2.png',
		 'My', 'Nguyễn Thị', '1999-11-22', 'Female', 'nguyenmy.dev@gmail.com','101B Lê Hữu Trác','0348541548',NOW(), 'customer', NOW(), 1),
		 ('phantrung', '$2y$10$E25hWDbXsIsMxffSQEA6L.o3bCdkQh.1j0OX4UKIz7WE2s3/C240a','Image/cus3.png',
		 'Trung', 'Phan Thị', '1999-11-22', 'Female', 'nguyenmy.dev@gmail.com','101B Lê Hữu Trác','0348541548',NOW(), 'customer', NOW(), 1);
 
 INSERT INTO `employees`
 VALUES ('EMP_01','Nguyễn Thị Thu','20190101','04-Nguyễn Công Trứ-Hà Nội','thunguyen@gmail.com',7000000),
		('EMP_02','Nguyễn Phương Tri','20190102','43-Ba Đình-Hà Nội','tringuyen@gmail.com',7000000),
        ('EMP_03','Hoàng Văn Huy','20190103','13-Nguyễn Văn Thoại-Hà Nội','huyhoang@gmail.com',7000000),
        ('EMP_04','David Jonsh','20190104','04-Hùng Vương-Hà Nội','jonshdavid@gmail.com',7000000),
		('EMP_05','Trần Phương Thảo','20190105','101B-Lê Hữu Trắc-Hà Nội','thaotran@gmail.com',7000000),
		('EMP_06','Elly Trần ','20190106','93-Phạm Văn Đằng-Hà Nội','tranelly@gmail.com',7000000),
		('EMP_07','CrishTorn','20190107','23-Sinh Sắc-Hà Nội','crishtorn@gmail.com',7000000),
		('EMP_08','Leeon','20190108','04-Trưng Trắc-Hà Nội','leeon@gmail.com',7000000),
		('EMP_09','Jimin','20190109','46-Nguyễn Huệ-Hà Nội','jimin@gmail.com',7000000),
		('EMP_10','Min','201910','97-Nguyễn Du-Hà Nội','min@gmail.com',7000000);


INSERT INTO `shippers`
 VALUES ('SP_01','Đặng Văn Toàn','Grap','0354251678'),
		('SP_02','Nguyễn Văn Lâm','Grap','0324157498'),
        ('SP_03','Trần Văn Huy','Grap','0345124514');
 
 
 INSERT INTO `orders`(username, emp_id, ship_id, order_date, ship_date, order_address, status)
 VALUES ('nguyenmy','EMP_01','SP_01','2019-01-11','2019-01-14','56-Nguyễn Văn Thoại-Đà Nẵng','1'),
		 ('trangtran','EMP_02','SP_02','2019-01-20','2019-01-24','43-Nguyễn Công Trứ-Hà Nội','1'),
		 ('phantrung','EMP_02','SP_02','2019-01-14','2019-01-18','102-Hùng Vương-Hồ Chí Minh','1');
 
 
 INSERT INTO `categories`(cate_id, cate_name)
 VALUES ('CATE_01','Túi & Clutch'),
		('CATE_02','Ví da'),
        ('CATE_03','Phụ kiện');
        
 INSERT INTO `products`(prod_id, prod_name, material, image, price_in, price_out, date_add, quantity, description, cate_id, views, status)
 VALUES ('PD_01','CLUTCH HỘP','Da bò','Image/Product/CLUTCHHOP1.jpg|Image/Product/CLUTCHHOP2.jpg|Image/Product/CLUTCHHOP3.jpg|Image/Product/CLUTCHHOP4.jpg|Image/Product/CLUTCHHOP5.jpg'
		,1010000,1020000,'2019-01-01',100,'Đây là phiển bản cải tiến của mẫu Clutch cũ, với phiên bản mới này bạn có thể đựng được rất nhiều vận dụng chỉ trong một chiếc túi da nhỏ gọn.
		Đặc biệt: bên trong có ngăn có thể tách rời ra, sử dụng khi bạn muốn cần nhiều không gian để đồ hơn thì có thể tháo ra','CATE_01',11,1),
		('PD_02','BAO DA ĐỰNG GIẤY ĐĂNG KIỂM XE','Da bò','Image/Product/Bao-da-dang-kiem-xe-1.png|Image/Product/Bao-da-dang-kiem-xe-2.png|Image/Product/Bao-da-dang-kiem-xe-3.png|Image/Product/Bao-da-dang-kiem-xe-4.png',
        450000,495000,'2019-01-01',130,'Sử dụng chất liệu da bò cao cấp, bề mặt mềm mại, được xử lý cẩn thận càng bóng mịn theo thời gian sử dụng. Sản phẩm được may thủ cộng tỉ mỉ và tinh xảo','CATE_02',15,1),
        ('PD_03','DÂY ĐỒNG HỒ DA CÁ SẤU','Da cá sấu ','Image/Product/2Da-ca-sau-1.png|Image/Product/2Da-ca-sau-2.png|Image/Product/Da-ca-sau-3.png|Image/Product/Da-ca-sau-4.png|Image/Product/Da-ca-sau-5.png',
        1425000,1485000,'2019-01-01',160,'Phần da cá sấu được lựa chọn kĩ càng và sản xuất hoàn toàn handmade để đảm bảo chất lượng cho mỗi dây đồng hồ. Có thể thay cho Apple Watch','CATE_03',11,1),
        ('PD_04','PASSPORT VINTAGE','Da bò','Image/Product/PASSPORT-VINTAGE-1.png|Image/Product/PASSPORT-VINTAGE-2.png|Image/Product/PASSPORT-VINTAGE-3.png',
        290000,299000,'2019-01-01',140,'Chi tiết sản phẩm: Chất liệu: Da bò cao cấp 100% Thiết kế: 2 Ngăn chính cực rộng và 4 ngăn thẻ ATM Được thiết kế và sản xuất hoàn toàn thủ công bởi Chúng tôi Màu: Nâu','CATE_02',19,1),
        ('PD_05','BAO DA PASSPORT CHUẨN','Da bò','Image/Product/BAO-DA-PASSPORT-1.png|Image/Product/BAO-DA-PASSPORT-2.png|Image/Product/BAO-DA-PASSPORT-3.png|Image/Product/BAO-DA-PASSPORT-4.png|Image/Product/BAO-DA-PASSPORT-5.png',
        290000,299000,'2019-01-01',210,'Khi du lịch nước ngoài, hộ chiếu (Passport) là vật quan trọng nhất. Vì thế hãy bảo vệ và nâng niu nó bằng 1 chiếc ví đựng Passport Handmade này nhé','CATE_02',23,1),
        ('PD_06','CARDHOLDER - VÍ CARDHOLDER','Da bò','Image/Product/CARDHOLDER-1.png|Image/Product/CARDHOLDER-2.png|Image/Product/CARDHOLDER-3.png|Image/Product/CARDHOLDER-4.png|Image/Product/CARDHOLDER-5.png|Image/Product/CARDHOLDER-6.png',
        320000,350000,'2019-01-01',110,'Thiết kế nhỏ gọn, chuyên để đựng namecard, thẻ. Phù hợp với người thường xuyên phải mang nhiều thẻ, danh thiếp bên người.','CATE_02',127,1),
        ('PD_07','VÍ SỌC ĐÔI','Da bò Pullup','Image/Product/VI-SOC-DOI-1.png|Image/Product/VI-SOC-DOI-2.png|Image/Product/VI-SOC-DOI-3.png|Image/Product/VI-SOC-DOI-4.png|Image/Product/VI-SOC-DOI-5.png',
        420000,450000,'2019-01-01',180,'Chất liệu da bò Pullup, thiết kế hiện đại, bỏ vừa cmnd, giấy tờ xe.','CATE_02',67,1),
        ('PD_08','VÍ GO-MINI','Da bò','Image/Product/GO-MINI-1.png|Image/Product/GO-MINI-2.png|Image/Product/GO-MINI-3.png|Image/Product/GO-MINI-4.png|Image/Product/GO-MINI-5.png',
        215000,225000,'2019-01-01',200,'Thiết kế đơn giản, nhỏ gọn cầm vừa lòng bàn tay có thể dễ dàng bỏ túi trước áo hoặc quần.','CATE_02',45,1),
        ('PD_09','BAO DA MACBOOK HANDMADE','Da bò','Image/Product/BAO-DA-MACBOOK-HANDMADE-1.png|Image/Product/BAO-DA-MACBOOK-HANDMADE-2.png|Image/Product/BAO-DA-MACBOOK-HANDMADE-3.png|Image/Product/BAO-DA-MACBOOK-HANDMADE-4.png|Image/Product/BAO-DA-MACBOOK-HANDMADE-5.png|Image/Product/BAO-DA-MACBOOK-HANDMADE-6.png'
		,705000,715000,'2019-01-01',250,' Chất liệu da bò thật 100%  Bên trong lót 1 lớp nhung mềm   Nắp có gắn nam châm hít chắc chắn  Có đủ loại cho các dòng MACBOOK 11, 12, 13 & 15 inch.  3 màu: Đen / Vàng bò / Xanh dương','CATE_01',34,1),
        ('PD_10','MESSENGER BAG 01 - TÚI DA ĐEO CHÉO 01','Da bò','Image/Product/MESSENGER-BAG-01-1.png|Image/Product/MESSENGER-BAG-01-2.png|Image/Product/MESSENGER-BAG-01-3.png|Image/Product/MESSENGER-BAG-01-4.png'
		,1850000,1950000,'2019-01-01',140,'Chất liệu: Da bò thật 100% Sử dụng: Đựng Ipad, Túi đeo chéo, Túi du lịch  Cam kết: Chúng tôi sẽ hoàn tiền lại nếu túi không phải là da và không giống như hình chụp.','CATE_01',345,1),
        ('PD_11','ZIP AROUND CLUTCH','Da bò','Image/Product/ZIP-AROUND-CLUTCH-1.png|Image/Product/ZIP-AROUND-CLUTCH-2.png|Image/Product/ZIP-AROUND-CLUTCH3.png|Image/Product/ZIP-AROUND-CLUTCH4.png|Image/Product/ZIP-AROUND-CLUTCH5.png|Image/Product/ZIP-AROUND-CLUTCH6.png|Image/Product/ZIP-AROUND-CLUTCH7.png'
		,1150000,1250000,'2019-01-01',190,'Chất liệu: Da bò thật 100%  - Công dụng: đựng vừa Ipad air, Ipad mini, các loại tablet dưới 7.9 inch, điện thoại, sạc dự phòng, bút, thẻ visa, tiền mặt, giấy tờ...','CATE_01',122,1),
        ('PD_12','CLUTCH BOSSED','Da bò','Image/Product/CLUTCH-BOSSED-1.png|Image/Product/CLUTCH-BOSSED-2.png|Image/Product/CLUTCH-BOSSED-3.png|Image/Product/CLUTCH-BOSSED-4.png|Image/Product/CLUTCH-BOSSED-5.png'
		,1010000,1020000,'2019-01-01',255,'Hãy thử tưởng tượng tất cả các vận dụng: Ipad, điện thoại, bút, sạc đa năng, thẻ ATM, tiền mặt... đều có thể bỏ gọn gàng trong chiếc CLUTCH này, quá tiện phải không nào? Chất liệu: Da bò thật 100%','CATE_01',678,1),
        ('PD_13','CLUTCH DA','Da bò','Image/Product/CLUTCH-1.png|Image/Product/CLUTCH-2.png|Image/Product/CLUTCH-3.png|Image/Product/CLUTCH-4.png|Image/Product/CLUTCH-5.png|Image/Product/CLUTCH-6.png|Image/Product/CLUTCH-7.png'
		,840000,850000,'2019-01-01',170,'Hãy thử tưởng tượng tất cả các vận dụng: Ipad, điện thoại, bút, sạc đa năng, thẻ ATM, tiền mặt... đều có thể bỏ gọn gàng trong chiếc CLUTCH này, quá tiện phải không nào? Khi bạn đi cafe, đi hội họp, đi chơi... chỉ cần cầm tay chiếc CLUTCH này đã đủ các phụ kiện cần thiết, đặc biệt nó còn bỏ vừa trong cốp xe máy nữa Chất liệu: Da bò thật 100%','CATE_01',150,1),
        ('PD_14','TÚI XÁCH DA ĐA NĂNG','Da bò','Image/Product/Tui-xach-da-da-nang-1.png|Image/Product/Tui-xach-da-da-nang-2.png|Image/Product/Tui-xach-da-da-nang-3.png|Image/Product/Tui-xach-da-da-nang-4.png|Image/Product/Tui-xach-da-da-nang-5.png'
		,3940000,3950000,'2019-01-01',235,'Chất liệu: Chất liệu da bò thật 100% Màu: Nâu Công dụng: đựng vừa các loại macbook 13 trở xuống, thẻ, bút, tiền mặt, hộ chiếu, điện thoại...','CATE_01',444,1),
        ('PD_15','THREEFOLD CLUTCH','Da bò','Image/Product/THREEFOLD-CLUTCH-1.png|Image/Product/THREEFOLD-CLUTCH-2.png|Image/Product/THREEFOLD-CLUTCH-3.png|Image/Product/THREEFOLD-CLUTCH-4.png|Image/Product/THREEFOLD-CLUTCH-5.png|Image/Product/THREEFOLD-CLUTCH-6.png'
		,1440000,1450000,'2019-01-01',185,' Công dụng: đựng vừa Ipad air, Ipad mini, các loại tablet dưới 9.7 inches , điện thoại, sạc dự phòng, bút, thẻ visa, tiền mặt, giấy tờ.. Chất liệu: Da bò thật 100%','CATE_01',567,1),
        ('PD_16','BAO DA IPHONE','Da bò','Image/Product/BAO-DA-IPHONE-1.png|Image/Product/BAO-DA-IPHONE-2.png|Image/Product/BAO-DA-IPHONE-3.png|Image/Product/BAO-DA-IPHONE-4.png|Image/Product/BAO-DA-IPHONE-5.png|Image/Product/BAO-DA-IPHONE-6.png',
        150000,300000,'2019-01-01',275,'Thiết kế và sản xuất 100% thủ công với chất liệu da bò nhập khẩu, đảm bảo bạn sẽ quẳng ngay chiếc vỏ iPhone nhựa đến từ Trung Quốc nếu được “sờ thử” chiếc bao da iPhone này.','CATE_03',654,1),
        ('PD_17','BAO DA MACBOOK LEO','Da bò','Image/Product/BAO-DA-MACBOOK-LEO-1.png|Image/Product/BAO-DA-MACBOOK-LEO-2.png|Image/Product/BAO-DA-MACBOOK-LEO-3.png|Image/Product/BAO-DA-MACBOOK-LEO-4.png',
        640000,650000,'2019-01-01',220,'Bên trong lót 1 lớp nhung giúp bảo vệ Macbook trầy xước, không sợ bị va chạm, rơi rớt. Ngoài công dụng giúp bảo vệ Macbook như 1 chiếc bao chống xóc, bao da Macbook LEO còn có thể kê làm kệ để Macbook giúp chống mỏi lưng.','CATE_03',234,1),
        ('PD_18','DÂY DA ĐỒNG HỒ VEG Ý','Da bò','Image/Product/VEG-Y-1.png|Image/Product/VEG-Y-2.png|Image/Product/VEG-Y-3.png',
        840500,841500,'2019-01-01',145,'Không cần phải nói gì nhiều, nhìn qua những bức ảnh quý khách cũng thấy được được vẻ đẹp hoàn hảo, tỉ mỉ qua từng đường kim mũi chỉ rồi.','CATE_03',554,1),
        ('PD_19','LEATHER CASE IPHONE ','Da bò','Image/Product/LEATHER-CASE-IPHONE-1.png|Image/Product/LEATHER-CASE-IPHONE-2.png|Image/Product/LEATHER-CASE-IPHONE-3.png|Image/Product/LEATHER-CASE-IPHONE-4.png',
        170000,180000,'2019-01-01',285,'Được làm từ chất liệu da bò Napan nhập khẩu từ Ấn Độ, qua bàn tay điêu luyện của thợ thủ công Việt Nam, có thể thấy qua độ tinh xảo, tỉ mỉ của từng đường kim chỉ. Thiết kế 1 ngăn mặt sau ốp lưng có thể để Namecard, thẻ VISA, ATM... rất tiện lợi cho doanh nhân, nhân viên văn phòng, thường xuyên sử dụng namecard và thẻ. Chất liệu: Da bò thật 100%','CATE_03',226,1),
        ('PD_20','DÂY DA ĐỒNG HỒ FC','Da bò','Image/Product/FC-1.png|Image/Product/FC-2.png|Image/Product/FC-3.png|Image/Product/FC-4.png|Image/Product/FC-5.png|Image/Product/FC-6.png',
        930500,940500,'2019-01-01',240,'Dòng dây da đồng hồ FC mới của chúng tôi lấy ý tưởng từ hãng sản xuất đồng hồ nổi tiếng của Frédérique Constant của Thuỵ Sĩ: Luôn chính xác trong từng chi tiết nhỏ và mang lại cảm giác đẳng cấp cho người đeo.','CATE_03',90,1),
        ('PD_21','THẮT LƯNG DA CÁ SẤU','Da cá sấu','Image/Product/VEG-Y-1.png|Image/Product/VEG-Y-2.png|Image/Product/VEG-Y-3.png',
        1920500,1930500,'2019-01-01',155,'Chỉ nhìn qua hình thôi là cũng thấy mê rồi đúng ko? Chất liệu da cá sấu thật 100%, đẹp từng góc cạnh. Chất liệu: Da cá sấu','CATE_03',78,1),
        ('PD_22','THẮT LƯNG THO-01','Da bò','Image/Product/THO-01.png|Image/Product/THO-02.png|Image/Product/THO-03.png|Image/Product/THO-04.png|Image/Product/THO-5.png',
        465200,475200,'2019-01-01',175,'Thiết kế: May 2 lớp da bò, đường may tỉ mỉ, mặt bằng hợp kim cao cấp, không sợ bong chóc Chất liệu: Da cá sấu , Da bò thật 100%','CATE_03',100,1),
		('PD_23','VÍ DA CÁ SẤU','Da cá sấu','Image/Product/Vi-ca-sau-1.png|Image/Product/Vi-ca-sau-2.png|Image/Product/Vi-ca-sau-3.png|Image/Product/Vi-ca-sau-4.png|Image/Product/Vi-ca-sau-5.png|Image/Product/Vi-ca-sau-6.png',
        1400000,1500000,'2019-01-01',280,'Ví da cá sấu dùng càng bóng, đẹp chứ không bị bong, tróc xi như những loại ví làm từ nguồn da cá sấu kém chất lượng khác. (Ví da cá sấu làm từ da kém chất lượng, loại da này thường bị lỗi nên khi lên sản phẩm họ thường phun một lớp xi màu để giấu lỗi.
        Do đó, sau một thời gian sử dụng sản phẩm sẽ bị bay màu, tróc xi nhìn rất xấu)','CATE_02',101,1),
        ('PD_24','ESTY LONG WALLET - VÍ DÀI ESTY','Da bò','Image/Product/ESTY-LONG-WALLET-1.png|Image/Product/ESTY-LONG-WALLET-2.png',
        560000,570000,'2019-01-01',285,' Đựng vừa tất cả các loại điện thoại Esty Long Wallet - Ví Dài Esty','CATE_02',179,1),
        ('PD_25','WINGBACK WALLET - VÍ WINGBACK','Da bò','Image/Product/WINGBACK-WALLET-1.png|Image/Product/ESTY-LONG-WALLET-2.png|Image/Product/ESTY-LONG-WALLET-3.png|Image/Product/ESTY-LONG-WALLET-4.png',
        250000,270000,'2019-01-01',245,'Thiết kế siêu nhỏ gọn, nhưng vẫn được 10-12 thẻ và khoảng 20-30 tờ tiền mặt','CATE_02',120,1),
        ('PD_26','MONEY CLIP - VÍ KẸP TIỀN','Da bò','Image/Product/MONEY-CLIP-1.png|Image/Product/MONEY-CLIP-2.png|Image/Product/MONEY-CLIP-3.png|Image/Product/MONEY-CLIP-4.png|Image/Product/MONEY-CLIP-5.png',
        275000,300000,'2019-01-01',200,'Ví kẹp tiền cao cấp là giải pháp cho những người có nhiều thẻ ngân hàng, muốn tìm một chiếc ví nhỏ gọn và tiện dụng.','CATE_02',110,1),
        ('PD_27','MINI COIN WALLET - VÍ MINI COIN','Da bò','Image/Product/2MINI-COIN-WALLET-1.png|Image/Product/2MINI-COIN-WALLET-2.png|Image/Product/2MINI-COIN-WALLET-3.png|Image/Product/2MINI-COIN-WALLET-4.png|Image/Product/2MINI-COIN-WALLET-5.png',
        390000,410000,'2019-01-01',225,'Nhỏ gọn, vừa đủ để thẳng tiền, có 1 ngăn lật để hình thẻ, có ngăn hộp để sim, tiền xu...','CATE_02',135,1),
        ('PD_28','VÍ PHỐI SAFFIANO','Da bò','Image/Product/Vi-phoi-SAFFIANO-1.png|Image/Product/Vi-phoi-SAFFIANO-2.png|Image/Product/Vi-phoi-SAFFIANO-3.png|Image/Product/Vi-phoi-SAFFIANO-4.png|Image/Product/Vi-phoi-SAFFIANO-5.png|Image/Product/Vi-phoi-SAFFIANO-6.png|Image/Product/Vi-phoi-SAFFIANO-7.png',
        400000,450000,'2019-01-01',260,'Với chất liệu da bò saffiano sang trọng, các thiết thế của chúng tôi đã lấy sọc trắng làm điểm nhất của chiếc ví, rất thời trang và hiện đại.','CATE_02',100,1),
        ('PD_29','TRIFOLD WALLET - VÍ GẬP 3','Da bò','Image/Product/TRIFOLD-WALLET-1.png|Image/Product/TRIFOLD-WALLET-2.png|Image/Product/TRIFOLD-WALLET-3.png|Image/Product/TRIFOLD-WALLET-4.png|Image/Product/TRIFOLD-WALLET-5.png',
        390000,420000,'2019-01-01',300,'Thiết kế đặc biệt gập 3, nhìn bề ngoài ví rất nhỏ gọn tuy nhiên khi mở rộng ra thì lại có chiều ngang dài hơn ví thông thường.','CATE_02',20,1),
        ('PD_30','BAO DA IPHONE V2','Da bò','Image/Product/BAO-DA-IPHONE-V2-1.png|Image/Product/BAO-DA-IPHONE-V2-2.png|Image/Product/BAO-DA-IPHONE-V2-3.png|Image/Product/BAO-DA-IPHONE-V2-4.png|Image/Product/BAO-DA-IPHONE-V2-5.png',
        400000,500000,'2019-01-01',100,'Sử dụng chất liệu da bò được xử lí đúng tiêu chuẩn càng dùng da sẽ càng bóng mịn và mềm mại đặc trưng theo thời gian. Ngoài ra mẫu còn có thiết kế dây rút giúp việc lấy điện thoại cực kì dễ dàng','CATE_03',50,1),
        ('PD_31','DÂY DA ĐỒNG HỒ QUYN','Da bò','Image/Product/QUYN-1.png|Image/Product/QUYN-2.png|Image/Product/QUYN-3.png|Image/Product/QUYN-4.png|Image/Product/QUYN-5.png',
        792000,1100000,'2019-01-01',150,'Không cần phải nói gì nhiều, nhìn qua những bức ảnh quý khách cũng thấy được được vẻ đẹp hoàn hảo, tỉ mỉ qua từng đường kim mũi chỉ rồi.','CATE_03',60,1),
        ('PD_32','DÂY DA ĐỒNG HỒ PH01 HANDMADE','Da bò','Image/Product/PH01-HANDMADE-1.png|Image/Product/PH01-HANDMADE-2.png|Image/Product/PH01-HANDMADE-3.png|Image/Product/PH01-HANDMADE-4.png|Image/Product/PH01-HANDMADE-5.png|Image/Product/PH01-HANDMADE-6.png',
        544500,590000,'2019-01-01',80,'Sản phẩm được làm thủ công tỉ mỉ bởi các nghệ nhân lành nghề trong làng da Việt. Với chất liệu da bò cao cấp, bề mặt da mềm min, dây mềm cong theo cổ tay của người đeo.','CATE_03',60,1);
        
INSERT INTO `promotion`
 VALUES ('PD_01',910000,'2019-01-18','2019-01-21'),
		('PD_02',250000,'2019-01-18','2019-01-21'),
        ('PD_03',1225000,'2019-01-18','2019-01-21'),
        ('PD_04',190000,'2019-01-18','2019-01-21'),
        ('PD_05',190000,'2019-01-18','2019-01-21'),
		('PD_06',220000,'2019-01-18','2019-01-21'),
        ('PD_07',320000,'2019-01-18','2019-01-21'),
        ('PD_08',115000,'2019-01-18','2019-01-21'),
        ('PD_09',605000,'2019-01-18','2019-01-21'),
        ('PD_10',1750000,'2019-01-18','2019-01-21');

UPDATE users SET delete_at = CURDATE() WHERE username = 'trangtran';    

CREATE TABLE listProductLove(
	username VARCHAR(50),
    prod_id VARCHAR(10),
	PRIMARY KEY(username, prod_id),
	FOREIGN KEY (username) REFERENCES users (username),
	FOREIGN KEY (prod_id) REFERENCES products (prod_id)
);

INSERT INTO listProductLove
VALUES ('phantrung', 'PD_01'),
('phantrung', 'PD_02'),
('phantrung', 'PD_03'),
	('nguyenmy', 'PD_01'),
('nguyenmy', 'PD_02'),
('nguyenmy', 'PD_03'),
	('phantrung', 'PD_04'),
('phantrung', 'PD_05'),
('phantrung', 'PD_06'),
	('nguyenmy', 'PD_07'),
('nguyenmy', 'PD_08'),
('nguyenmy', 'PD_09');  
        
INSERT INTO `ords_prods`
 VALUES (1,'PD_01',1),
		(2,'PD_02',1),
        (3,'PD_03',1),
        (1,'PD_04',1),
        (2,'PD_05',1),
        (3,'PD_06',1),
        (1,'PD_07',1),
        (2,'PD_08',1); 
SELECT * FROM products LEFT JOIN promotion ON products.prod_id = promotion.prod_id WHERE delete_at IS NULL AND prod_name LIKE '%%' AND cate_id LIKE '%CATE_03%'