<?php
/*
This first bit sets the email address that you want the form to be submitted to.
You will need to change this value to a valid email address that you can access.
*/
$webmaster_email = "balsankarbd360@gmail.com";

/*
This bit sets the URLs of the supporting pages.
If you change the names of any of the pages, you will need to change the values here.
*/
$form_page = "http://bookmysarvis.com/weekidz/contact.php";

/*
This next bit loads the form field data into variables.
If you add a form field, you will need to add it here.
*/
$email = $_REQUEST['email'] ;
$message = $_REQUEST['message'] ;
$name = $_REQUEST['name'] ;
$subject = $_REQUEST['subject'] ;
$msg = 
"First Name: " . $name . "\r\n" . 
"Email: " . $email . "\r\n" . 
"Subject: " . $subject . "\r\n" . 
"Message: " . $message ;

/*
The following function checks for email injection.
Specifically, it checks for carriage returns - typically used by spammers to inject a CC list.
*/
function isInjected($str) {
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
	if(preg_match($inject,$str)) {
		return true;
	}
	else {
		return false;
	}
}

// If the user tries to access this script directly, redirect them to the feedback form,
if (!isset($_REQUEST['email'])) {
header( "Location: $form_page" );
}

// If the form fields are empty, redirect to the error page.
elseif (empty($name) || empty($email)) {
echo ("<SCRIPT LANGUAGE='JavaScript'>
  window.alert('Error')window.location.href=' $form_page';
</SCRIPT>");
}

/* 
If email injection is detected, redirect to the error page.
If you add a form field, you should add it here.
*/
elseif ( isInjected($email) || isInjected($name)  || isInjected($message) ) {
echo ("<SCRIPT LANGUAGE='JavaScript'>
  window.alert('Error')window.location.href=' $form_page';
</SCRIPT>");
}

// If we passed all previous tests, send the email then redirect to the thank you page.
else {

	mail( "$webmaster_email", "WeeKidz Contact Page", $msg );
	
	 echo ("<SCRIPT LANGUAGE='JavaScript'>
	   window.alert('Thankyou For your Response.')
	   window.location.href=' $form_page';
	 </SCRIPT>
	 
       <NOSCRIPT>
         <a href=' $form_page'>Thankyou For your Response. Click here if you are not redirected.</a>
       </NOSCRIPT>");
        
    
}
?>