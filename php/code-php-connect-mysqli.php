<?php
CREATE TABLE IF NOT EXISTS `customer` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` VARCHAR(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` VARCHAR(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
 
INSERT INTO `customer` (`id`, `name`, `phone`, `address`) VALUES
(1, 'Nguyen Van A', '0970 306 603', NULL),
(2, 'Nguyen Van B', '0970 306 603', NULL),
(3, 'Nguyen Van C', '0970 306 603', NULL),
(4, 'Nguyen Van D', '0970 306 603', NULL);

$conn = mysqli_connect('localhost', 'root', 'vertrigo', 'demo') or die ('Không thể kết nối tới database');
// Câu truy vấn
$sql = 'SELECT * FROM CUSTOMER';
 
// Thực hiện câu truy vấn, hàm này truyền hai tham số vào là biến kết nối và câu truy vấn
$result = mysqli_query($conn, $sql);
 
// Nếu thực thi không được thì thông báo truy vấn bị sai
if (!$result){
    die ('Câu truy vấn bị sai');
}
 
// Lặp qua kết quả và in ra ngoài màn hình
// Vì các field trong database là id, name, phone, address nên
// khi vardum mang sẽ có cấu trúc tương tự
while ($row = mysqli_fetch_assoc($result)){
    echo '<pre>';
    print_r( $row );
    echo '</pre>';
    //exit;
}
 
// Xóa kết quả khỏi bộ nhớ
mysqli_free_result($result);
 
// Sau khi thực thi xong thì ngắt kết nối database
mysqli_close($conn);
