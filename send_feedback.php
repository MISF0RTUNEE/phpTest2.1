<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

$host = 'localhost:3306';
$db = 'test';
$user = 'root';
$pass = '12345';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}


$fio = $_POST['fio'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];


$stmt = $conn->prepare("INSERT INTO feedback (fio, email, phone, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $fio, $email, $phone, $message);
$stmt->execute();


$mail = new PHPMailer(true);


$mail->isSMTP();                                            
$mail->Host       = 'smtp.gmail.com';                     
$mail->SMTPAuth   = true;                                 
$mail->Username   = 'почта';             
$mail->Password   = 'пароль';          
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
$mail->Port       = 587;                                 


$mail->setFrom('почта отправителя', 'имя отправителя');      
$mail->addAddress('почта получателя');               


$mail->CharSet = 'UTF-8'; 
$mail->Subject = 'Тема письма';
$mail->Body    = $fio . '<br>' . $email . '<br>' . $phone . '<br>' . $message;                        

$mail->send();

$stmt->close();
$conn->close();

echo "Спасибо за ваше сообщение!";
?>