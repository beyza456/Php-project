<?php
 
      try { 
       
         $baglanti = new PDO("mysql:host=localhost;dbname=kurumsal;charset=utf8", "root", "sdsd3490"); 
        
         $baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
     
      } 
      catch (PDOException $e) {   
         die("Veritabanı bağlantı hatası: " . $e->getMessage()); 
      }
   
  @$hareket= $_GET["islem"];

   switch($hareket):

    case "bultenislem":

      $gelenmail=htmlspecialchars(strip_tags($_POST["mail"]));
      
            if(!$_POST):

               echo "Posttan gelmiyorsun.";
            
            else:
               //girilen adresin gerçekten mail olup olmadığı , boş mu değil mi kontrolü yapılacak

               $sunucu=substr($gelenmail,strpos($gelenmail,'@') +1);

               $error=array();
               getmxrr($sunucu, $error);

               if(count($error) > 0):
                 //veritabanına gelinmiş ve diğer kontroller yapılmış
                 //Gelen mailin daha önce kayıtlı olup olmadığı
                 $kayitet=$baglanti->prepare("INSERT INTO  bulten(mail) VALUES ('$gelenmail')");
                 $kayitet->execute();
                 echo ' <div class="alert alert-success mt-2">Başarıyla kayıt olundu. Teşekkür Ederiz.</div>';


               else:
                  echo ' <div class="alert alert-danger mt-2">Girilen Adres Geçersiz</div>';
               endif;

            endif;

      break;
   endswitch;

?>