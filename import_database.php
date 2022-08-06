<?php
$conn =new mysqli('localhost', 'root', '' , 'new_db1');
// print_r($_FILES);
$filename = $_FILES['file']['name'];
// $fileType = $_FILES['file']['type'];
// // $fileError = $_FILES['file']['error'];
// $fileContent = file_get_contents($_FILES['file']['tmp_name']);
    
// echo $filename;
$query = '';
$sqlScript = file($filename);
foreach ($sqlScript as $line)	{
	
	$startWith = substr(trim($line), 0 ,2);
	$endWith = substr(trim($line), -1 ,1);
	
	if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
		continue;
	}
		
	$query = $query . $line;
	if ($endWith == ';') {
		mysqli_query($conn,$query) or die('<div class="error-response sql-import-response">Problem in executing the SQL query <b>' . $query. '</b></div>');
		$query= '';		
	}
}
echo '1';
?>