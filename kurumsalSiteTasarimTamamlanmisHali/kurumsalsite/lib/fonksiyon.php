<?php

class kurumsal {

   public $normaltitle, $metatitle, $metadesc, $metakey, $metaout, $metaown, $metacopy, $logoyazi, $tvit, $face, $ints, $telno, $mailadres, $normaladres, $slogan;
   public $referansbaslik, $filobaslik, $yorumbaslik, $iletisimbaslik;
   private $baglanti;

   function __construct() {  
      try { 
         $this->baglanti = new PDO("mysql:host=localhost;dbname=kurumsal;charset=utf8", "root", "sdsd3490"); 
         $this->baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
      } 
      catch (PDOException $e) {   
         die ($e->getMessage()); 
      }
   
      $ayarcek = $this->baglanti->prepare("SELECT * FROM ayarlar");
      $ayarcek->execute(); 
      $sorguson = $ayarcek->fetch(PDO::FETCH_ASSOC);   
      $this->normaltitle = $sorguson["title"]; 
      $this->metatitle = $sorguson["metatitle"]; 
      $this->metadesc = $sorguson["metadesc"]; 
      $this->metakey = $sorguson["metakey"]; 
      $this->metaout = $sorguson["metaauthor"]; 
      $this->metaown = $sorguson["metaowner"]; 
      $this->metacopy = $sorguson["metacopy"]; 
      $this->logoyazi = $sorguson["logoyazisi"]; 
      $this->tvit = $sorguson["twit"]; 
      $this->face = $sorguson["face"]; 
      $this->ints = $sorguson["ints"];
      $this->telno = $sorguson["telefonno"];
      $this->mailadres = $sorguson["mailadres"];
      $this->normaladres = $sorguson["adres"];
      $this->slogan = $sorguson["slogan"];
      $this->referansbaslik = $sorguson["referansbaslik"];
      $this->filobaslik = $sorguson["filobaslik"]; 
      $this->yorumbaslik = $sorguson["yorumbaslik"];
      $this->iletisimbaslik = $sorguson["iletisimbaslik"];
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
                     <h2>'.$sonucum["baslik"].'</h2>
                     <h3>'.$sonucum["icerik"].'</h3>   
                  </div>';
         }
      } else {
         echo "Sorgu başarısız oldu.";
      }
   }

   function hizmetler() { 
      $introal = $this->baglanti->prepare("SELECT * FROM hizmetler");
      if ($introal->execute()) {
         while ($sonucum = $introal->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="section-header">
                  <h2>HİZMETLERİMİZ</h2>';
            if (isset($sonucum["hizmetlerbaslik"])) {
               echo '<p>'.$sonucum["hizmetlerbaslik"].'</p>';
            }
            echo '</div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="box wow fadeInLeft">
                           <div class="icon"><i class="fa fa-bar-chart"></i></div>
                           <h4 class="title"><a href="#">'.$sonucum["baslik1"].'</a></h4>
                           <p class="description">'.$sonucum["icerik1"].'</p>
                        </div> 
                     </div>
                     <div class="col-lg-6">
                        <div class="box wow fadeInRight">
                           <div class="icon"><i class="fa fa-picture-o"></i></div>
                           <h4 class="title"><a href="#">'.$sonucum["baslik2"].'</a></h4>
                           <p class="description">'.$sonucum["icerik2"].'</p>
                        </div> 
                     </div>
                     <div class="col-lg-6">
                        <div class="box wow fadeInLeft">
                           <div class="icon"><i class="fa fa-map"></i></div>
                           <h4 class="title"><a href="#">'.$sonucum["baslik3"].'</a></h4>
                           <p class="description">'.$sonucum["icerik3"].'</p>
                        </div> 
                     </div>
                     <div class="col-lg-6">
                        <div class="box wow fadeInRight">
                           <div class="icon"><i class="fa fa-shopping-bag"></i></div>
                           <h4 class="title"><a href="#">'.$sonucum["baslik4"].'</a></h4>
                           <p class="description">'.$sonucum["icerik4"].'</p>
                        </div> 
                     </div>
                  </div>';
         }
      } else {
         echo "Sorgu başarısız oldu.";
      }
   }

   function referanslar() { 
      $introal = $this->baglanti->prepare("SELECT * FROM referanslar");
      if ($introal->execute()) {
         echo'<div class="section-header">
               <h2>REFERANSLARIMIZ</h2>
               <p>'; echo $this->referansbaslik; echo'</p>
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
         echo'<div class="container">
        <div class="section-header">
        <h2>Araçlarımız</h2>
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
            </div>';
         endwhile;
         echo '</div></div>';
      }
   }
   function yorumlar() { 
      $introal = $this->baglanti->prepare("SELECT * FROM yorumlar");
      if ($introal->execute()) {

         echo'<div class="section-header">
        <h2>Müşteri Yorumları</h2>
        <p>'; echo $this->yorumbaslik; echo'</p>
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
}


?>