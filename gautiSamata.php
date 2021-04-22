<?php
if(!isset($_POST['send']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "error; Jums reikia užpildyti gauti sąmatą formą!";
}
$name = $_POST['name'];
$visitor_email = $_POST['email'];
$vietove = $_POST['vietove'];
$phoneNumber = $_POST['phoneNumber'];
$radioOne = $_POST['radioOne'];
$radioTwo = $_POST['radioTwo'];
$metrai = $_POST['metrai'];
$radioThree = $_POST['radioThree'];
$radioFour = $_POST['radioFour'];
$fileToUpload = $_POST['fileToUpload'];

//Validate first
if(empty($name)||empty($visitor_email))
{
    echo "Vardas ir el. Paštas yra privalomi!";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Blogas el.pašto adresas!";
    exit;
}

$email_from = 'info@mansta.lt';//<== update the email address mindaugas.sharpis@gmail.com info@mansta.lt
$email_subject = "Gauti sąmatą iš puslapio";
$email_body = "Užsakovo vardas: $name.\n".
		"Užsakovo el. paštas: $visitor_email.\n".
		"Užsakovo vietovė: $vietove.\n".
		"Užsakovo Tel. Nr.: $phoneNumber.\n".
		"Žmonių skaičius: $radioOne.\n".
		"Nuotekų vamzdžio gylis iš pastato: $radioTwo.\n".
		"Kiek metrų reikės visiems montavimo darbams: $metrai.\n".
		"Gruntas Jūsų sklype: $radioThree.\n".
    "Kur išleisime išvalytą vandenį: $radioFour.\n".
    "Nuotekų šalinimo projektas: $fileToUpload.\n".


$to = 'i20blackpearl@gmail.com';//<== update the email address mindaugas.sharpis@gmail.com info@mansta.lt
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.
header('Location: aciu.html');


// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}

// Function uploads file
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

?>
