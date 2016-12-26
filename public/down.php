<?
	//주소값 저장
    $file = urldecode($_GET['file']);
    $file_name = urldecode($_GET['file_name']);
	$dir = "../data/attach/{$file_name}";
	
	//헤더 설정
	header('Content-Type:application/x-octetstream');
	header('Content-Length: '.filesize($dir));
	header('Content-Disposition:attachment; filename='.$file);
	header('Content-Transfer-Encoding:binary');
		
	$fp = fopen($dir, 'r');
	fpassthru($fp);
	fclose($fp);	
?>