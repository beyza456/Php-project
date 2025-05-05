<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

try {
    // PDO bağlantısını oluşturuyoruz
    $baglanti = new PDO("mysql:host=localhost;dbname=kurumsal;charset=utf8", "root", "sdsd3490");
   

    $baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}


$ayarlar=$baglanti->prepare("SELECT * FROM gelenmailayar");
$ayarlar->execute();
$ayarson=$ayarlar->fetch();
//Tercihi alıyorum
$ayarlar2=$baglanti->prepare("SELECT mesajtercih FROM ayarlar");
$ayarlar2->execute();
$tercihgeldi =$ayarlar2->fetch();

$mail= new PHPMailer(true);
$mail->SMTPDebug=0;
$mail->isSMTP(); 
$mail->CharSet='UTF-8';
$mail->Host= $ayarson["host"];
$mail->SMTPAuth=true;
$mail->Username= $ayarson["mailadres"];
$mail->Password = $ayarson["sifre"]; 
$mail->SMTPSecure="ssl";

$mail->Port= $ayarson["port"];
$mail->isHTML(true);
$mail->addAddress($ayarson["aliciadres"]);



    
    



if($_POST):

    $isim= htmlspecialchars(strip_tags($_POST["isim"]));
    $mailadres= htmlspecialchars(strip_tags($_POST["mail"]));
    $konu= htmlspecialchars(strip_tags($_POST["konu"]));
    $mesaj= htmlspecialchars(strip_tags($_POST["mesaj"]));
    
    
    switch($tercihgeldi["mesajtercih"]):

        case 1:
            $mail->setFrom($mailadres,$isim);
            $mail->addReplyTo($mailadres,"Yanıt");
            $mail->Subject=$konu;
            $mail->Body=$mesaj;

            if( $mail->send()):

                echo '<div class="alert alert-success text-center mx-auto">Mesaj Başarılı Bir Şekilde Gönderildi.</br> Teşekkür Ederiz</div>';

            else:
               
               $zaman=date("d.m.Y")."/".date("H:i:s");
                //Burada veri tabanına kayıt yapılır
                $kaydet= $baglanti -> prepare("INSERT INTO gelenmail (ad,mailadres,konu,mesaj,zaman) VALUES (?,?,?,?,?)");
                
                $kaydet ->bindParam(1,$isim,PDO::PARAM_STR);
                $kaydet ->bindParam(2,$mailadres,PDO::PARAM_STR);
                $kaydet ->bindParam(3,$konu,PDO::PARAM_STR);
                $kaydet ->bindParam(4,$mesaj,PDO::PARAM_STR);
                $kaydet ->bindParam(5,$zaman,PDO::PARAM_STR);
               
                $kaydet -> execute();
            
                echo '<div class="alert alert-success text-center mx-auto">Mesaj Başarılı Bir Şekilde Gönderildi.</br> Teşekkür Ederiz</div>';
            endif;

           
            break;

      
            case 2:
            $mail->setFrom($mailadres,$isim);
            $mail->addReplyTo($mailadres,"Yanıt");
            $mail->Subject=$konu;
            $mail->Body=$mesaj;
            $mail->send();

            $zaman=date("d.m.Y")."/".date("H:i:s");
            //Burada veri tabanına kayıt yapılır
            $kaydet= $baglanti -> prepare("INSERT INTO gelenmail (ad,mailadres,konu,mesaj,zaman) VALUES (?,?,?,?,?)");
            
            $kaydet ->bindParam(1,$isim,PDO::PARAM_STR);
            $kaydet ->bindParam(2,$mailadres,PDO::PARAM_STR);
            $kaydet ->bindParam(3,$konu,PDO::PARAM_STR);
            $kaydet ->bindParam(4,$mesaj,PDO::PARAM_STR);
            $kaydet ->bindParam(5,$zaman,PDO::PARAM_STR);
           
            $kaydet -> execute();
            echo '<div class="alert alert-success text-center mx-auto">Mesaj Başarılı Bir Şekilde Gönderildi.</br> Teşekkür Ederiz</div>';
        break;

        case 3:

            $zaman=date("d.m.Y")."/".date("H:i:s");
            //Burada veri tabanına kayıt yapılır
            
            $kaydet= $baglanti -> prepare("INSERT INTO gelenmail (ad,mailadres,konu,mesaj,zaman) VALUES (?,?,?,?,?)");
            
            $kaydet ->bindParam(1,$isim,PDO::PARAM_STR);
            $kaydet ->bindParam(2,$mailadres,PDO::PARAM_STR);
            $kaydet ->bindParam(3,$konu,PDO::PARAM_STR);
            $kaydet ->bindParam(4,$mesaj,PDO::PARAM_STR);
            $kaydet ->bindParam(5,$zaman,PDO::PARAM_STR);
           
            $kaydet -> execute();
            echo '<div class="alert alert-success text-center mx-auto">Mesaj Başarılı Bir Şekilde Gönderildi.</br> Teşekkür Ederiz</div>';

        break;

    
    endswitch;


endif;



