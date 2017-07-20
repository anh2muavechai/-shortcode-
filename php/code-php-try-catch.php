<?php
    $so1 = 10;
    $so2 = 0;   
    try {
         
        $ketqua = $so1 / $so2; //Xay ra loi vi $so = 0
 
    }
    catch (Exception $e)
    {
        echo 'Loi xay ra: ',  $e->getMessage(), "\n";
    }
     
    echo "Tong hai so la: $ketqua <br>";
?>

+ getMessage() - lấy chuỗi thông báo của ngoại lệ

+ getCode() - lấy mã ngoại lệ

+ getfile() - lấy tên file nguồn

+ getline() - lấy dòng gây ra lỗi

+ getTrace() - lấy dấu vết lỗi

+ getTraceAsString() - lấy chuỗi dấu vết