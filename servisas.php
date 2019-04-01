<?php
if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "error; Jums reikia užpildyti gauti sąmatą formą!";
}
$name = $_POST['sName'];
$surname = $_POST['sSurname'];
$visitor_email = $_POST['sEmail'];
$phoneNumber = $_POST['sPhoneNumber'];
$address = $_POST['sAddress'];
$city = $_POST['sCity'];

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

$email_from = 'info@mansta.lt';//<== update the email address
$email_subject = "Užsakyti serivsą iš puslapio";
$email_body = "Užsakovo vardas: $name.\n".
		"Užsakovo pavardė: $surname.\n".
		"Užsakovo el. paštas: $visitor_email.\n".
		"Užsakovo Tel. Nr.: $phoneNumber.\n".
		"Užsakovo adresas: $address.\n".
		"Užsakovo miestas: $city.\n".

$to = 'servisas@mansta.lt';//<== update the email address mindaugas.sharpis@gmail.com servisas@mansta.lt
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.
header('Location: acius.html');


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

?>
