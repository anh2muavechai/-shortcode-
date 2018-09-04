<?php
// Một regex được đặt trong dấu ngoặc tròn () (khớp với cả regex)

/*Một pattern sẽ bắt đầu bằng dấu "/" và kết thúc cũng bằng dấu "/".
Đằng sau cặp dấu này là 3 ký tự flag:

i: không phân biệt hoa thường
g: so khớp lặp lại với các ký tự khác trong toàn bộ văn bản
m: cho phép so khớp theo từng dòng đối với văn bản đa dòng và có sử dụng cặp "^$".*/

// Một biểu thức ngoặc (xem ví dụ)
	// . (khớp với bất kỳ ký tự nào)
	// ^ (khớp với xâu rỗng ở đầu dòng)
	// $ (khớp với xâu rỗng ở cuối dòng)
	// Ký tự \ được theo sau bởi một trong các ký tự ^.[$()|\*+?{\ (khớp với các ký tự đặc biệt tương ứng)
	// Một ký tự (khớp với ký tự đó).
	// Ký tự \ được theo sau bởi một chữ số d khác 0. Nguyên tử này sẽ khớp với chuỗi ký tự giống với chuỗi ký tự được khớp bởi biểu thức con trong ngoặc tròn thứ d (đánh số ngoặc tròn bằng vị trí của mở ngoặc từ trái qua phải). Ví dụ: ([bc])\1 sẽ khớp với bb hoặc cc và không khớp với bc.
	// * Đại diện cho không hoặc nhiều ký tự.
	// + Đại diện cho 1 hoặc nhiều ký tự.
	// ? 1 hoặc không có ký tự nào


//các ký tự đặc biệt
// \d - Chữ số bất kỳ ~ [0-9]
// \D - Ký tự bất kỳ không phải là chữ số (ngược với \d) ~ [^0-9]
// \w - Ký tự từ a-z, A-Z, hoặc 0-9 ~ [a-zA-Z0-9]
// \W - Ngược lại với \w (nghĩa là các ký tự không thuộc các khoảng: a-z, A-Z, hoặc 0-9) ~[^a-zA-Z0-9]
// \s - Khoảng trắng (space)
// \S - Ký tự bất kỳ không phải là khoảng trắng.

// các function
// • preg_match
// • preg_match_all
// • preg_replace
// • preg_replace_callback
// • preg_split

// \{(.*?)\} lấy tất cả ký tự giữa {}
// (([\r\n]+(.*))+ lấy tất cả ký tự
// ký tự xuống dòng [\r\n]
// [^a] ko lấy ký tự a
//{1} lặp lại 1 lần
//{1,3} 1-3 ký tự
// vD

//regex bat dau cua chuoi va ket thuc bang ky tu : /^{\S*}$/


$subject='Give me 10 eggs';
$pattern='~\b(\d+)\s*(\w+)$~';

$success = preg_match($pattern, $subject, $match);
if ($success) {
	echo "Match: ".$match[0]."<br />";
	echo "Group 1: ".$match[1]."<br />";
	echo "Group 2: ".$match[2]."<br />";
}


// Partern kiểm tra trong subject co bang freetuts khong
$pattern = '/^freetuts$/';
$subject = 'freetuts';
if (preg_match($pattern, $subject)){
    echo 'Chuỗi regex so khớp';
}

$pattern = '/^[a-z]{5,10}$/';
$subject = 'fdsfdsa';
if (preg_match($pattern, $subject)){
    echo 'Chuỗi regex so khớp';
}

// Pattern là ký tự bất kỳ dài từ 3 đến 10 ký tự sử dụng dấu .
$pattern = '/^.{3,10}$/';
$subject = '3232';
if (preg_match($pattern, $subject)){
    echo 'Chuỗi regex so khớp';
}

$pattern = '/^A|B$/';
$subject = 'A';
if (preg_match($pattern, $subject)){
    echo 'Chuỗi regex so khớp';
}

// Chuỗi có phải trống hoặc có những chữ cái in thường
$pattern = '/[a-z]*/';
// $pattern = '/[a-z]{0,}/';
$subject = 'dsada';
if (preg_match($pattern, $subject)){
    echo 'Chuỗi regex so khớp';
}

// chuỗi ít nhất có 1 ký tự chữ thường
$pattern = '/[a-z]+/';
$subject = 's';
if (preg_match($pattern, $subject)){
    echo 'Chuỗi regex so khớp';
}

// chuỗi có 1 hoặc không có ký tự thường nào
$pattern = '/[a-z]?/';
$subject = 's';
if (preg_match($pattern, $subject)){
    echo 'Chuỗi regex so khớp';
}

//kiểm tra số sau dấu _
$subject = '製品寸法表fasdf';
$pattern = '/^製品寸法表(_\d+)?$/';



