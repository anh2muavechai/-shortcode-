class ThachPham_Nav_Walker extends Walker_Nav_Menu {
 
 /**
 * Phương thức start_lvl()
 * Được sử dụng để hiển thị các thẻ bắt đầu cấu trúc của một cấp độ mới trong menu. (ví dụ: <ul class="sub-menu">)
 * @param string $output | Sử dụng để thêm nội dung vào những gì hiển thị ra bên ngoài
 * @param interger $depth | Cấp độ hiện tại của menu. Cấp độ 0 là lớn nhất.
 * @param array $args | Các tham số trong hàm wp_nav_menu()
 **/
 public function start_lvl( &$output, $depth = 0, $args = array() )
 {
 
 }
 
 /**
 * Phương thức end_lvl()
 * Được sử dụng để hiển thị đoạn kết thúc của một cấp độ mới trong menu. (ví dụ: </ul> )
 * @param string $output | Sử dụng để thêm nội dung vào những gì hiển thị ra bên ngoài
 * @param interger $depth | Cấp độ hiện tại của menu. Cấp độ 0 là lớn nhất.
 * @param array $args | Các tham số trong hàm wp_nav_menu()
 **/
 public function end_lvl( &$output, $depth = 0, $args = array() )
 {
 
 }
 
 /**
 * Phương thức start_el()
 * Được sử dụng để hiển thị đoạn bắt đầu của một phần tử trong menu. (ví dụ: <li id="menu-item-5"> )
 * @param string $output | Sử dụng để thêm nội dung vào những gì hiển thị ra bên ngoài
 * @param string $item | Dữ liệu của các phần tử trong menu
 * @param interger $depth | Cấp độ hiện tại của menu. Cấp độ 0 là lớn nhất.
 * @param array $args | Các tham số trong hàm wp_nav_menu()
 * @param interger $id | ID của phần tử hiện tại
 **/
 public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
 {
 
 }
 
 /**
 * Phương thức end_el()
 * Được sử dụng để hiển thị đoạn kết thúc của một phần tử trong menu. (ví dụ: </li> )
 * @param string $output | Sử dụng để thêm nội dung vào những gì hiển thị ra bên ngoài
 * @param string $item | Dữ liệu của các phần tử trong menu
 * @param interger $depth | Cấp độ hiện tại của menu. Cấp độ 0 là lớn nhất.
 * @param array $args | Các tham số trong hàm wp_nav_menu()
 * @param interger $id | ID của phần tử hiện tại
 **/
 public function end_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
 {
 
 }
} // end ThachPham_Nav_Walker