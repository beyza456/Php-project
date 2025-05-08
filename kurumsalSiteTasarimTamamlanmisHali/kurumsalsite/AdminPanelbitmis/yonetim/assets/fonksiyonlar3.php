<?php
include_once("assets/fonksiyonlar.php"); // yonetim sınıfının tanımlandığı dosyanın yolunu ekleyin

class yonetim3 extends yonetim{
 protected $idler = array();
    
 

//Link Ayarları

function linkayar($vt) {
    // Başlık ve "Link Ekle" butonu
    echo '<div class="row text-center">
        <div class="col-lg-12 border-bottom">
            <h3 class="float-left mt-3 text-info">Link Kontrol</h3>
        </div>
        <a href="control.php?sayfa=linkekle" class="btn btn-success m-2">Link Ekle</a>
    </div>';

    // Linkleri listelemek için bir satır başlatıyoruz
    echo '<div class="row justify-content-center">';

    // Veritabanından linkleri çekiyoruz
    $filobilgiler = parent::sorgum($vt, "SELECT * FROM linkler ORDER BY siralama ASC", 2);

    if ($filobilgiler) {
        // Linkler varsa her birini döngüyle yazdırıyoruz
        foreach ($filobilgiler as $sonbilgi) {
            // Link bilgilerini güvenli bir şekilde yazdırıyoruz
            $siralama = htmlspecialchars($sonbilgi["siralama"], ENT_QUOTES, 'UTF-8');
            $ad_tr = htmlspecialchars($sonbilgi["ad_tr"], ENT_QUOTES, 'UTF-8');
            $ad_en = htmlspecialchars($sonbilgi["ad_en"], ENT_QUOTES, 'UTF-8');
            $etiket = htmlspecialchars($sonbilgi["etiket"], ENT_QUOTES, 'UTF-8');
            $id = htmlspecialchars($sonbilgi["id"], ENT_QUOTES, 'UTF-8');

            echo '<div class="col-lg-4 col-md-6 col-sm-12 mb-4"> <!-- Her link için bir sütun -->
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="card-title">
                            <kbd class="float-left">Sıra: ' . $siralama . '</kbd>
                            ' . $ad_tr . ' - ' . $ad_en . '
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">' . $etiket . '</p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="control.php?sayfa=linkguncelle&id=' . $id . '" class="btn btn-sm btn-success m-1">Güncelle</a>
                        <a href="control.php?sayfa=linksil&id=' . $id . '" class="btn btn-sm btn-danger m-1" onclick="return confirm(\'Bu linki silmek istediğinize emin misiniz?\')">Sil</a>
                    </div>
                </div>
            </div>';
        }
    } else {
        // Link bulunamadığında uyarı mesajı
        echo '<div class="col-lg-12">
            <div class="alert alert-warning mt-5" role="alert">Hiçbir link bulunamadı!</div>
        </div>';
    }

    // Satırı kapatıyoruz
    echo '</div>';
}



function linkekleme($vt) {
    // Son sırayı almak için veritabanı sorgusu
    $introbilgiler = parent::sorgum($vt, "SELECT * FROM linkler ORDER BY siralama DESC LIMIT 1", 2);
    $sayi = (!empty($introbilgiler) && isset($introbilgiler[0]["siralama"])) ? $introbilgiler[0]["siralama"] + 1 : 1;

    // Başlık ve form başlatma
    echo '<div class="row text-center">
        <div class="col-lg-12 border-bottom">
            <h3 class="mt-3 text-info">Link Ekle</h3>
        </div>
    </div>';

    echo '<div class="row justify-content-center mt-4">'; // Ortalamak için justify-content-center sınıfı ekleniyor

    // Link ekleme formu
    echo '<div class="col-lg-6">
         <div class="card shadow-sm">
            <div class="card-header bg-info text-white text-center">
                <h5>Link Ekle</h5>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="ad_tr" class="form-label">TR-Link</label>
                        <input type="text" name="ad_tr" id="ad_tr" class="form-control" placeholder="Türkçe link başlığını girin" required>
                    </div>
                    <div class="mb-3">
                        <label for="ad_en" class="form-label">EN-Link</label>
                        <input type="text" name="ad_en" id="ad_en" class="form-control" placeholder="İngilizce link başlığını girin" required>
                    </div>
                    <div class="mb-3">
                        <label for="etiket" class="form-label">Etiket</label>
                        <input type="text" name="etiket" id="etiket" class="form-control" placeholder="Link etiketi girin" required>
                    </div>
                    <div class="mb-3">
                        <label for="sira" class="form-label">Link Sırası</label>
                      
                        <select name="sira" id="sira" class="form-control">
                            <option value="' . $sayi . '">' . $sayi . '</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <input type="submit" name="buton" class="btn btn-primary" value="Link Ekle">
                    </div>
                </form>
            </div>
        </div>
    </div>';

    echo '</div>'; // row sınıfını kapatıyoruz

    // Form gönderildiğinde veritabanına ekleme işlemi
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Formdan gelen verileri alıyoruz
        $ad_tr = isset($_POST["ad_tr"]) ? trim(htmlspecialchars($_POST["ad_tr"], ENT_QUOTES, 'UTF-8')) : '';
        $ad_en = isset($_POST["ad_en"]) ? trim(htmlspecialchars($_POST["ad_en"], ENT_QUOTES, 'UTF-8')) : '';
        $etiket = isset($_POST["etiket"]) ? trim(htmlspecialchars($_POST["etiket"], ENT_QUOTES, 'UTF-8')) : '';
        $sira = isset($_POST["sira"]) ? intval($_POST["sira"]) : $sayi;

        // Tüm alanların dolu olup olmadığını kontrol ediyoruz
        if (!empty($ad_tr) && !empty($ad_en) && !empty($etiket)) {
            try {
                // Veritabanına ekleme işlemi
                $ekle = $vt->prepare("INSERT INTO linkler (ad_tr, ad_en, etiket, siralama) VALUES (:ad_tr, :ad_en, :etiket, :sira)");
                $ekle->bindParam(':ad_tr', $ad_tr, PDO::PARAM_STR);
                $ekle->bindParam(':ad_en', $ad_en, PDO::PARAM_STR);
                $ekle->bindParam(':etiket', $etiket, PDO::PARAM_STR);
                $ekle->bindParam(':sira', $sira, PDO::PARAM_INT);

                if ($ekle->execute()) {
                    echo '<div class="alert alert-success mt-3 text-center">Link başarıyla eklendi!</div>';
                    header("refresh:2;url=control.php?sayfa=linkayar");
                } else {
                    echo '<div class="alert alert-danger mt-3 text-center">Link eklenirken bir hata oluştu!</div>';
                }
            } catch (PDOException $e) {
              
                echo '<div class="alert alert-danger mt-3 text-center">Hata: ' . $e->getMessage() . '</div>';
            }
        } else {
            echo '<div class="alert alert-warning mt-3 text-center">Lütfen tüm alanları doldurun!</div>';
        }
    }
}



function linkguncelleme($vt) {
    // Tüm linkleri sıralama bilgisiyle alıyoruz
    $linklerebak = parent::sorgum($vt, "SELECT * FROM linkler ORDER BY siralama ASC", 2);

    echo '<div class="row text-center">
        <div class="col-lg-12 border-bottom">
            <h3 class="mt-3 text-info">Link Güncelle</h3>
        </div>
    </div>';

    // Gelen ID'yi alıyoruz
    $kayitid = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
    if ($kayitid <= 0) {
        echo '<div class="alert alert-danger mt-3 text-center">Geçersiz ID!</div>';
        return;
    }

    // Veritabanından mevcut kaydı alıyoruz
    $kayitbilgial = parent::sorgum($vt, "SELECT * FROM linkler WHERE id=$kayitid", 1);
    if (!$kayitbilgial) {
        echo '<div class="alert alert-danger mt-3 text-center">Kayıt bulunamadı!</div>';
        return;
    }

    echo '<div class="row justify-content-center mt-4">'; // Ortalamak için justify-content-center sınıfı ekleniyor

    // Link güncelleme formu
    echo '<div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white text-center">
                <h5>Link Güncelle</h5>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="ad_tr" class="form-label">TR-Link</label>
                        <input type="text" name="ad_tr" id="ad_tr" class="form-control" 
                               value="' . htmlspecialchars($kayitbilgial["ad_tr"], ENT_QUOTES, 'UTF-8') . '" 
                               placeholder="Türkçe link başlığını girin" required>
                    </div>
                    <div class="mb-3">
                        <label for="ad_en" class="form-label">EN-Link</label>
                        <input type="text" name="ad_en" id="ad_en" class="form-control" 
                               value="' . htmlspecialchars($kayitbilgial["ad_en"], ENT_QUOTES, 'UTF-8') . '" 
                               placeholder="İngilizce link başlığını girin" required>
                    </div>
                    <div class="mb-3">
                        <label for="etiket" class="form-label">Etiket</label>
                        <input type="text" name="etiket" id="etiket" class="form-control" 
                               value="' . htmlspecialchars($kayitbilgial["etiket"], ENT_QUOTES, 'UTF-8') . '" 
                               placeholder="Link etiketi girin" required>
                    </div>
                    <div class="mb-3">
                        <label for="sira" class="form-label">Link Sırası</label>
                        <select name="gideceksira" id="sira" class="form-control">';
                        
                        // Sıralama seçeneklerini ekliyoruz
                        if ($linklerebak && is_array($linklerebak)) {
                            foreach ($linklerebak as $sonbilgi) {
                                $selected = ($sonbilgi["siralama"] == $kayitbilgial["siralama"]) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($sonbilgi["siralama"], ENT_QUOTES, 'UTF-8') . '" ' . $selected . '>'
                                    . htmlspecialchars($sonbilgi["siralama"], ENT_QUOTES, 'UTF-8') . ' - ' 
                                    . htmlspecialchars($sonbilgi["ad_tr"], ENT_QUOTES, 'UTF-8') . 
                                    '</option>';
                            }
                        } else {
                            echo '<option value="">Sıralama bilgisi bulunamadı</option>';
                        }

                        echo '</select>
                    </div>
                    <div class="col-lg-12 border-top p-2 text-center">
                        <input type="hidden" name="kayitidsi" value="' . htmlspecialchars($kayitid, ENT_QUOTES, 'UTF-8') . '">
                        <input type="hidden" name="mevcutsira" value="' . htmlspecialchars($kayitbilgial["siralama"], ENT_QUOTES, 'UTF-8') . '">
                        <input type="submit" name="buton" class="btn btn-primary" value="Link Güncelle">
                    </div>
                </form>
            </div>
        </div>
    </div>';

    echo '</div>'; // row sınıfını kapatıyoruz

    // Form gönderildiğinde veritabanına güncelleme işlemi
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $ad_tr = isset($_POST["ad_tr"]) ? htmlspecialchars($_POST["ad_tr"], ENT_QUOTES, 'UTF-8') : '';
        $ad_en = isset($_POST["ad_en"]) ? htmlspecialchars($_POST["ad_en"], ENT_QUOTES, 'UTF-8') : '';
        $etiket = isset($_POST["etiket"]) ? htmlspecialchars($_POST["etiket"], ENT_QUOTES, 'UTF-8') : '';
        $gideceksira = isset($_POST["gideceksira"]) ? intval($_POST["gideceksira"]) : 0;
        $mevcutsira = isset($_POST["mevcutsira"]) ? intval($_POST["mevcutsira"]) : 0;
        $kayitidsi = isset($_POST["kayitidsi"]) ? intval($_POST["kayitidsi"]) : 0;

        if (!empty($ad_tr) && !empty($ad_en) && !empty($etiket) && $gideceksira > 0 && $kayitidsi > 0) {
            try {
                $vt->beginTransaction();

                // Eski sırayı boşalt
                $bosalt = $vt->prepare("UPDATE linkler SET siralama = :mevcutsira WHERE siralama = :gideceksira");
                $bosalt->bindParam(':mevcutsira', $mevcutsira, PDO::PARAM_INT);
                $bosalt->bindParam(':gideceksira', $gideceksira, PDO::PARAM_INT);
                $bosalt->execute();

                // Yeni sırayı güncelle
                $guncelle = $vt->prepare("UPDATE linkler SET ad_tr = :ad_tr, ad_en = :ad_en, etiket = :etiket, siralama = :gideceksira WHERE id = :kayitidsi");
                $guncelle->bindParam(':ad_tr', $ad_tr, PDO::PARAM_STR);
                $guncelle->bindParam(':ad_en', $ad_en, PDO::PARAM_STR);
                $guncelle->bindParam(':etiket', $etiket, PDO::PARAM_STR);
                $guncelle->bindParam(':gideceksira', $gideceksira, PDO::PARAM_INT);
                $guncelle->bindParam(':kayitidsi', $kayitidsi, PDO::PARAM_INT);
                $guncelle->execute();

                $vt->commit();

                echo '<div class="alert alert-success mt-3 text-center">Link Güncelleme başarılı!</div>';
                header("refresh:2;url=control.php?sayfa=linkayar");
            } catch (Exception $e) {
                $vt->rollBack();
                
                echo '<div class="alert alert-danger mt-3 text-center">Güncelleme yapılırken bir hata oluştu: ' . $e->getMessage() . '</div>';
            }
        } else {
            echo '<div class="alert alert-warning mt-3 text-center">Lütfen tüm alanları doldurun!</div>';
        }
    }
}



function linksil($vt) {
    // Gelen ID'yi kontrol ediyoruz
    $kayitid = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
    if ($kayitid <= 0) {
        echo '<div class="alert alert-danger mt-3 text-center">Geçersiz ID!</div>';
        return;
    }

    echo '<div class="row text-center">
        <div class="col-lg-12">';

    try {
        // Silme işlemi için PDO kullanımı
        $sil = $vt->prepare("DELETE FROM linkler WHERE id = :id");
        $sil->bindParam(':id', $kayitid, PDO::PARAM_INT);

        if ($sil->execute()) {
            echo '<div class="alert alert-success mt-1" role="alert">Silme başarılı</div>';
        } else {
            echo '<div class="alert alert-danger mt-1" role="alert">Silme işlemi sırasında bir hata oluştu!</div>';
        }
    } catch (PDOException $e) {
        // Hata durumunda mesaj gösterimi
        echo '<div class="alert alert-danger mt-1" role="alert">Hata: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</div>';
    }

    echo '</div></div>';

    // Yönlendirme
    header("refresh:2;url=control.php?sayfa=linkayar");
}

//Bulten Ayarları

function satirsayisi($vt){
    $sorgu = parent::sorgum ($vt, "SELECT * FROM bulten", 0);
    if ($sorgu) {
        return $sorgu->rowCount(); // Direkt olarak rowCount çağrılır
    }
    return "hata"; // Hata durumunda 0 döndür
}

function aramaformu($vt) {
    // Kullanıcının girdiği e-posta
    $mail = isset($_POST["mail"]) ? trim($_POST["mail"]) : '';

    // Mail adresi kontrolü
    if (empty($mail)) {
        echo '
        <div class="col-lg-12 mt-5 mb-5 text-center">
            <div class="alert alert-danger">Mail Adresi Girilmeli</div>
        </div>';
        header("refresh:2;url=control.php?sayfa=bulten");
        return; // Fonksiyonu sonlandırıyoruz
    }

    // SQL sorgusu
    $sorgu = $vt->prepare("SELECT * FROM bulten WHERE mail LIKE :mail");
    $sorgu->bindValue(':mail', '%' . $mail . '%', PDO::PARAM_STR); // Güvenli bir şekilde parametre ekleme
    $sorgu->execute(); // Sorguyu çalıştırma

    // Sorgu sonuçlarının ekrana yazdırılması
    if ($sorgu->rowCount() > 0) {
        while ($sonuclar = $sorgu->fetch(PDO::FETCH_ASSOC)) {
            echo '
            <div class="col-lg-2">
                <div class="row border font-weight-bold">
                    <div class="col-lg-9">' . htmlspecialchars($sonuclar["mail"], ENT_QUOTES, 'UTF-8') . '</div>
                    <div class="col-lg-3 text-right">
                        <a href="control.php?sayfa=bulten&icislem=sil&id=' . intval($sonuclar["id"]) . '" class="fa fa-trash text-danger" style="font-size:20px;"></a>
                        <a href="control.php?sayfa=bulten&icislem=guncelle&id=' . intval($sonuclar["id"]) . '" class="ti-reload text-success" style="font-size:15px;"></a>
                    </div>
                </div>
            </div>';
        }
        echo '<div class="text-center mt-3">Toplam Sonuç: ' . $sorgu->rowCount() . '</div>';
    } else {
        echo '
        <div class="col-lg-12 mt-5 mb-5 text-center">
            <div class="alert alert-warning">Mail adresiyle eşleşen kayıt bulunamadı!</div>
        </div>';
    }
}


function MailSil($db){
    parent::sorgum($db, "DELETE FROM bulten WHERE id=".$_GET["id"],0);

    echo '<div class="col-lg-12 mt-5">
   
    <div class="alert alert-success" > Başarıyla silindi </div>
    </div>';
    
    header ("refresh:2,url=control.php?sayfa=bulten");
}


function MailGuncelle($db) {
    // Başlık bölümü
    echo '
        <div class="col-lg-12 border-bottom">
            <h3 class="mt-5 text-info">Mail Güncelle</h3>
        </div>';
    
    // Geçerli kayıt bilgisi alınması
    $gelenbilgi = parent::sorgum($db, "SELECT * FROM bulten WHERE id=" . intval($_GET["id"]), 0);
    $MevcutKayit = $gelenbilgi->fetch(PDO::FETCH_ASSOC);

    if (!$MevcutKayit) {
        echo '<div class="alert alert-danger mt-3 text-center">Geçersiz ID!</div>';
        return;
    }

    // Güncelleme formu
    echo '
    <div class="row justify-content-center mt-4">
        <div class="col-lg-12 text-center ">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white text-center">
                    <h5>Mail Güncelle</h5>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3 mx-auto">
                            <label for="mail" class="form-label">Mail</label>
                            <input type="email" name="mail" id="mail" class="form-control" 
                            value="' . htmlspecialchars($MevcutKayit["mail"], ENT_QUOTES, 'UTF-8') . '" 
                            placeholder="Mail adresini girin" required>
                        </div>
                        <div class="text-center">
                            <input type="hidden" name="kayitidsi" value="' . intval($_GET["id"]) . '">
                            <input type="submit" name="buton" class="btn btn-primary" value="Mail Güncelle">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>';

    // Form gönderildiğinde güncelleme işlemi
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $mail = isset($_POST["mail"]) ? htmlspecialchars($_POST["mail"], ENT_QUOTES, 'UTF-8') : '';
        $kayitidsi = isset($_POST["kayitidsi"]) ? intval($_POST["kayitidsi"]) : 0;

        if (!empty($mail) && $kayitidsi > 0) {
            $guncelle = $db->prepare("UPDATE bulten SET mail = :mail WHERE id = :id");
            $guncelle->bindParam(':mail', $mail, PDO::PARAM_STR);
            $guncelle->bindParam(':id', $kayitidsi, PDO::PARAM_INT);

            if ($guncelle->execute()) {
                echo '<div class="alert alert-success mt-3 text-center">Güncelleme başarılı!</div>';
                header("refresh:2;url=control.php?sayfa=bulten");
            } else {
                echo '<div class="alert alert-danger mt-3 text-center">Güncelleme yapılırken bir hata oluştu!</div>';
            }
        } else {
            echo '<div class="alert alert-warning mt-3 text-center">Lütfen tüm alanları doldurun!</div>';
        }
    }
}






function bakim($db) {
    // SQL sorgusuyla tekrar eden kayıtları buluyoruz
    $deger = parent::sorgum($db, "SELECT max(ID) AS ID FROM bulten GROUP BY mail HAVING COUNT(*) > 1", 0);

    // Tekrar eden kayıtlar varsa
    if ($deger->rowCount() > 0) {
        $idler = []; // ID'leri tutacak bir dizi tanımlıyoruz

        // Tüm tekrar eden ID'leri alıyoruz
        while ($d = $deger->fetch(PDO::FETCH_ASSOC)) {
            if (isset($d["ID"])) { // ID varlığını kontrol ediyoruz
                $idler[] = intval($d["ID"]); // Diziye ekliyoruz ve güvenlik için intval uyguluyoruz
            }
        }

        // Tekrar eden kayıtların toplamını yazdırıyoruz
        echo "Toplam Tekrar Eden Mail Sayısı : " . count($idler) . "</br>";

        // Tekrar eden kayıtları siliyoruz
        if (!empty($idler)) { // Dizi boş değilse işlem yapıyoruz
            parent::sorgum($db, "DELETE FROM bulten WHERE ID IN (" . implode(",", $idler) . ")", 0);

            // Silme işlemi başarılı mesajı
            echo '
            <div class="col-lg-6 mx-auto">
                <div class="alert alert-success mt-5 mb-5">TEKRAR EDEN KAYITLAR SİLİNDİ.</div>
            </div>';
            header("refresh:2;url=control.php?sayfa=bulten");
        }
    } else {
        // Tekrar eden kayıt yoksa bilgilendirme mesajı
        echo '
        <div class="col-lg-6 mx-auto">
            <div class="alert alert-info mt-5 mb-5">TEKRAR EDEN KAYIT YOK.</div>
        </div>';
        header("refresh:2;url=control.php?sayfa=bulten");
    }
}
function bulten($vt) {
  echo' <div class="row text-center">
        <div class="col-lg-12 border-bottom">
            <h3 class="float-left mt-3 text-info">BULTEN AYARLARI</h3>
        </div>

  
        <div class="col-lg-12">
    <div class="row bg-light pt-2 bg-success mt-1 text-center">

        <div class="col-lg-2">
            <form action="control.php?sayfa=bulten&icislem=ara" method="post">
                <input type="text" name="mail" class="form-control" placeholder="Aranacak Mail Adresi">
            
        </div>
         
        <div class="col-lg-1">
            <input type="submit" name="btn" value="ARA" class="btn btn-success" required="required">

            </form>
        </div>

            <div class="col-lg-3">
            <form action="cikti.php" method="post">
                
                <h5 class="border-bottom">Çıktı Formatı </h5>
                <label class="text-danger font-weight-bold">Excel: </label><input type="radio" name="tercih" class="m-2" value="excel">
                <label class="text-danger font-weight-bold">Txt: </label><input type="radio" name="tercih" class="m-2" value="txt">
            
        </div>
         
        <div class="col-lg-1">
            <input type="submit" name="btn" value="AKTAR" class="btn btn-success">

            </form>
        </div>

        <div class="col-lg-3 border-right">
            <h5 class="pt-3">Toplam Kayıt: <label class="text-danger "> '.self::satirsayisi($vt).' </label> </h5> 
        </div>

        <div class="col-lg-2 text-center mx-auto">
        <form action="control.php?sayfa=bulten&icislem=bakim " method="post">
         
        <input type="submit" name="btn" value="BAKIM" class="btn btn-info">
        </form>
        </div>

    </div>
  </div>';




  
  //Burası bana sonuçları döndürecek
  echo' <div class="col-lg-12">
  <div class="row bg-light pt-2 bg-success mt-1 text-center">';

  @$icislem = $_GET["icislem"];

  switch($icislem):
   
    case "ara":
        self::aramaformu($vt);
    break;

    case "sil":
        self::MailSil($vt);
    break;

    case "guncelle":
        self::MailGuncelle($vt);
    break;

    case "bakim":
        self::bakim($vt);
    break;

  endswitch;

   echo'</div>
  </div>';

 echo '</div>';

}

function istatistikbar ($vt) {
		
		
    echo '<div class="row w-100">


                <div class="col-lg-3 col-md-6  mt-2">
                <div class="card text-center border border-dark" >
                <div class="card-body">
                <h5 class="card-title  p-2 bg-dark text-white "> İNTRO</h5>	
                <p class="card-text"><h3><kbd class="text-warning">';
              echo parent::sorgum($vt, "SELECT * FROM intro", 0)->rowCount();
                echo'</kbd></h3></p>   
                
                </div>
                </div>
                
                </div>

                <div class="col-lg-3 col-md-6  mt-2">
                <div class="card text-center border border-dark" >
                <div class="card-body">
                <h5 class="card-title  p-2 bg-dark text-white "> ARAÇ FİLO </h5>	
                <p class="card-text"><h3><kbd class="text-warning">';

              echo parent::sorgum($vt, "SELECT * FROM filomuz", 0)->rowCount();
                echo'</kbd></h3></p>   
                </div>
                </div>
                
                </div>

                   <div class="col-lg-3 col-md-6  mt-2">
                <div class="card text-center border border-dark" >
                <div class="card-body">
                <h5 class="card-title  p-2 bg-dark text-white "> VİDEO </h5>	
                <p class="card-text"><h3><kbd class="text-warning"> ';
                 echo parent::sorgum($vt, "SELECT * FROM videolar", 0)->rowCount();
               
              
              echo'</kbd></h3></p>   
                </div>
                </div>
                
                </div>

                   <div class="col-lg-3 col-md-6  mt-2">
                <div class="card text-center border border-dark" >
                <div class="card-body">
                <h5 class="card-title  p-2 bg-dark text-white "> REFERANSLAR </h5>	
                <p class="card-text"><h3><kbd class="text-warning">';
              echo parent::sorgum($vt, "SELECT * FROM referanslar", 0)->rowCount();
                
              echo'</kbd></h3></p>   
                </div>
                </div>
                
                </div>

                   <div class="col-lg-3 col-md-6  mt-2">
                <div class="card text-center border border-dark" >
                <div class="card-body">
                <h5 class="card-title  p-2 bg-dark text-white "> MÜŞTERİ YORUMLAR </h5>	
                <p class="card-text"><h3><kbd class="text-warning">';
              echo parent::sorgum($vt, "SELECT * FROM yorumlar", 0)->rowCount();
               
              echo'</kbd></h3></p>   
                </div>
                </div>
                
                </div>

                   <div class="col-lg-3 col-md-6  mt-2">
                <div class="card text-center border border-dark" >
                <div class="card-body">
                <h5 class="card-title  p-2 bg-dark text-white "> BÜLTEN </h5>	
                <p class="card-text"><h3><kbd class="text-warning">';
              echo parent::sorgum($vt, "SELECT * FROM bulten", 0)->rowCount();
               
              echo'</kbd></h3></p>   
                </div>
                </div>
                
                </div>

                  <div class="col-lg-3 col-md-6  mt-2">
                <div class="card text-center border border-dark" >
                <div class="card-body">
                <h5 class="card-title  p-2 bg-dark text-white "> HABERLER </h5>	
                <p class="card-text"><h3><kbd class="text-warning">';
              echo parent::sorgum($vt, "SELECT * FROM  haberler ", 0)->rowCount();
               
              echo'</kbd></h3></p>   
                </div>
                </div>
                
                </div>
    
    </div>';
        
    }

                    
}
?>

                    