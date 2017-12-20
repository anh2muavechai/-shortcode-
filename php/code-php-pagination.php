Câu 3 . Viết 1 đoạn PHP phân trang cho sản phẩm . Mỗi trang 10 SP
<?php
/**
 * Phân Trang
 */

//lấy tổng số record
$sql3 = "
select count(*) as total
from products as p
join products_desc as pc on pc.p_id = p.p_id
where pc.lang = 'vn'
order by p.price asc
";
$result3 = mysqli_query($conn, $sql3);
$total_product = mysqli_fetch_assoc($result3);
$total_records = $total_product['total'];
// end lấy tổng số record

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 10;
$total_page = ceil($total_records / $limit);
// Giới hạn current_page trong khoảng 1 đến total_page
if ($current_page > $total_page){
    $current_page = $total_page;
}
else if ($current_page < 1){
    $current_page = 1;
}
$start = ($current_page - 1) * $limit;
$sql4 = "
select p.p_id,p.maso,pc.p_name,p.price
from products as p
join products_desc as pc on pc.p_id = p.p_id
where pc.lang = 'vn'
order by p.price desc
LIMIT $start, $limit
";
$result4 = mysqli_query($conn, $sql4);
?>

<table width="500" border="1" cellpadding="0" cellspacing="0" align="center">
	<tr>
  	<td>STT</td>
    <td>P ID</td>
    <td>MASO</td>
    <td>TEN SP</td>
    <td>GIA</td>
  </tr>
  <?php
    $i = 1;
    while ($row = mysqli_fetch_assoc($result4)){
      echo '<tr>';
        echo "<td>$i</td>";
        echo '<td>'.$row['p_id'].'</td>';
        echo '<td>'.$row['maso'].'</td>';
        echo '<td>'.$row['p_name'].'</td>';
        echo '<td>'.$row['price'].'</td>';
      echo '</tr>';
      $i++;
    }
  ?>
</table>
<p align="center">	Trang : 
<?php 
// nếu current_page > 1 và total_page > 1 mới hiển thị nút prev
if ($current_page > 1 && $total_page > 1){
    echo '<a href="test_php.php?page='.($current_page-1).'">Prev</a> | ';
}
 
// Lặp khoảng giữa
for ($i = 1; $i <= $total_page; $i++){
    // Nếu là trang hiện tại thì hiển thị thẻ span
    // ngược lại hiển thị thẻ a
    if ($i == $current_page){
        echo '<span>'.$i.'</span> | ';
    }
    else{
        echo '<a href="test_php.php?page='.$i.'">'.$i.'</a> | ';
    }
}
 
// nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
if ($current_page < $total_page && $total_page > 1){
    echo '<a href="test_php.php?page='.($current_page+1).'">Next</a> | ';
}
 ?>
</p>