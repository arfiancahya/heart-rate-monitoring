<?php
date_default_timezone_set('Asia/Jakarta'); // setting time zone;

require_once('class.phpmailer.php');
$mail             = new PHPMailer();
$body             = "Ini adalah contoh penggunaan PHPmailer semoga berguna"; //isi dari email
$mail->IsSMTP(); // mengirimkan sinyal ke class PHPMail untuk menggunakan SMTP
$mail->SMTPDebug  = 1;                     // mengaktifkan debug mode (untuk ujicoba)
                                           // 1 = Error dan pesan
                                           // 2 = Pesan saja
$mail->SMTPAuth   = true;                  // aktifkan autentikasi SMTP
$mail->SMTPSecure = "ssl";                 // jenis kemananan
$mail->Host       = "smtp.gmail.com";      // masukkan GMAIL sebagai smtp server
$mail->Port       = "465";                   // masukkan port yang digunakan oleh SMTP Gmail
$mail->Username   = "username_anda@gmail.com";  // GMAIL username
$mail->Password   = "password_anda";            // GMAIL password
$mail->SetFrom('username_anda@gmail.com', 'Nama Anda'); // masukkan alamat pengririm dan nama pengirim jika alamat email tidak sama, maka yang digunakan alamat email untuk username
$mail->Subject    = "Contoh kirim email via PHP";//masukkan subject
$mail->MsgHTML($body);//masukkan isi dari email

$address = "email_tujuan@sesuatu.com"; //masukkan penerima
$mail->AddAddress($address, "sesuatu"); //masukkan penerima

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo; // jika pesan tidak terkirim
} else {
  echo "Pesan Terkirim!"; //jika pesan terkirim
}

?>