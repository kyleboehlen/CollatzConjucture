<?PHP
include_once('tbs_class.php');

$tbs = new clsTinyButStrong;
$tbs->LoadTemplate('home.html');

$output = '';

function collatzLargestDenom($min, $max){
	$denom = 0;
	$cycles = 0;
	for($i = $min; $i <= $max; $i++){
		$cycles = 1;
		$n = $i;
		while($n != 1){
			if(fmod($n, 2) == 1){
				$n = $n * 3 + 1;
			}else{
				$n = $n / 2;
			}
			$cycles++;
		}

		if($cycles > $denom){
			$denom = $cycles;
		}
	}
	return $min." ".$max." ".$denom;
}


if(isset($_FILES['txtFileInput'])){
	$txt_file_input = basename($_FILES['txtFileInput']['name']);
	$file_type = pathinfo($txt_file_input, PATHINFO_EXTENSION);
	
	if($file_type != "txt"){
		$output = "Not a valid text file.";
		$tbs->Show();
		exit();
	}
	
	move_uploaded_file($_FILES['txtFileInput']['tmp_name'], $txt_file_input);
	
	$output = "Output: <br />";
	
	$input = file($txt_file_input);
	foreach($input as $line){
		if(strlen($line) > 0){
			$min = strstr($line, " ", true);
			$max = substr($line, strpos($line, " ") + 1);
			$output = $output.collatzLargestDenom($min, $max)."<br />";
		}
	}
}else{
	$output = "Please upload a text file";
}

$tbs->Show();
?>