<?php
require '_common.php';

header( "Content-type: application/vnd.ms-excel" );   
header( "Content-type: application/vnd.ms-excel; charset=utf-8");  
header( "Content-Disposition: attachment; filename = member.xls" );   
header( "Content-Description: PHP4 Generated Data" );   
  
if($_GET['company']) $_SESSION['company'] = $_GET['company'];
$company_id = $_SESSION['company'];

$qs = mysql_query("SELECT `user`.*
                   FROM `user`
                   ORDER BY `user`.`idx`");
$result = mysql_query($qs);  
  
// 테이블 상단 만들기  
$EXCEL_STR = "  
<table border='1'>  
<tr>  
   <td>이름</td>  
   <td>이메일</td>
   <td>연락처</td>
</tr>";  


  
while($row = mysql_fetch_array($qs)) {  
   $EXCEL_STR .= "  
   <tr>  
       <td>".$row['name']."</td>  
       <td>".$row['email']."</td>  
       <td>".$row['phone']."</td>  
   </tr>  
   ";  
}  
  
$EXCEL_STR .= "</table>";  
  
echo "<meta content=\"application/vnd.ms-excel; charset=UTF-8\" name=\"Content-type\"> ";  
echo $EXCEL_STR;  
