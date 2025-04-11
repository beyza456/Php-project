<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();

try {
    $baglanti = new PDO("mysql:host=localhost;dbname=kurumsal;charset=utf8", "root", "sdsd3490");
    $baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Veritabanı bağlantı hatası: " . $e->getMessage();
    exit;
}

class yonetim {

    function sorgum($vt, $sorgu, $tercih = 0) {
        $al = $vt->prepare($sorgu);
        $al->execute();

        if ($tercih == 1) :
            return $al->fetch(PDO::FETCH_ASSOC);
        elseif ($tercih == 2) :
            return $al->fetchAll(PDO::FETCH_ASSOC);
        else :
            return $al;
        endif;
    }

    function siteayar($baglanti) {
        $sonuc = $this->sorgum($baglanti, "SELECT * FROM ayarlar", 1);

        if ($_POST) :
            // burada veri tabanı işlemleri yapılacak

            $title = htmlspecialchars($_POST["title"]);
            $metatitle = htmlspecialchars($_POST["metatitle"]);
            $metadesc = htmlspecialchars($_POST["metadesc"]);
            $metakey = htmlspecialchars($_POST["metakey"]);
            $metaaut = htmlspecialchars($_POST["metaaut"]);
            $metaown = htmlspecialchars($_POST["metaown"]);
            $metacopy = htmlspecialchars($_POST["metacopy"]);
            $logoyazi = htmlspecialchars($_POST["logoyazi"]);
            $face = htmlspecialchars($_POST["face"]);
            $twit = htmlspecialchars($_POST["twit"]);
            $inst = htmlspecialchars($_POST["inst"]);
            $telno = htmlspecialchars($_POST["telno"]);
            $adres = htmlspecialchars($_POST["adres"]);
            $mailadres = htmlspecialchars($_POST["mailadres"]);
            $slogan = htmlspecialchars($_POST["slogan"]);
            $refsayfabas = htmlspecialchars($_POST["refsayfabas"]);
            $filosayfabas = htmlspecialchars($_POST["filosayfabas"]);
            $yorumsayfabas = htmlspecialchars($_POST["yorumsayfabas"]);
            $iletisimsayfabas = htmlspecialchars($_POST["iletisimsayfabas"]);

            // burada bunların boş veya dolu olup olmadığı kontrol edilecek

            $guncelle = $baglanti->prepare("UPDATE ayarlar SET title=?, metatitle=?, metadesc=?, metakey=?, metaauthor=?, metaowner=?, metacopy=?, logoyazisi=?, face=?, twit=?, ints=?, telefonno=?, adres=?, mailadres=?, slogan=?, referansbaslik=?, filobaslik=?, yorumbaslik=?, iletisimbaslik=?");

            $guncelle->bindParam(1, $title, PDO::PARAM_STR);
            $guncelle->bindParam(2, $metatitle, PDO::PARAM_STR);
            $guncelle->bindParam(3, $metadesc, PDO::PARAM_STR);
            $guncelle->bindParam(4, $metakey, PDO::PARAM_STR);
            $guncelle->bindParam(5, $metaaut, PDO::PARAM_STR);
            $guncelle->bindParam(6, $metaown, PDO::PARAM_STR);
            $guncelle->bindParam(7, $metacopy, PDO::PARAM_STR);
            $guncelle->bindParam(8, $logoyazi, PDO::PARAM_STR);
            $guncelle->bindParam(9, $face, PDO::PARAM_STR);
            $guncelle->bindParam(10, $twit, PDO::PARAM_STR);
            $guncelle->bindParam(11, $inst, PDO::PARAM_STR);
            $guncelle->bindParam(12, $telno, PDO::PARAM_STR);
            $guncelle->bindParam(13, $adres, PDO::PARAM_STR);
            $guncelle->bindParam(14, $mailadres, PDO::PARAM_STR);
            $guncelle->bindParam(15, $slogan, PDO::PARAM_STR);
            $guncelle->bindParam(16, $refsayfabas, PDO::PARAM_STR);
            $guncelle->bindParam(17, $filosayfabas, PDO::PARAM_STR);
            $guncelle->bindParam(18, $yorumsayfabas, PDO::PARAM_STR);
            $guncelle->bindParam(19, $iletisimsayfabas, PDO::PARAM_STR);

            if ($guncelle->execute()) {
                // Güncelleme Başarılı
                echo '<div class="alert alert-success mt-5" role="alert">Güncelleme Başarılı</div>';
                header("refresh:2;url=control.php");
                exit;
            } else {
                echo '<div class="alert alert-danger" role="alert">Güncelleme Başarısız</div>';
            }

        else :
?>



            <form action="control.php?sayfa=siteayar" method="post">
                <div class="row">
                    <div class="col-lg-7 mx-auto mt-2 ">
                        <h3 class="text-info">SİTE AYARLARI </h3>
                    </div>
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Title</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="title" class="form-control" value="<?php echo isset($sonuc['title']) ? $sonuc['title'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Meta Title</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="metatitle" class="form-control" value="<?php echo isset($sonuc['metatitle']) ? $sonuc['metatitle'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Sayfa Açıklama</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="metadesc" class="form-control" value="<?php echo isset($sonuc['metadesc']) ? $sonuc['metadesc'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Anahtar Kelimeler</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="metakey" class="form-control" value="<?php echo isset($sonuc['metakey']) ? $sonuc['metakey'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Yapımcı</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="metaaut" class="form-control" value="<?php echo isset($sonuc['metaauthor']) ? $sonuc['metaauthor'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Firma</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="metaown" class="form-control" value="<?php echo isset($sonuc['metaowner']) ? $sonuc['metaowner'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Copyright</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="metacopy" class="form-control" value="<?php echo isset($sonuc['metacopy']) ? $sonuc['metacopy'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Logo Yazisi</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="logoyazi" class="form-control" value="<?php echo isset($sonuc['logoyazisi']) ? $sonuc['logoyazisi'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Twitter</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="twit" class="form-control" value="<?php echo isset($sonuc['twit']) ? $sonuc['twit'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Facebok</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="face" class="form-control" value="<?php echo isset($sonuc['face']) ? $sonuc['face'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Instagiram</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="inst" class="form-control" value="<?php echo isset($sonuc['ints']) ? $sonuc['ints'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Telefon Numarası</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="telno" class="form-control" value="<?php echo isset($sonuc['telefonno']) ? $sonuc['telefonno'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Adres</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="adres" class="form-control" value="<?php echo isset($sonuc['adres']) ? $sonuc['adres'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Mail Adresi</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="mailadres" class="form-control" value="<?php echo isset($sonuc['mailadres']) ? $sonuc['mailadres'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Slogan</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="slogan" class="form-control" value="<?php echo isset($sonuc['slogan']) ? $sonuc['slogan'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Referans Başlık</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="refsayfabas" class="form-control" value="<?php echo isset($sonuc['referansbaslik']) ? $sonuc['referansbaslik'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Filo Başlık</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="filosayfabas" class="form-control" value="<?php echo isset($sonuc['filobaslik']) ? $sonuc['filobaslik'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Yorum Başlık</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="yorumsayfabas" class="form-control" value="<?php echo isset($sonuc['yorumbaslik']) ? $sonuc['yorumbaslik'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">İletişim Başlık</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="iletisimsayfabas" class="form-control" value="<?php echo isset($sonuc['iletisimbaslik']) ? $sonuc['iletisimbaslik'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border-bottom">
                        <input type="submit" name="buton" class="btn btn rounded btn-info m-1" value="GÜNCELLE" />
                    </div>
                </div>
            </form>
<?php
        
    endif;
    }

    function sifrele($veri) {
        return base64_encode(gzdeflate(gzcompress(serialize($veri))));
    }

    function coz($veri) {
        $decoded = base64_decode($veri);
        if ($decoded === false) {
            return false;
        }
        $inflated = gzinflate($decoded);
        if ($inflated === false) {
            return false;
        }
        $uncompressed = gzuncompress($inflated);
        if ($uncompressed === false) {
            return false;
        }
        return unserialize($uncompressed);
    }

    function kuladial($vt) {
        if (!isset($_COOKIE["kulbilgi"])) {
            return false;
        }
        $cookid = $_COOKIE["kulbilgi"];
        $cozduk = self::coz($cookid);
        if ($cozduk === false) {
            return false;
        }
        $sorgusonuc = $this->sorgum($vt, "SELECT * FROM yonetim WHERE id=$cozduk", 1);
        return $sorgusonuc["kulad"];
    }

    function giriskontrol($kulad, $sifre, $vt) {
        $sifrelihal = md5(sha1(md5($sifre)));
        $sor = $vt->prepare("SELECT * FROM yonetim WHERE kulad=:kulad AND sifre=:sifre");
        $sor->bindParam(':kulad', $kulad, PDO::PARAM_STR);
        $sor->bindParam(':sifre', $sifrelihal, PDO::PARAM_STR);
        $sor->execute();

        if ($sor->rowCount() == 0) :
            echo '<div class="alert alert-danger mt-5" role="alert">Bilgiler hatalı!</div>';
            header("refresh:2;url=index.php");
            exit;
        else:
            $gelendeger = $sor->fetch();
            $sor = $vt->prepare("UPDATE yonetim SET aktif=1 WHERE kulad=:kulad AND sifre=:sifre");
            $sor->bindParam(':kulad', $kulad, PDO::PARAM_STR);
            $sor->bindParam(':sifre', $sifrelihal, PDO::PARAM_STR);
            $sor->execute();

            // cookie
            $id = self::sifrele($gelendeger["id"]);
            setcookie("kulbilgi", $id, time() + (86400 * 30), "/"); // 30 gün geçerli olacak şekilde ayarlandı

            // Giriş başarılı, kullanıcıyı yönlendirin
            echo '<div class="alert alert-info mt-5" role="alert">Giriş yapılıyor!</div>';
            header("refresh:2;url=control.php");
            exit;
        endif;
    }

    function cikis($vt) {
        if (!isset($_COOKIE["kulbilgi"])) {
            return false;
        }
        $cookid = $_COOKIE["kulbilgi"];
        $cozduk = self::coz($cookid);
        if ($cozduk === false) {
            return false;
        }
        self::sorgum($vt, "UPDATE yonetim SET aktif=0 WHERE id=$cozduk", 0);
        setcookie("kulbilgi", "", time() - 3600, "/");
        echo '<div class="alert alert-info mt-5" role="alert">Çıkış yapılıyor!</div>';
        header("refresh:2;url=index.php");
        exit;
    }

    function kontrolet($sayfa) {
        if (!isset($_COOKIE["kulbilgi"])) {
            if ($sayfa == "cot") {
                header("Location:index.php");
                exit;
            }
        } else {
            if ($sayfa == "ind") {
                header("Location:control.php");
                exit;
            }
        }
    }

    
    
    
    
    
    
    
    function introayar($vt) {
        echo '<div class="row text-center">
        <div class="col-lg-12">
            <a href="control.php?sayfa=introresimekle" class="btn btn-success m-2">Resim Ekle</a>
        </div>
        
        ';
        
        $introbilgiler = self::sorgum($vt, "SELECT * FROM intro", 2);
        foreach ($introbilgiler as $sonbilgi) {
            echo '<div class="col-lg-4">
                <div class="row border border-light p-1 m-1">
                    <div class="col-lg-12">
                        <img src="../../' . $sonbilgi["resimyol"] . '" class="img-fluid">
                    </div>
                    <div class="col-lg-6 text-right">
                        <a href="control.php?sayfa=introresimguncelle&id=' . $sonbilgi["id"] . '" class="fa fa-edit m-2 text-success" style="font-size:25px;"></a>
                    </div>
                    <div class="col-lg-6 text-left">
                        <a href="control.php?sayfa=introresimsil&id=' . $sonbilgi["id"] . '" class="fa fa-close m-2 text-danger" style="font-size:25px;"></a>
                    </div>
                </div>
            </div>';
        }
        echo '</div>';
    }
    





    function introresimekleme($vt){
        echo '<div class="row text-center">';

        if($_POST):
            if($_FILES["dosya"]["name"]==""):
                echo '<div class="alert alert-danger mt-1" role="alert">Dosya seçilmedi, boş olamaz.</div>';
                header("refresh:2;url=control.php?sayfa=introresimekle");
                exit;

            

          else:
            if($_FILES["dosya"]["size"]>(1024*1024*5)):
            echo '<div class="alert alert-danger mt-1" role="alert">Dosya boyutu 5 MB dan büyük olamaz.</div>';
            header("refresh:2;url=control.php?sayfa=introresimekle");
            
            else:
                $izinverilen= array("image/jpeg","image/png");
                  if(!in_array($_FILES["dosya"]["type"],$izinverilen)):
                    
                    echo '<div class="alert alert-danger mt-1" role="alert">İzin verilen dosya formatı değil.</div>';
                    header("refresh:2;url=control.php?sayfa=introresimekle");
                    
                  else:
                    $dosyaminyolu='../../img/carousel/'.$_FILES["dosya"]["name"];
                    move_uploaded_file($_FILES["dosya"]["tmp_name"],$dosyaminyolu);
                    echo '<div class="alert alert-success mt-1" role="alert">Dosya başarıyla yüklendi</div>';
                    header("refresh:2;url=control.php?sayfa=introayar");

                    // İlk 6 karakteri silmek için substr kullanıyoruz
                    $veritabaniYolu = substr($dosyaminyolu, 6);

                    //dosya yüklendikten sonra veri tabanına bu kaydı ekliyoruz
                    $kayitekle= self::sorgum($vt,"INSERT INTO intro(resimyol) VALUES('$veritabaniYolu')",0);
                
                endif;
        
             
        
             endif;

        endif;

    else:

            ?>

             <div class="col-lg-4 mx-auto mt-2">
                <div class="card card-bordered">
                    <div class="card-body">
                        <h5 class="title border-bottom">İntro resim yükleme formu</h5>
                        <form action="" method="post" enctype="multipart/form-data">
                            <p class="card-text"><input type="file" name="dosya" /></p>
                            <input type="submit" name="buton" class="btn btn-primary mb-1" value="Yükle" /> 
                        </form>

                        <p class="card-text text-left text-danger border-top">
                            *İzin verilen formatlar: jpg-png<br/>
                            *İzin verilen max-boyut: 5 MB 
                        </p>
                    </div>
                </div>
             </div>
            <?php

        
        endif;
        echo '</div></div>';
    }


    function introsil($vt){
        $introid=$_GET["id"];
        $verial= self::sorgum($vt,"SELECT * FROM intro WHERE id=$introid",1);

        echo '<div class="row text center">
        <div class="col-lg-12">';
        
        //dosya silme işlemi
        unlink("../../".$verial["resimyol"]);

        //veri tabanı veri silme
        self::sorgum($vt,"DELETE  FROM intro WHERE id=$introid",0);
        
        
        echo '<div class="alert alert-success mt-1" role="alert">Dosya başarıyla silindi</div>';

        echo '</div></div>';
        header("refresh:2,url=control.php?sayfa=introayar");
        
    }

    function introresimguncelleme($vt) {
        $gelenintroid = intval($_GET["id"]); // Gelen ID'yi güvenli bir şekilde alıyoruz
    
        echo '<div class="row text-center">';
    
        if ($_POST):
            if ($_FILES["dosya"]["name"] == ""):
                echo '<div class="alert alert-danger mt-1" role="alert">Dosya seçilmedi, boş olamaz.</div>';
                header("refresh:2;url=control.php?sayfa=introayar");
                exit;
    
            else:
                if ($_FILES["dosya"]["size"] > (1024 * 1024 * 5)):
                    echo '<div class="alert alert-danger mt-1" role="alert">Dosya boyutu 5 MB dan büyük olamaz.</div>';
                    header("refresh:2;url=control.php?sayfa=introayar");
    
                else:
                    $izinverilen = array("image/jpeg", "image/png");
                    if (!in_array($_FILES["dosya"]["type"], $izinverilen)):
                        echo '<div class="alert alert-danger mt-1" role="alert">İzin verilen dosya formatı değil.</div>';
                        header("refresh:2;url=control.php?sayfa=introayar");
    
                    else:
                        // Mevcut dosyayı silme
                        $resimyolunabak = self::sorgum($vt, "SELECT * FROM intro WHERE id=$gelenintroid", 1);
                        if ($resimyolunabak && !empty($resimyolunabak["resimyol"])) {
                            $dbgelenyol = '../../' . $resimyolunabak["resimyol"];
                            if (file_exists($dbgelenyol)) {
                                unlink($dbgelenyol); // Eski dosyayı sil
                            }
                        }
    
                        // Yeni dosyayı yükleme
                        $dosyaminyolu = '../../img/carousel/' . $_FILES["dosya"]["name"];
                        if (move_uploaded_file($_FILES["dosya"]["tmp_name"], $dosyaminyolu)):
                            // İlk 6 karakteri silmek için substr kullanıyoruz
                            $veritabaniYolu = substr($dosyaminyolu, 6);
    
                            // Veritabanını güncelleme
                            self::sorgum($vt, "UPDATE intro SET resimyol='$veritabaniYolu' WHERE id=$gelenintroid", 0);
    
                            echo '<div class="alert alert-success mt-1" role="alert">Dosya başarıyla güncellendi</div>';
                            header("refresh:2;url=control.php?sayfa=introayar");
                        else:
                            echo '<div class="alert alert-danger mt-1" role="alert">Dosya yüklenirken bir hata oluştu.</div>';
                            header("refresh:2;url=control.php?sayfa=introayar");
                        endif;
                    endif;
                endif;
            endif;
    
        else:
            // Güncelleme formunu gösteriyoruz
            ?>
            <div class="col-lg-4 mx-auto mt-2">
                <div class="card card-bordered">
                    <div class="card-body">
                        <h5 class="title border-bottom">İntro resim güncelleme formu</h5>
                        <form action="" method="post" enctype="multipart/form-data">
                            <p class="card-text"><input type="file" name="dosya" /></p>
                            <p class="card-text"><input type="hidden" name="introid" value="<?php echo $gelenintroid; ?>" /></p>
                            <input type="submit" name="buton" class="btn btn-primary mb-1" value="Yükle" />
                        </form>
    
                        <p class="card-text text-left text-danger border-top">
                            *İzin verilen formatlar: jpg-png<br/>
                            *İzin verilen max-boyut: 5 MB
                        </p>
                    </div>
                </div>
            </div>
            <?php
        endif;
    
        echo '</div></div>';
    }

    //Filo ayarları
function aracfilo($vt) {
    
    echo '<div class="row text-center">
        <div class="col-lg-12 border-bottom"><h3 class="float-left mt-3 text-info">Araç Filo Resimleri</h3></div>
        <a href="control.php?sayfa=aracfiloekle" class="btn btn-success m-2">Resim Ekle</a>
    </div>';

    echo '<div class="row">'; // Resimleri bir satırda düzenlemek için row sınıfı ekleniyor

    $filobilgiler = self::sorgum($vt, "SELECT * FROM filomuz", 2);
    if ($filobilgiler) {
        foreach ($filobilgiler as $sonbilgi) {
            echo '<div class="col-lg-3 col-md-4 col-sm-6 mb-4"> <!-- Her resim için bir sütun -->
                <div class="card">
                    <img src="../../' . $sonbilgi["resimyol"] . '" class="card-img-top img-fluid" alt="Araç Filo Resmi">
                    <div class="card-body text-center">
                        <a href="control.php?sayfa=aracfiloguncelle&id=' . $sonbilgi["id"] . '" class="btn btn-sm btn-success m-1">Güncelle</a>
                        <a href="control.php?sayfa=aracfilosil&id=' . $sonbilgi["id"] . '" class="btn btn-sm btn-danger m-1">Sil</a>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo '<div class="col-lg-12">
            <div class="alert alert-warning mt-5" role="alert">Hiçbir araç filo resmi bulunamadı!</div>
        </div>';
    }

    echo '</div>'; // row sınıfını kapatıyoruz

}
function aracfiloekleme($vt) {
        echo '<div class="row text-center">';
    
        if ($_POST):
            if ($_FILES["dosya"]["name"] == ""):
                echo '<div class="alert alert-danger mt-1" role="alert">Dosya seçilmedi, boş olamaz.</div>';
                header("refresh:2;url=control.php?sayfa=aracfiloekle");
                exit;
    
            else:
                if ($_FILES["dosya"]["size"] > (1024 * 1024 * 5)):
                    echo '<div class="alert alert-danger mt-1" role="alert">Dosya boyutu 5 MB dan büyük olamaz.</div>';
                    header("refresh:2;url=control.php?sayfa=aracfiloekle");
    
                else:
                    $izinverilen = array("image/jpeg", "image/png");
                    if (!in_array($_FILES["dosya"]["type"], $izinverilen)):
                        echo '<div class="alert alert-danger mt-1" role="alert">İzin verilen dosya formatı değil.</div>';
                        header("refresh:2;url=control.php?sayfa=aracfiloekle");
    
                    else:
                        $dosyaminyolu = '../../img/filo/' . $_FILES["dosya"]["name"];
                        move_uploaded_file($_FILES["dosya"]["tmp_name"], $dosyaminyolu);
                        echo '<div class="alert alert-success mt-1" role="alert">Dosya başarıyla yüklendi</div>';
                        header("refresh:2;url=control.php?sayfa=aracfilo");
    
                        // İlk 6 karakteri silmek için substr kullanıyoruz
                        $veritabaniYolu = substr($dosyaminyolu, 6);
    
                        // Veritabanına kaydet
                        self::sorgum($vt, "INSERT INTO filomuz(resimyol) VALUES('$veritabaniYolu')", 0);
                    endif;
                endif;
            endif;
    

    else:

           
           ?>

             <div class="col-lg-4 mx-auto mt-2">
                <div class="card card-bordered">
                    <div class="card-body">
                        <h5 class="title border-bottom">Araç filo resim yükleme formu</h5>
                        <form action="" method="post" enctype="multipart/form-data">
                            <p class="card-text"><input type="file" name="dosya" /></p>
                            <input type="submit" name="buton" class="btn btn-primary mb-1" value="Yükle" /> 
                        </form>

                        <p class="card-text text-left text-danger border-top">
                            *İzin verilen formatlar: jpg-png<br/>
                            *İzin verilen max-boyut: 5 MB 
                        </p>
                    </div>
                </div>
             </div>
            <?php

        
        endif;
        echo '</div></div>';
}


    
function aracfilosil($vt) {
    $introid = $_GET["id"];
    $verial = self::sorgum($vt, "SELECT * FROM filomuz WHERE id=$introid", 1);

    echo '<div class="row text center">
    <div class="col-lg-12">';

    // Dosya silme işlemi
    unlink("../../" . $verial["resimyol"]);

    // Veritabanından kaydı sil
    self::sorgum($vt, "DELETE FROM filomuz WHERE id=$introid", 0);

    echo '<div class="alert alert-success mt-1" role="alert">Dosya başarıyla silindi</div>';
    echo '</div></div>';
    header("refresh:2,url=control.php?sayfa=aracfilo");
}

function aracfiloguncelleme($vt) {
        $gelenintroid = intval($_GET["id"]); // Gelen ID'yi güvenli bir şekilde alıyoruz
    
        echo '<div class="row text-center">';
    
        if ($_POST):
            if ($_FILES["dosya"]["name"] == ""):
                echo '<div class="alert alert-danger mt-1" role="alert">Dosya seçilmedi, boş olamaz.</div>';
                header("refresh:2;url=control.php?sayfa=aracfilo");
                exit;
    
            else:
                if ($_FILES["dosya"]["size"] > (1024 * 1024 * 5)):
                    echo '<div class="alert alert-danger mt-1" role="alert">Dosya boyutu 5 MB dan büyük olamaz.</div>';
                    header("refresh:2;url=control.php?sayfa=aracfilo");
    
                else:
                    $izinverilen = array("image/jpeg", "image/png");
                    if (!in_array($_FILES["dosya"]["type"], $izinverilen)):
                        echo '<div class="alert alert-danger mt-1" role="alert">İzin verilen dosya formatı değil.</div>';
                        header("refresh:2;url=control.php?sayfa=aracfilo");
    
                    else:
                        // Mevcut dosyayı silme
                        $resimyolunabak = self::sorgum($vt, "SELECT * FROM filomuz WHERE id=$gelenintroid", 1);
                        if ($resimyolunabak && !empty($resimyolunabak["resimyol"])) {
                            $dbgelenyol = '../../' . $resimyolunabak["resimyol"];
                            if (file_exists($dbgelenyol)) {
                                unlink($dbgelenyol); // Eski dosyayı sil
                            }
                        }
    
                        // Yeni dosyayı yükleme
                        $dosyaminyolu = '../../img/filo/' . $_FILES["dosya"]["name"];
                        if (move_uploaded_file($_FILES["dosya"]["tmp_name"], $dosyaminyolu)):
                            // İlk 6 karakteri silmek için substr kullanıyoruz
                            $veritabaniYolu = substr($dosyaminyolu, 6);
    
                            // Veritabanını güncelleme
                            self::sorgum($vt, "UPDATE filomuz SET resimyol='$veritabaniYolu' WHERE id=$gelenintroid", 0);
    
                            echo '<div class="alert alert-success mt-1" role="alert">Dosya başarıyla güncellendi</div>';
                            header("refresh:2;url=control.php?sayfa=aracfilo");
                        else:
                            echo '<div class="alert alert-danger mt-1" role="alert">Dosya yüklenirken bir hata oluştu.</div>';
                            header("refresh:2;url=control.php?sayfa=aracfilo");
                        endif;
                    endif;
                endif;
            endif;
    
        else:
            // Güncelleme formunu gösteriyoruz
            ?>
            <div class="col-lg-4 mx-auto mt-2">
                <div class="card card-bordered">
                    <div class="card-body">
                        <h5 class="title border-bottom">Araç filo resim güncelleme formu</h5>
                        <form action="" method="post" enctype="multipart/form-data">
                            <p class="card-text"><input type="file" name="dosya" /></p>
                            <p class="card-text"><input type="hidden" name="introid" value="<?php echo $gelenintroid; ?>" /></p>
                            <input type="submit" name="buton" class="btn btn-primary mb-1" value="Yükle" />
                        </form>
    
                        <p class="card-text text-left text-danger border-top">
                            *İzin verilen formatlar: jpg-png<br/>
                            *İzin verilen max-boyut: 5 MB
                        </p>
                    </div>
                </div>
            
            </div>
            <?php
        endif;
    
        echo '</div></div>';
}




    //Hakkımızda Ayarları
   
  
function hakkimizda($vt) {
    echo '<div class="row text-center">
        <div class="col-lg-12 border-bottom">
            <h3 class="mt-3 text-info">Hakkımızda Ayarları</h3>
        </div>
    </div>';

    echo '<div class="row">'; // Resimleri bir satırda düzenlemek için row sınıfı ekleniyor

    // Veritabanından verileri çekiyoruz
    $filobilgiler = self::sorgum($vt, "SELECT * FROM hakkimizda", 2);

    if ($filobilgiler && is_array($filobilgiler)) { // Sorgunun başarılı olduğunu ve bir dizi döndürdüğünü kontrol ediyoruz
        foreach ($filobilgiler as $sonbilgi) {
            echo '<div class="col-lg-4 col-md-6 col-sm-12 mb-4 d-flex align-items-stretch"> <!-- Her resim için bir sütun -->
                <div class="card h-100 shadow-sm">
                    <img src="../../' . htmlspecialchars($sonbilgi["resim"]) . '" class="card-img-top img-fluid" alt="Hakkımızda Resmi">
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="baslik" class="form-label">Başlık</label>
                                <input type="text" name="baslik" class="form-control" value="' . htmlspecialchars($sonbilgi["baslik"]) . '" required>
                            </div>
                            <div class="mb-3">
                                <label for="icerik" class="form-label">İçerik</label>
                                <textarea name="icerik" class="form-control" rows="5" required>' . htmlspecialchars($sonbilgi["icerik"]) . '</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="dosya" class="form-label">Resim</label>
                                <input type="file" name="dosya" class="form-control">
                            </div>
                            <input type="hidden" name="id" value="' . $sonbilgi["id"] . '">
                            <button type="submit" name="buton" class="btn btn-primary">Güncelle</button>
                        </form>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo '<div class="col-lg-12">
            <div class="alert alert-warning mt-5" role="alert">Hiçbir veri bulunamadı!</div>
        </div>';
    }

    echo '</div>'; // row sınıfını kapatıyoruz

    // Form gönderildiğinde güncelleme işlemi
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;
        $baslik = isset($_POST["baslik"]) ? htmlspecialchars($_POST["baslik"], ENT_QUOTES, 'UTF-8') : '';
        $icerik = isset($_POST["icerik"]) ? htmlspecialchars($_POST["icerik"], ENT_QUOTES, 'UTF-8') : '';

        // Dosya yükleme işlemi
        $veritabaniYolu = null;
        if (isset($_FILES["dosya"]) && $_FILES["dosya"]["name"] !== "") {
            if ($_FILES["dosya"]["size"] <= (1024 * 1024 * 5)) { // 5 MB kontrolü
                $izinverilen = array("image/jpeg", "image/png");
                if (in_array($_FILES["dosya"]["type"], $izinverilen)) {
                    $dosyaminyolu = '../../img/' . $_FILES["dosya"]["name"];
                    if (move_uploaded_file($_FILES["dosya"]["tmp_name"], $dosyaminyolu)) {
                        $veritabaniYolu = substr($dosyaminyolu, 6); // İlk 6 karakteri sil
                    }
                } else {
                    echo '<div class="alert alert-danger mt-1" role="alert">İzin verilen dosya formatı değil.</div>';
                    return;
                }
            } else {
                echo '<div class="alert alert-danger mt-1" role="alert">Dosya boyutu 5 MB\'dan büyük olamaz.</div>';
                return;
            }
        }

        // Veritabanı güncelleme
        if ($veritabaniYolu) {
            $guncelle = $vt->prepare("UPDATE hakkimizda SET baslik = :baslik, icerik = :icerik, resim = :resim WHERE id = :id");
            $guncelle->bindParam(':resim', $veritabaniYolu, PDO::PARAM_STR);
        } else {
            $guncelle = $vt->prepare("UPDATE hakkimizda SET baslik = :baslik, icerik = :icerik WHERE id = :id");
        }

        $guncelle->bindParam(':baslik', $baslik, PDO::PARAM_STR);
        $guncelle->bindParam(':icerik', $icerik, PDO::PARAM_STR);
        $guncelle->bindParam(':id', $id, PDO::PARAM_INT);

        if ($guncelle->execute()) {
            echo '<div class="alert alert-success mt-1" role="alert">Güncelleme başarılı!</div>';
            header("refresh:2;url=control.php?sayfa=hakkimizda");
        } else {
            echo '<div class="alert alert-danger mt-1" role="alert">Güncelleme başarısız!</div>';
        }
    }
}





//Hizmetlerimiz Ayarları

function hizmetlerhepsi($vt) {
    echo '<div class="row text-center">
        <div class="col-lg-12 border-bottom">
            <h3 class="float-left mt-3 text-info">Hizmetlerimiz</h3>
        </div>
        <a href="control.php?sayfa=hizmetekle" class="btn btn-success m-2">Hizmet Ekle</a>
    </div>';

    echo '<div class="row justify-content-center">'; // Hizmetleri ortalamak için justify-content-center sınıfı ekleniyor

    // Veritabanından hizmetleri çekiyoruz
    $filobilgiler = self::sorgum($vt, "SELECT * FROM hizmetler", 2);
    if ($filobilgiler) {
        foreach ($filobilgiler as $sonbilgi) {
            echo '<div class="col-lg-4 col-md-6 col-sm-12 mb-4"> <!-- Her hizmet için bir sütun -->
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="card-title">' . htmlspecialchars($sonbilgi["baslik"], ENT_QUOTES, 'UTF-8') . '</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">' . htmlspecialchars($sonbilgi["icerik"], ENT_QUOTES, 'UTF-8') . '</p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="control.php?sayfa=hizmetguncelle&id=' . $sonbilgi["id"] . '" class="btn btn-sm btn-success m-1">Güncelle</a>
                        <a href="control.php?sayfa=hizmetsil&id=' . $sonbilgi["id"] . '" class="btn btn-sm btn-danger m-1">Sil</a>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo '<div class="col-lg-12">
            
        <div class="alert alert-warning mt-5" role="alert">Hiçbir hizmet bulunamadı!</div>
        </div>';
    }

    echo '</div>'; // row sınıfını kapatıyoruz
}


function hizmetekleme($vt) {
    echo '<div class="row text-center">
        <div class="col-lg-12 border-bottom">
            <h3 class="mt-3 text-info">Hizmet Ekle</h3>
        </div>
    </div>';

    echo '<div class="row justify-content-center mt-4">'; // Ortalamak için justify-content-center sınıfı ekleniyor

    // Hizmet ekleme formu
    echo '<div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white text-center">
                <h5>Yeni Hizmet Ekle</h5>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="baslik" class="form-label">Başlık</label>
                        <input type="text" name="baslik" id="baslik" class="form-control" placeholder="Hizmet başlığını girin" required>
                    </div>
                    <div class="mb-3">
                        <label for="icerik" class="form-label">İçerik</label>
                        <textarea name="icerik" id="icerik" class="form-control" rows="5" placeholder="Hizmet içeriğini girin" required></textarea>
                    </div>
                    <div class="text-center">
                        <input type="submit" name="buton" class="btn btn-primary" value="Hizmet Ekle">
                    </div>
                </form>
            </div>
        </div>
    </div>';

    echo '</div>'; // row sınıfını kapatıyoruz

    // Form gönderildiğinde veritabanına ekleme işlemi
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $baslik = isset($_POST["baslik"]) ? htmlspecialchars($_POST["baslik"], ENT_QUOTES, 'UTF-8') : '';
        $icerik = isset($_POST["icerik"]) ? htmlspecialchars($_POST["icerik"], ENT_QUOTES, 'UTF-8') : '';

        if (!empty($baslik) && !empty($icerik)) {
            $ekle = $vt->prepare("INSERT INTO hizmetler (baslik, icerik) VALUES (:baslik, :icerik)");
            $ekle->bindParam(':baslik', $baslik, PDO::PARAM_STR);
            $ekle->bindParam(':icerik', $icerik, PDO::PARAM_STR);

            if ($ekle->execute()) {
                echo '<div class="alert alert-success mt-3 text-center">Hizmet başarıyla eklendi!</div>';
                header("refresh:2;url=control.php?sayfa=hizmetler");
            } else {
                echo '<div class="alert alert-danger mt-3 text-center">Hizmet eklenirken bir hata oluştu!</div>';
            }
        } else {
            echo '<div class="alert alert-warning mt-3 text-center">Lütfen tüm alanları doldurun!</div>';
        }
    }
}


function hizmetguncelleme($vt) {
    echo '<div class="row text-center">
        <div class="col-lg-12 border-bottom">
            <h3 class="mt-3 text-info">Hizmet Güncelle</h3>
        </div>
    </div>';

    /*
    İlk gelen id alınacak
    id ile veri tabanına çıkılıp veri çekilecek
    İnputlara o veriler yazılacak
    hidden ile id post için taşınacak
    Form gönderildiğinde güncelleme işlemi yapılacak
    */ 

    $kayitid = $_GET["id"];
    $kayitbilgial= self::sorgum($vt, "SELECT * FROM hizmetler WHERE id=$kayitid", 1);

    echo '<div class="row justify-content-center mt-4">'; // Ortalamak için justify-content-center sınıfı ekleniyor

    // Hizmet ekleme formu
    echo '<div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white text-center">
                <h5>Yeni Hizmet Ekle</h5>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="baslik" class="form-label">Başlık</label>
                        <input type="text" name="baslik" id="baslik" class="form-control" value="'.$kayitbilgial["baslik"].'" placeholder="Hizmet başlığını girin" required>
                    </div>
                    <div class="mb-3">
                        <label for="icerik" class="form-label">İçerik</label>
                        <textarea name="icerik" id="icerik" class="form-control" rows="5" placeholder="Hizmet içeriğini girin" required>'.$kayitbilgial["icerik"].'</textarea>
                    </div>
                    <div class="text-center">
                        <input type="hidden" name="kayitidsi" value="'.$kayitbilgial["id"].'">
                        
                        <input type="submit" name="buton" class="btn btn-primary" value="Güncelle">
                    </div>
                </form>
            </div>
        </div>
    </div>';

    echo '</div>'; // row sınıfını kapatıyoruz

    // Form gönderildiğinde veritabanına ekleme işlemi
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $baslik = isset($_POST["baslik"]) ? htmlspecialchars($_POST["baslik"], ENT_QUOTES, 'UTF-8') : '';
        $icerik = isset($_POST["icerik"]) ? htmlspecialchars($_POST["icerik"], ENT_QUOTES, 'UTF-8') : '';
        $kayitidsi = isset($_POST["kayitidsi"]) ? htmlspecialchars($_POST["kayitidsi"], ENT_QUOTES, 'UTF-8') : '';

        if (!empty($baslik) && !empty($icerik)) {
            $ekle = $vt->prepare("UPDATE hizmetler SET baslik = :baslik, icerik = :icerik WHERE id = :kayitidsi");
            $ekle->bindParam(':kayitidsi', $kayitidsi, PDO::PARAM_INT);
            $ekle->bindParam(':baslik', $baslik, PDO::PARAM_STR);
            $ekle->bindParam(':icerik', $icerik, PDO::PARAM_STR);

            if ($ekle->execute()) {
                echo '<div class="alert alert-success mt-3 text-center">Güncelleme başarılı!</div>';
                header("refresh:2;url=control.php?sayfa=hizmetler");
            } else {
                echo '<div class="alert alert-danger mt-3 text-center">Güncelleme yapılırken bir hata oluştu!</div>';
            }
        } else {
            echo '<div class="alert alert-warning mt-3 text-center">Lütfen tüm alanları doldurun!</div>';
        }
    }
}



function hizmetsil($vt) {
    $kayitid = $_GET["id"];
    

    echo '<div class="row text center">
    <div class="col-lg-12">';

    self::sorgum($vt, "DELETE FROM hizmetler WHERE id=$kayitid", 0);

    echo '<div class="alert alert-success mt-1" role="alert">Silme başarılı</div>';
    echo '</div></div>';
    header("refresh:2,url=control.php?sayfa=hizmetler");
}

//Referanslar Ayarları
function referanslarhepsi($vt) {
    
    echo '<div class="row text-center">
        <div class="col-lg-12 border-bottom"><h3 class="float-left mt-3 text-info">Referanslar</h3></div>
        <a href="control.php?sayfa=refekle" class="btn btn-success m-2">Referans Ekle</a>
    </div>';

    echo '<div class="row">'; // Resimleri bir satırda düzenlemek için row sınıfı ekleniyor

    $filobilgiler = self::sorgum($vt, "SELECT * FROM referanslar", 2);
    if ($filobilgiler) {
        foreach ($filobilgiler as $sonbilgi) {
            echo '<div class="col-lg-2 col-md-4 col-sm-6 mb-4"> <!-- Her resim için bir sütun -->
                <div class="card">
                    <img src="../../' . $sonbilgi["resimyol"] . '" class="card-img-top img-fluid" alt="Araç Filo Resmi">
                    <div class="card-body text-center">
                        
                        <a href="control.php?sayfa=refsil&id=' . $sonbilgi["id"] . '" class="btn btn-sm btn-danger m-1">Sil</a>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo '<div class="col-lg-12">
            <div class="alert alert-warning mt-5" role="alert">Hiçbir araç filo resmi bulunamadı!</div>
        </div>';
    }

    echo '</div>'; // row sınıfını kapatıyoruz

}

function refekleme($vt) {
        echo '<div class="row text-center">';
    
        if ($_POST):
            if ($_FILES["dosya"]["name"] == ""):
                echo '<div class="alert alert-danger mt-1" role="alert">Dosya seçilmedi, boş olamaz.</div>';
                header("refresh:2;url=control.php?sayfa=ref");
                exit;
    
            else:
                if ($_FILES["dosya"]["size"] > (1024 * 1024 * 5)):
                    echo '<div class="alert alert-danger mt-1" role="alert">Dosya boyutu 5 MB dan büyük olamaz.</div>';
                    header("refresh:2;url=control.php?sayfa=ref");
    
                else:
                    $izinverilen = array("image/jpeg", "image/png");
                    if (!in_array($_FILES["dosya"]["type"], $izinverilen)):
                        echo '<div class="alert alert-danger mt-1" role="alert">İzin verilen dosya formatı değil.</div>';
                        header("refresh:2;url=control.php?sayfa=ref");
    
                    else:
                        $dosyaminyolu = '../../img/referans/' . $_FILES["dosya"]["name"];
                        move_uploaded_file($_FILES["dosya"]["tmp_name"], $dosyaminyolu);
                        echo '<div class="alert alert-success mt-1" role="alert">Dosya başarıyla yüklendi</div>';
                        header("refresh:2;url=control.php?sayfa=ref");
    
                        // İlk 6 karakteri silmek için substr kullanıyoruz
                        $veritabaniYolu = substr($dosyaminyolu, 6);
    
                        // Veritabanına kaydet
                        self::sorgum($vt, "INSERT INTO referanslar(resimyol) VALUES('$veritabaniYolu')", 0);
                    endif;
                endif;
            endif;
    

    else:

           
           ?>

             <div class="col-lg-4 mx-auto mt-2">
                <div class="card card-bordered">
                    <div class="card-body">
                        <h5 class="title border-bottom">Referans ekleme formu</h5>
                        <form action="" method="post" enctype="multipart/form-data">
                            <p class="card-text"><input type="file" name="dosya" /></p>
                            <input type="submit" name="buton" class="btn btn-primary mb-1" value="Yükle" /> 
                        </form>

                        <p class="card-text text-left text-danger border-top">
                            *İzin verilen formatlar: jpg-png<br/>
                            *İzin verilen max-boyut: 5 MB 
                        </p>
                    </div>
                </div>
             </div>
            <?php

        
        endif;
        echo '</div></div>';
}


    
function refsil($vt) {
    $refid = $_GET["id"];
    $verial = self::sorgum($vt, "SELECT * FROM referanslar WHERE id=$refid", 1);

    echo '<div class="row text center">
    <div class="col-lg-12">';

    // Dosya silme işlemi
    unlink("../../" . $verial["resimyol"]);

    // Veritabanından kaydı sil
    self::sorgum($vt, "DELETE FROM referanslar WHERE id=$refid", 0);

    echo '<div class="alert alert-success mt-1" role="alert">Silme başarılı</div>';
    echo '</div></div>';
    header("refresh:2,url=control.php?sayfa=ref");
}

//Müşteri Yorumları Ayarları

function yorumlarhepsi($vt) {
    echo '<div class="row text-center">
        <div class="col-lg-12 border-bottom">
            <h3 class="float-left mt-3 text-info">MÜŞTERİ YORUMLARI</h3>
        </div>
        <a href="control.php?sayfa=yorumekle" class="btn btn-success m-2 ">Yorum Ekle</a>
    </div>';

    echo '<div class="row justify-content-center">'; // Hizmetleri ortalamak için justify-content-center sınıfı ekleniyor

    // Veritabanından hizmetleri çekiyoruz
    $filobilgiler = self::sorgum($vt, "SELECT * FROM yorumlar", 2);
    if ($filobilgiler) {
        foreach ($filobilgiler as $sonbilgi) {
            echo '<div class="col-lg-4 col-md-6 col-sm-12 mb-4"> <!-- Her hizmet için bir sütun -->
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="card-title">İsim:' . htmlspecialchars($sonbilgi["isim"], ENT_QUOTES, 'UTF-8') . '</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">' . htmlspecialchars($sonbilgi["icerik"], ENT_QUOTES, 'UTF-8') . '</p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="control.php?sayfa=yorumguncelle&id=' . $sonbilgi["id"] . '" class="btn btn-sm btn-success m-1">Güncelle</a>
                        <a href="control.php?sayfa=yorumsil&id=' . $sonbilgi["id"] . '" class="btn btn-sm btn-danger m-1">Sil</a>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo '<div class="col-lg-12">
            
        <div class="alert alert-warning mt-5" role="alert">Hiçbir hizmet bulunamadı!</div>
        </div>';
    }

    echo '</div>'; // row sınıfını kapatıyoruz
}



function yorumlarekleme($vt) {
    echo '<div class="row text-center">
        <div class="col-lg-12 border-bottom">
            <h3 class="mt-3 text-info">Yorum Ekle</h3>
        </div>
    </div>';

    echo '<div class="row justify-content-center mt-4">'; // Ortalamak için justify-content-center sınıfı ekleniyor

    // Yorum ekleme formu
    echo '<div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white text-center">
                <h5>Yeni Yorum Ekle</h5>
            </div>
            <div class="card-body">
                <form action="control.php?sayfa=yorumekle" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="baslik" class="form-label">İsim</label>
                        <input type="text" name="baslik" id="baslik" class="form-control" placeholder="İsim giriniz" required>
                    </div>
                    <div class="mb-3">
                        <label for="icerik" class="form-label">Yorum</label>
                        <textarea name="icerik" id="icerik" class="form-control" rows="5" placeholder="Mesaj içeriğini girin" required></textarea>
                    </div>
                    <div class="text-center">
                        <input type="submit" name="buton" class="btn btn-primary" value="Yorum Ekle">
                    </div>
                </form>
            </div>
        </div>
    </div>';

    echo '</div>'; // row sınıfını kapatıyoruz

    // Form gönderildiğinde veritabanına ekleme işlemi
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $baslik = isset($_POST["baslik"]) ? htmlspecialchars($_POST["baslik"], ENT_QUOTES, 'UTF-8') : '';
        $icerik = isset($_POST["icerik"]) ? htmlspecialchars($_POST["icerik"], ENT_QUOTES, 'UTF-8') : '';

        if (!empty($baslik) && !empty($icerik)) {
            try {
                $ekle = $vt->prepare("INSERT INTO yorumlar (isim, icerik) VALUES (:isim, :icerik)");
                $ekle->bindParam(':isim', $baslik, PDO::PARAM_STR);
                $ekle->bindParam(':icerik', $icerik, PDO::PARAM_STR);

                if ($ekle->execute()) {
                    echo '<div class="alert alert-success mt-3 text-center">Yorum başarıyla eklendi!</div>';
                    header("refresh:2;url=control.php?sayfa=yorumlar");
                } else {
                    echo '<div class="alert alert-danger mt-3 text-center">Yorum eklenirken bir hata oluştu!</div>';
                }
            } catch (PDOException $e) {
                echo '<div class="alert alert-danger mt-3 text-center">Hata: ' . $e->getMessage() . '</div>';
            }
        } else {
            echo '<div class="alert alert-warning mt-3 text-center">Lütfen tüm alanları doldurun!</div>';
        }
    }
}

function yorumlarguncelleme($vt) {
    echo '<div class="row text-center">
        <div class="col-lg-12 border-bottom">
            <h3 class="mt-3 text-info">Yorum Güncelle</h3>
        </div>
    </div>';

    // Gelen ID'yi kontrol ediyoruz
    $kayitid = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
    if ($kayitid === 0) {
        echo '<div class="alert alert-danger mt-3 text-center">Geçersiz ID!</div>';
        return;
    }

    // Veritabanından mevcut kaydı alıyoruz
    $kayitbilgial = self::sorgum($vt, "SELECT * FROM yorumlar WHERE id=$kayitid", 1);

    if (!$kayitbilgial) {
        echo '<div class="alert alert-danger mt-3 text-center">Kayıt bulunamadı!</div>';
        return;
    }

    echo '<div class="row justify-content-center mt-4">'; // Ortalamak için justify-content-center sınıfı ekleniyor

    // Güncelleme formu
    echo '<div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white text-center">
                <h5>Yorum Güncelle</h5>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="baslik" class="form-label">İsim</label>
                        <input type="text" name="baslik" id="baslik" class="form-control" value="' . htmlspecialchars($kayitbilgial["isim"], ENT_QUOTES, 'UTF-8') . '" placeholder="İsim girin" required>
                    </div>
                    <div class="mb-3">
                        <label for="icerik" class="form-label">Yorum</label>
                        <textarea name="icerik" id="icerik" class="form-control" rows="5" placeholder="Yorum içeriğini girin" required>' . htmlspecialchars($kayitbilgial["icerik"], ENT_QUOTES, 'UTF-8') . '</textarea>
                    </div>
                    <div class="text-center">
                        <input type="hidden" name="kayitidsi" value="' . $kayitbilgial["id"] . '">
                        <input type="submit" name="buton" class="btn btn-primary" value="Güncelle">
                    </div>
                </form>
            </div>
        </div>
    </div>';

    echo '</div>'; // row sınıfını kapatıyoruz

    // Form gönderildiğinde güncelleme işlemi
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $baslik = isset($_POST["baslik"]) ? htmlspecialchars($_POST["baslik"], ENT_QUOTES, 'UTF-8') : '';
        $icerik = isset($_POST["icerik"]) ? htmlspecialchars($_POST["icerik"], ENT_QUOTES, 'UTF-8') : '';
        $kayitidsi = isset($_POST["kayitidsi"]) ? intval($_POST["kayitidsi"]) : 0;

        if (!empty($baslik) && !empty($icerik) && $kayitidsi > 0) {
            $guncelle = $vt->prepare("UPDATE yorumlar SET  isim = :isim ,icerik = :icerik WHERE id = :id");
            $guncelle->bindParam(':isim', $baslik, PDO::PARAM_STR);
            $guncelle->bindParam(':icerik', $icerik, PDO::PARAM_STR);
            $guncelle->bindParam(':id', $kayitidsi, PDO::PARAM_INT);

            if ($guncelle->execute()) {
                echo '<div class="alert alert-success mt-3 text-center">Güncelleme başarılı!</div>';
                header("refresh:2;url=control.php?sayfa=yorumlar");
            } else {
                echo '<div class="alert alert-danger mt-3 text-center">Güncelleme yapılırken bir hata oluştu!</div>';
            }
        } else {
            echo '<div class="alert alert-warning mt-3 text-center">Lütfen tüm alanları doldurun!</div>';
        }
    }
}
function yorumlarsil($vt) {
    // Gelen ID'yi kontrol ediyoruz
    $kayitid = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
    if ($kayitid === 0) {
        echo '<div class="alert alert-danger mt-3 text-center">Geçersiz ID!</div>';
        return;
    }

    // Silme işlemi
    $sil = self::sorgum($vt, "DELETE FROM yorumlar WHERE id=$kayitid", 0);

    if ($sil) {
        echo '<div class="alert alert-success mt-3 text-center">Silme işlemi başarılı!</div>';
    } else {
        echo '<div class="alert alert-danger mt-3 text-center">Silme işlemi sırasında bir hata oluştu!</div>';
    }

    header("refresh:2;url=control.php?sayfa=yorumlar");

}




}
   

 


?>