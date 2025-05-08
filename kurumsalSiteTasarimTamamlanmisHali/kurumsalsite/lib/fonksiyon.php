<?php
if (session_status() === PHP_SESSION_NONE) {
   session_start(); // Oturumu başlatıyoruz
}
class kurumsal {

   public $normaltitle, $metatitle, $metadesc, $metakey, $metaout, $metaown, $metacopy, $logoyazi, $tvit, $face, $ints, $telno, $mailadres, $normaladres, $slogan;
   public $referansbaslik,$referansUstbaslik, $filobaslik,$filoUstbaslik, $yorumbaslik,$yorumUstbaslik, $iletisimbaslik,$iletisimUstbaslik,$hizmetlerbaslik, $hizmetlerUstbaslik, $haritabilgi,$footer, $hiztercih,$videobaslik,$videoUstbaslik,$haberlerMetin;
  
   public $baglanti,$adresBilgi,$telefonBilgi,$adbilgi,$mailBilgi,$konuBilgi,$butonBilgi;

   protected $linkidleri=array();
   
   function __construct() {
      try {
          // Veritabanı bağlantısı
          $this->baglanti = new PDO("mysql:host=localhost;dbname=kurumsal;charset=utf8", "root", "sdsd3490");
          $this->baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
          die("Veritabanı bağlantı hatası: " . $e->getMessage());
      }
  
      // Veritabanından ayarlar tablosunu çekiyoruz
      $ayarcek = $this->baglanti->prepare("SELECT * FROM ayarlar");
      $ayarcek->execute();
      $sorguson = $ayarcek->fetch(PDO::FETCH_ASSOC);
  
      // Verilerin mevcut olup olmadığını kontrol ediyoruz ve sadece geçerli değerleri atıyoruz
      $this->normaltitle = $sorguson["title"] ?? '';
      $this->metatitle = $sorguson["metatitle"] ?? '';
      $this->metadesc = $sorguson["metadesc"] ?? '';
      $this->metakey = $sorguson["metakey"] ?? '';
      $this->metaout = $sorguson["metaauthor"] ?? '';
      $this->metaown = $sorguson["metaowner"] ?? '';
      $this->metacopy = $sorguson["metacopy"] ?? '';
      $this->logoyazi = $sorguson["logoyazisi"] ?? '';
      $this->tvit = $sorguson["twit"] ?? '';
      $this->face = $sorguson["face"] ?? '';
      $this->ints = $sorguson["ints"] ?? '';
      $this->telno = $sorguson["telefonno"] ?? '';
      $this->mailadres = $sorguson["mailadres"] ?? '';
      $this->normaladres = $sorguson["adres"] ?? '';
      $this->haritabilgi = $sorguson["haritabilgi"] ?? '';
      $this->footer = $sorguson["footer"] ?? '';
  
      // Dil kontrolü ve dil bazlı verilerin atanması
      if ($_SESSION["dil"] == "tr") {
          $this->slogan = $sorguson["slogan_tr"] ?? '';
          $this->referansbaslik = $sorguson["referansbaslik_tr"] ?? '';
          $this->referansUstbaslik = $sorguson["referansUstBaslik_tr"] ?? '';
          $this->filobaslik = $sorguson["filobaslik_tr"] ?? '';
          $this->filoUstbaslik = $sorguson["filoUstBaslik_tr"] ?? '';
          $this->yorumbaslik = $sorguson["yorumbaslik_tr"] ?? '';
          $this->yorumUstbaslik = $sorguson["yorumUstBaslik_tr"] ?? '';
          $this->iletisimbaslik = $sorguson["iletisimbaslik_tr"] ?? '';
          $this->iletisimUstbaslik = $sorguson["iletisimUstBaslik_tr"] ?? '';
          $this->hizmetlerbaslik = $sorguson["hizmetlerbaslik_tr"] ?? '';
          $this->hizmetlerUstbaslik = $sorguson["hizmetlerUstBaslik_tr"] ?? '';
          $this->videobaslik = $sorguson["videoaltbaslik_tr"] ?? '';
          $this->videoUstbaslik = $sorguson["videoustbaslik_tr"] ?? '';

          $this->haberlerMetin = $sorguson["haberler_tr"] ?? '';
          

          $this->adresBilgi = "ADRESİMİZ";
          $this->telefonBilgi = "TELEFON NUMARAMIZ";
          $this->adbilgi = "Adınız";
          $this->mailBilgi = "Mail Adresiniz";
          $this->konuBilgi = "Mesaj Konusu";
          $this->butonBilgi = "Gönder";
      } elseif ($_SESSION["dil"] == "en") {
          $this->slogan = $sorguson["slogan_en"] ?? '';
          $this->referansbaslik = $sorguson["referansbaslik_en"] ?? '';
          $this->referansUstbaslik = $sorguson["referansUstBaslik_en"] ?? '';
          $this->filobaslik = $sorguson["filobaslik_en"] ?? '';
          $this->filoUstbaslik = $sorguson["filoUstBaslik_en"] ?? '';
          $this->yorumbaslik = $sorguson["yorumbaslik_en"] ?? '';
          $this->yorumUstbaslik = $sorguson["yorumUstBaslik_en"] ?? '';
          $this->iletisimbaslik = $sorguson["iletisimbaslik_en"] ?? '';
          $this->iletisimUstbaslik = $sorguson["iletisimUstBaslik_en"] ?? '';
          $this->hizmetlerbaslik = $sorguson["hizmetlerbaslik_en"] ?? '';
          $this->hizmetlerUstbaslik = $sorguson["hizmetlerUstBaslik_en"] ?? '';
          $this->videobaslik = $sorguson["videoaltbaslik_en"] ?? '';
          $this->videoUstbaslik = $sorguson["videoustbaslik_en"] ?? '';
          $this->haberlerMetin = $sorguson["haberler_en"] ?? '';



          $this->adresBilgi = "ADDRESS";
          $this->telefonBilgi = "PHONE NUMBER";
          $this->adbilgi = "Your Name";
          $this->mailBilgi = "Your Mail";
          $this->konuBilgi = "Message Subject";
          $this->butonBilgi = "Send";
      
         }
  }

   function introbak() { 
      $introal = $this->baglanti->prepare("SELECT * FROM intro");
      if ($introal->execute()) {
         while ($sonucum = $introal->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="item" style="background-image:url('.$sonucum["resimyol"].');"></div>';
         }
      } else {
         echo "Sorgu başarısız oldu.";
      }
   }

   function hakkimizda() { 
      $introal = $this->baglanti->prepare("SELECT * FROM hakkimizda");
      if ($introal->execute()) {
         while ($sonucum = $introal->fetch()) {
            echo '<div class="row">
                  <div class="col-lg-6 hakkimizda-img">
                     <img src='.$sonucum["resim"].'  alt="'.$sonucum["resim"].'-Hakkında"/>
                  </div>
                  <div class="col-lg-6 content">
                     <h2>'.$sonucum["baslik_".$_SESSION["dil"]].'</h2>
                     <h3>'.$sonucum["icerik_".$_SESSION["dil"]].'</h3>   
                  
                     </div>';
         }
      } else {
         echo "Sorgu başarısız oldu.";
      }
   }


   function hizmetler($baslik = false) {
       $introal = $this->baglanti->prepare("SELECT * FROM hizmetler");
       if ($introal->execute()) {
           echo '<div class="section-header">
                   <h2>'.$this->hizmetlerUstbaslik.'</h2>';
           if ($baslik) {
               echo '<p>' . htmlspecialchars($baslik, ENT_QUOTES, 'UTF-8') . '</p>';
           }
           echo '</div>
                 <div class="row">';
   
           // Veritabanından gelen verileri döngü ile ekliyoruz
           while ($sonucum = $introal->fetch(PDO::FETCH_ASSOC)) {
               $hizmetBaslik = isset($sonucum["baslik_tr"]) ? htmlspecialchars($sonucum["baslik_".$_SESSION["dil"]], ENT_QUOTES, 'UTF-8') : "Başlık bulunamadı";
               $hizmetIcerik = isset($sonucum["icerik_tr"]) ? htmlspecialchars($sonucum["icerik_".$_SESSION["dil"]], ENT_QUOTES, 'UTF-8') : "İçerik bulunamadı";
   
               echo '<div class="col-lg-6">
                       <div class="box wow fadeInTop">
                           <div class="icon"><i class="fa fa-certificate"></i></div>
                           <h4 class="title"><a href="#">' . $hizmetBaslik . '</a></h4>
                           <p class="description">' . $hizmetIcerik . '</p>
                       </div>
                     </div>';
           }
   
           echo '</div>'; // row sınıfını kapatıyoruz
       } else {
           echo "Hizmetler veritabanından alınamadı.";
       }
   }

   function referanslar($baslik=false) { 
      $introal = $this->baglanti->prepare("SELECT * FROM referanslar");
      if ($introal->execute()) {
         echo'<div class="section-header">
               <h2>'.$this->referansUstbaslik.'</h2>
               <p>'.$baslik.'</p>
            </div>
            <div class="owl-carousel clients-carousel">';
               
         while ($sonucum = $introal->fetch(PDO::FETCH_ASSOC)) :
            echo '<div class="item">
            <a href="'.$sonucum["resimyol"].'" class="referans-popup">
            <img src="'.$sonucum["resimyol"].'" alt="Referans '.$sonucum["resimyol"].'"/>
            </a> 
            </div>';
         endwhile;
         echo '</div>';
      }
   }
   

   function filomuz() { 
      $introal = $this->baglanti->prepare("SELECT * FROM filomuz");
      if ($introal->execute()) {
         echo'
         <section id="filo" class="wow fadeInUp">
         <div class="container">
        <div class="section-header">
        <h2>'.$this->filoUstbaslik.'</h2>
        <p>'; echo $this->filobaslik; echo'</p>
         </div>
         <div class="container-fluid">
         <div class="row no-gutters">';
         while ($sonucum = $introal->fetch(PDO::FETCH_ASSOC)) :
            echo '<div class="col-lg-3 col-md-4 col-6">
            <div class="filo-item wow fadeInUp">
            <a href="'.$sonucum["resimyol"].'" class="filo-popup">
            <img src="'.$sonucum["resimyol"].'" alt="Araç '.$sonucum["resimyol"].'"/>
            <div class="filo-overlay">
            </div>
            </a> 
            </div>
            </div>
            ';
         endwhile;
         echo '</div></div></div></section>';
      }
   }
   function yorumlar($baslik=false) { 
      $introal = $this->baglanti->prepare("SELECT * FROM yorumlar");
      if ($introal->execute()) {

         echo'<div class="section-header">
        <h2>'.$this->yorumUstbaslik.'</h2>
        <p>'.$baslik.'</p>
         </div>
         
         <div class="owl-carousel testimonials-carousel">';
         while ($sonucum = $introal->fetch(PDO::FETCH_ASSOC)) :

            echo'<div class="testimonial-item">
            <p>
            <img src="img/sol.png" class="quote-sign-left" />
            '.$sonucum["icerik"].'
            <img src="img/sag.png" class="quote-sign-right" />
            </p>
            <img src="img/yorum.jpg " class="testimonial-img" alt="Müşteri Yorum-'.$sonucum["id"].'" />
            <h3>'.$sonucum["isim"].'</h3>
 </div>';
endwhile;
echo '</div>';
      }
   }

  
   
   //Linkleri dinamik hale getiriyoruz

   
   

  
   function linkler($db) {
       // Tasarım tercihlerini alıyoruz
       $tercihbak = $db->prepare("SELECT hiztercih, videotercih, reftercih, yorumtercih FROM tasarim");
       $tercihbak->execute();
       $gelen = $tercihbak->fetch(PDO::FETCH_ASSOC);
   
       // Tüm linkleri alıyoruz
       $linkal = $db->prepare("SELECT * FROM linkler ORDER BY siralama ASC");
       $linkal->execute();
   
       $sayi = 0;
       while ($linkson = $linkal->fetch(PDO::FETCH_ASSOC)) {
           if ($sayi == 0) {
               // İlk linki aktif olarak işaretliyoruz
               echo '<li class="menu-active"><a href="#' . htmlspecialchars($linkson["etiket"], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($linkson["ad_" . $_SESSION["dil"]], ENT_QUOTES, 'UTF-8') . '</a></li>';
               $sayi = 1;
           } else {
               // Hizmet linki kontrolü
               if (strpos($linkson["ad_tr"], 'hizmet') !== false && $gelen["hiztercih"] == 0) {
                   echo '<li><a href="#' . htmlspecialchars($linkson["etiket"], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($linkson["ad_" . $_SESSION["dil"]], ENT_QUOTES, 'UTF-8') . '</a></li>';
               }
               // Video linki kontrolü
               elseif (strpos($linkson["ad_tr"], 'video') !== false && $gelen["videotercih"] == 0) {
                   echo '<li><a href="#' . htmlspecialchars($linkson["etiket"], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($linkson["ad_" . $_SESSION["dil"]], ENT_QUOTES, 'UTF-8') . '</a></li>';
               }
               // Referans linki kontrolü
               elseif (strpos($linkson["ad_tr"], 'referans') !== false && $gelen["reftercih"] == 0) {
                   echo '<li><a href="#' . htmlspecialchars($linkson["etiket"], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($linkson["ad_" . $_SESSION["dil"]], ENT_QUOTES, 'UTF-8') . '</a></li>';
               }
               // Yorum linki kontrolü
               elseif (strpos($linkson["ad_tr"], 'yorum') !== false && $gelen["yorumtercih"] == 0) {
                   echo '<li><a href="#' . htmlspecialchars($linkson["etiket"], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($linkson["ad_" . $_SESSION["dil"]], ENT_QUOTES, 'UTF-8') . '</a></li>';
               }
               // Diğer linkler (örneğin iletişim) için kontrol
               else {
                   echo '<li><a href="#' . htmlspecialchars($linkson["etiket"], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($linkson["ad_" . $_SESSION["dil"]], ENT_QUOTES, 'UTF-8') . '</a></li>';
               }
           }
       }
   }
   
   //Videolar kısmı
   function videolar() { 
       $videoal = $this->baglanti->prepare("SELECT * FROM videolar WHERE durum=1 ORDER BY siralama ASC");
      if ($videoal->execute()) {
         echo'<div class="container">
        <div class="section-header">
        <h2>'.$this->videoUstbaslik.'</h2>
        <p>'; echo $this->videobaslik; echo'</p>
         </div>
         <div class="container-fluid">
         <div class="row no-gutters">'; 
         while ($sonucum = $videoal->fetch(PDO::FETCH_ASSOC)) :
            echo '<div class="col-lg-3 col-md-4 col-6">
            
            <div class="embed-responsive embed-responsive-16by9 ">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.$sonucum["link"].'" allowfullscreen></iframe>
            
            </div>
            </div>';
         endwhile;
         echo '</div></div>';
      }
   }







  //Duyuru Haber kısmı
  
function haberler($baslik = false) {
    $introal = $this->baglanti->prepare("SELECT * FROM haberler");
    if ($introal->execute()) {
        // Yeni eklenen kodlar
        echo '<div class="container wow fadeInUp">
                <div class="row mt-2 pt-3 border-secondary border-bottom">
                    <div class="col-lg-3 col-md-3 text-right">
                        <h5>' . htmlspecialchars($this->haberlerMetin, ENT_QUOTES, 'UTF-8') . '</h5>
                    </div>
                    <div class="col-lg-9 col-md-9 text-info text-left" id="news-container1">
                        <ul style="list-style-type:none;">';

        // Haberler veya duyurular listesi
        while ($sonucum = $introal->fetch(PDO::FETCH_ASSOC)) {
          echo '<li>'.$sonucum["icerik_".$_SESSION["dil"]].' | '.$sonucum["tarih"].'  </li>';
        }

        echo '          </ul>
                    </div>
                </div>';
    } else {
        echo "Haberler veritabanından alınamadı.";
    }
}
}



?>