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

    private $veriler = array();
    function sorgum($vt, $sorgu, $tercih = 0) {
        try {
            // PDO nesnesi olup olmadığını kontrol ediyoruz
            if (!$vt instanceof PDO) {
                throw new Exception("Hata: Veritabanı bağlantısı geçersiz.");
            }
    
            // Sorguyu hazırlıyoruz
            $al = $vt->prepare($sorgu);
    
            // Sorguyu çalıştırıyoruz
            $al->execute();
    
            // Tercihe göre sonuç döndürüyoruz
            if ($tercih == 1) {
                return $al->fetch(PDO::FETCH_ASSOC); // Tek bir satır döndür
            } elseif ($tercih == 2) {
                return $al->fetchAll(PDO::FETCH_ASSOC); // Tüm sonuçları döndür
            } else {
                return $al; // Sorgu nesnesini döndür
            }
        } catch (PDOException $e) {
            // PDO hatalarını yakalıyoruz
            die("Veritabanı hatası: " . $e->getMessage());
        } catch (Exception $e) {
            // Diğer hataları yakalıyoruz
            die("Hata: " . $e->getMessage());
        }
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
            
            $slogan_tr = htmlspecialchars($_POST["slogan_tr"]);
            $slogan_en = htmlspecialchars($_POST["slogan_en"]);

            $refsayfabas_tr = htmlspecialchars($_POST["refsayfabas_tr"]);
            $refsayfabas_en = htmlspecialchars($_POST["refsayfabas_en"]);

            $refsayfaUstbas_tr = htmlspecialchars($_POST["refsayfaUstbas_tr"]);
            $refsayfaUstbas_en = htmlspecialchars($_POST["refsayfaUstbas_en"]);

            $filosayfabas_tr = htmlspecialchars($_POST["filosayfabas_tr"]);
            $filosayfabas_en = htmlspecialchars($_POST["filosayfabas_en"]);

            $filosayfaUstbas_tr = htmlspecialchars($_POST["filosayfaUstbas_tr"]);
            $filosayfaUstbas_en = htmlspecialchars($_POST["filosayfaUstbas_en"]);

            $yorumsayfabas_tr = htmlspecialchars($_POST["yorumsayfabas_tr"]);
            $yorumsayfabas_en = htmlspecialchars($_POST["yorumsayfabas_en"]);

            $yorumsayfaUstbas_tr = htmlspecialchars($_POST["yorumsayfaUstbas_tr"]);
            $yorumsayfaUstbas_en = htmlspecialchars($_POST["yorumsayfaUstbas_en"]);

            $iletisimsayfabas_tr = htmlspecialchars($_POST["iletisimsayfabas_tr"]);
            $iletisimsayfabas_en = htmlspecialchars($_POST["iletisimsayfabas_en"]);


            $hizmetlersayfabas_tr = htmlspecialchars($_POST["hizmetlersayfabas_tr"]);
            $hizmetlersayfabas_en = htmlspecialchars($_POST["hizmetlersayfabas_en"]);

            $hizmetlersayfaUstbas_tr = htmlspecialchars($_POST["hizmetlersayfaUstbas_tr"]);
            $hizmetlersayfaUstbas_en = htmlspecialchars($_POST["hizmetlersayfaUstbas_en"]);

            $mesajtercih = htmlspecialchars($_POST["mesajtercih"]);
            $haritabilgi = htmlspecialchars($_POST["haritabilgi"]);
            $footer = htmlspecialchars($_POST["footer"]);


            // burada bunların boş veya dolu olup olmadığı kontrol edilecek

            $guncelle = $baglanti->prepare("UPDATE ayarlar SET title=?, metatitle=?, metadesc=?, metakey=?, metaauthor=?, metaowner=?, metacopy=?, logoyazisi=?, face=?, twit=?, ints=?, telefonno=?, adres=?, mailadres=?, slogan_tr=?, slogan_en=?, referansUstBaslik_tr=?, referansUstBaslik_en=?, referansbaslik_tr=?, referansbaslik_en=?,filoUstBaslik_tr=?,filoUstBaslik_en=?,filobaslik_tr=?,filobaslik_en=?
            , yorumUstBaslik_tr=?, yorumUstBaslik_en=?, yorumbaslik_tr=?, yorumbaslik_en=?,  iletisimbaslik_tr=?, iletisimbaslik_en=?, hizmetlerUstBaslik_tr=?, hizmetlerUstBaslik_en=?, hizmetlerbaslik_tr=?, hizmetlerbaslik_en=?, mesajtercih=?, haritabilgi=?,footer=?");

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
            $guncelle->bindParam(15, $slogan_tr, PDO::PARAM_STR);
            $guncelle->bindParam(16, $slogan_en, PDO::PARAM_STR);
            $guncelle->bindParam(17, $refsayfabas_tr, PDO::PARAM_STR);
            $guncelle->bindParam(18, $refsayfabas_en, PDO::PARAM_STR);
            $guncelle->bindParam(19, $refsayfaUstbas_tr, PDO::PARAM_STR);
            $guncelle->bindParam(20, $refsayfaUstbas_en, PDO::PARAM_STR);
            $guncelle->bindParam(21, $filosayfabas_tr, PDO::PARAM_STR);
            $guncelle->bindParam(22, $filosayfabas_en, PDO::PARAM_STR);
            $guncelle->bindParam(23, $filosayfaUstbas_tr, PDO::PARAM_STR);
            $guncelle->bindParam(24, $filosayfaUstbas_en, PDO::PARAM_STR);
            $guncelle->bindParam(25, $yorumsayfabas_tr, PDO::PARAM_STR);
            $guncelle->bindParam(26, $yorumsayfabas_en, PDO::PARAM_STR);
            $guncelle->bindParam(27, $yorumsayfaUstbas_tr, PDO::PARAM_STR);
            $guncelle->bindParam(28, $yorumsayfaUstbas_en, PDO::PARAM_STR);
            $guncelle->bindParam(29, $iletisimsayfabas_tr, PDO::PARAM_STR);
            $guncelle->bindParam(30, $iletisimsayfabas_en, PDO::PARAM_STR);
            $guncelle->bindParam(31, $hizmetlersayfabas_tr, PDO::PARAM_STR);
            $guncelle->bindParam(32, $hizmetlersayfabas_en, PDO::PARAM_STR);
            $guncelle->bindParam(33, $hizmetlersayfaUstbas_tr, PDO::PARAM_STR);
            $guncelle->bindParam(34, $hizmetlersayfaUstbas_en, PDO::PARAM_STR);
            $guncelle->bindParam(35, $mesajtercih, PDO::PARAM_INT);
            $guncelle->bindParam(36, $haritabilgi, PDO::PARAM_STR);

            $guncelle->bindParam(37, $footer, PDO::PARAM_STR);
            if ($guncelle->execute()) {
               
                // Güncelleme Başarılı
                echo '<div class="alert alert-success mt-5" role="alert">Güncelleme Başarılı</div>';
                header("refresh:30;url=control.php?sayfa=siteayar");
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
                                <input type="text" name="slogan_tr" class="form-control" value="<?php echo isset($sonuc['slogan_tr']) ? $sonuc['slogan_tr'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Slogan EN</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="slogan_en" class="form-control" value="<?php echo isset($sonuc['slogan_en']) ? $sonuc['slogan_en'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Referans Üst Başlık TR</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="refsayfaUstbas_tr" class="form-control" value="<?php echo isset($sonuc['referansUstBaslik_tr']) ? $sonuc['referansUstBaslik_tr'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Referans Başlık TR</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="refsayfabas_tr" class="form-control" value="<?php echo isset($sonuc['referansbaslik_tr']) ? $sonuc['referansbaslik_tr'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Referans Üst Başlık EN </span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="refsayfaUstbas_en" class="form-control" value="<?php echo isset($sonuc['referansUstBaslik_en']) ? $sonuc['referansUstBaslik_en'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Referans Başlık EN </span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="refsayfabas_en" class="form-control" value="<?php echo isset($sonuc['referansbaslik_en']) ? $sonuc['referansbaslik_en'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Filo üst Başlık TR </span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="filosayfaUstbas_tr" class="form-control" value="<?php echo isset($sonuc['filoUstBaslik_tr']) ? $sonuc['filoUstBaslik_tr'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Filo Başlık TR </span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="filosayfabas_tr" class="form-control" value="<?php echo isset($sonuc['filobaslik_tr']) ? $sonuc['filobaslik_tr'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Filo üst Başlık EN</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="filosayfaUstbas_en" class="form-control" value="<?php echo isset($sonuc['filoUstBaslik_en']) ? $sonuc['filoUstBaslik_en'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Filo Başlık EN</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="filosayfabas_en" class="form-control" value="<?php echo isset($sonuc['filobaslik_en']) ? $sonuc['filobaslik_en'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Yorum üst Başlık TR</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="yorumsayfaUstbas_tr" class="form-control" value="<?php echo isset($sonuc['yorumUstBaslik_tr']) ? $sonuc['yorumUstBaslik_tr'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Yorum Başlık TR</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="yorumsayfabas_tr" class="form-control" value="<?php echo isset($sonuc['yorumbaslik_tr']) ? $sonuc['yorumbaslik_tr'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            
                        <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Yorum üst Başlık EN</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="yorumsayfaUstbas_en" class="form-control" value="<?php echo isset($sonuc['yorumUstBaslik_en']) ? $sonuc['yorumUstBaslik_en'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            
                        <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Yorum Başlık EN</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="yorumsayfabas_en" class="form-control" value="<?php echo isset($sonuc['yorumbaslik_en']) ? $sonuc['yorumbaslik_en'] : ''; ?>" />
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
                                <input type="text" name="iletisimsayfabas_tr" class="form-control" value="<?php echo isset($sonuc['iletisimbaslik_tr']) ? $sonuc['iletisimbaslik_tr'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->


                    <div class="col-lg-7 mx-auto mt-2 border">
                        
                    <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Hizmetler üst Başlık TR</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="hizmetlersayfaUstbas_tr" class="form-control" value="<?php echo isset($sonuc['hizmetlerUstBaslik_tr']) ? $sonuc['hizmetlerUstBaslik_tr'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                     <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        
                    <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Hizmetler Başlık TR</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="hizmetlersayfabas_tr" class="form-control" value="<?php echo isset($sonuc['hizmetlerbaslik_tr']) ? $sonuc['hizmetlerbaslik_tr'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                     <!--***********************-->
                     <div class="col-lg-7 mx-auto mt-2 border">
                        
                        <div class="row">
                                <div class="col-lg-3 border-right pt-3 text-left">
                                    <span id="siteayarfont">Hizmetler üst Başlık EN</span>
                                </div>
                                <div class="col-lg-9 p-1">
                                    <input type="text" name="hizmetlersayfaUstbas_en" class="form-control" value="<?php echo isset($sonuc['hizmetlerUstBaslik_en']) ? $sonuc['hizmetlerUstBaslik_en'] : ''; ?>" />
                                </div>
                            </div>
                        </div>
                         <!--***********************-->
                     <div class="col-lg-7 mx-auto mt-2 border">
                        
                    <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Hizmetler Başlık EN</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="hizmetlersayfabas_en" class="form-control" value="<?php echo isset($sonuc['hizmetlerbaslik_en']) ? $sonuc['hizmetlerbaslik_en'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                     <!--***********************-->
                     <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Harita Bilgisi</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="haritabilgi" class="form-control" value="<?php echo isset($sonuc['haritabilgi']) ? $sonuc['haritabilgi'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                      <!--***********************-->
                      <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Footer Bilgisi</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <input type="text" name="footer" class="form-control" value="<?php echo isset($sonuc['footer']) ? $sonuc['footer'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--***********************-->
                    <div class="col-lg-7 mx-auto mt-2 border">
                        <div class="row">
                            <div class="col-lg-3 border-right pt-3 text-left">
                                <span id="siteayarfont">Mesaj Tercih</span>
                            </div>
                            <div class="col-lg-9 p-1">
                                <div class="row">
                                    <div class="col-lg-4">
                                    Sadece Mail
                                    <input type="radio" name="mesajtercih" value="1" class="mt-2" <?php echo ($sonuc["mesajtercih"]==1) ? "checked='checked'":"" ?> />
                                    </div>
                                    <div class="col-lg-4">
                                    Hem Mail Hem Mesaj
                                <input type="radio" name="mesajtercih" value="2" class="mt-2" <?php echo ($sonuc["mesajtercih"]==2) ? "checked='checked'":"" ?>/>
                                    </div>
                                    <div class="col-lg-4">
                                    Sadece Mesaj
                                <input type="radio" name="mesajtercih" value="3" class="mt-2" <?php echo ($sonuc["mesajtercih"]==3) ? "checked='checked'":"" ?>/>
                                    </div>
                                    
                            </div>
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
            endwhile;
            endwhile;
            </div>';
        }
        echo '</div>';
    }
    



function introresimekleme($vt) {
    echo '<div class="row text-center">';

    if ($_POST):
        if ($_FILES["dosya"]["name"] == ""):
            echo '<div class="alert alert-danger mt-1" role="alert">Dosya seçilmedi, boş olamaz.</div>';
            header("refresh:2;url=control.php?sayfa=introresimekle");
            exit;

        else:
            if ($_FILES["dosya"]["size"] > (1024 * 1024 * 5)):
                echo '<div class="alert alert-danger mt-1" role="alert">Dosya boyutu 5 MB dan büyük olamaz.</div>';
                header("refresh:2;url=control.php?sayfa=introresimekle");

            else:
                $izinverilen = array("image/jpeg", "image/png");
                if (!in_array($_FILES["dosya"]["type"], $izinverilen)):
                    echo '<div class="alert alert-danger mt-1" role="alert">İzin verilen dosya formatı değil.</div>';
                    header("refresh:2;url=control.php?sayfa=introresimekle");

                else:
                    // Yeni dosya ismi oluşturma
                    $uzanti = explode(".", $_FILES["dosya"]["name"]);
                    $randdeger = md5(mt_rand(0, 1000000));
                    $yeniresimismi = $randdeger . "." . end($uzanti);

                    // Dosya yolu
                    $dosyaminyolu = '../../img/carousel/' . $yeniresimismi;

                    // Dosyayı yükleme
                    if (move_uploaded_file($_FILES["dosya"]["tmp_name"], $dosyaminyolu)):
                        echo '<div class="alert alert-success mt-1" role="alert">Dosya başarıyla yüklendi</div>';
                        header("refresh:2;url=control.php?sayfa=introayar");

                        // İlk 6 karakteri silmek için substr kullanıyoruz
                        $veritabaniYolu = substr($dosyaminyolu, 6);

                        // Dosya yüklendikten sonra veritabanına bu kaydı ekliyoruz
                        $kayitekle = self::sorgum($vt, "INSERT INTO intro(resimyol) VALUES('$veritabaniYolu')", 0);
                    else:
                        echo '<div class="alert alert-danger mt-1" role="alert">Dosya yüklenirken bir hata oluştu.</div>';
                        header("refresh:2;url=control.php?sayfa=introresimekle");
                    endif;

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
                    // Yeni dosya ismi oluşturma
                    $uzanti = explode(".", $_FILES["dosya"]["name"]);
                    $randdeger = md5(mt_rand(0, 1000000));
                    $yeniresimismi = $randdeger . "." . end($uzanti);

                    // Dosya yolu
                    $dosyaminyolu = '../../img/filo/' . $yeniresimismi;

                    // Dosyayı yükleme
                    if (move_uploaded_file($_FILES["dosya"]["tmp_name"], $dosyaminyolu)):
                        echo '<div class="alert alert-success mt-1" role="alert">Dosya başarıyla yüklendi</div>';
                        header("refresh:2;url=control.php?sayfa=aracfilo");

                        // İlk 6 karakteri silmek için substr kullanıyoruz
                        $veritabaniYolu = substr($dosyaminyolu, 6);

                        // Veritabanına kaydet
                        self::sorgum($vt, "INSERT INTO filomuz(resimyol) VALUES('$veritabaniYolu')", 0);
                    else:
                        echo '<div class="alert alert-danger mt-1" role="alert">Dosya yüklenirken bir hata oluştu.</div>';
                        header("refresh:2;url=control.php?sayfa=aracfiloekle");
                    endif;

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




    



//Gelen Mesaj Ayarları

private function mailgetir($vt,$veriler) {
    $sor=$vt->prepare("SELECT * FROM $veriler[0] WHERE durum=$veriler[1]");
    $sor->execute();
    return $sor;
   
}
function gelenmesajlar($vt){
    echo '<div class="row text-center">
        <div class="col-lg-12 mt-2 ">
            <div class="card">
              <div class="card-body">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                

                    <a class="nav-link active" id="gelen-tab" data-toggle="tab" href="#gelen" role="tab" aria-controls="gelen" aria-selected="true"><kbd>'.self::mailgetir($vt, array("gelenmail",0))->rowCount(). '</kbd>Gelen Mesajlar</a>
                    <a class="nav-link" id="okunmus-tab" data-toggle="tab" href="#okunmus" role="tab" aria-controls="okunmus" aria-selected="false"><kbd>'.self::mailgetir($vt, array("gelenmail",1))->rowCount(). '</kbd>Okunmuş Mesajlar</a>
                    <a class="nav-link" id="arsiv-tab" data-toggle="tab" href="#arsiv" role="tab" aria-controls="arsiv" aria-selected="false"><kbd>'.self::mailgetir($vt, array("gelenmail",2))->rowCount(). '</kbd>Arşivlenmiş Mesajlar</a>
                </li>
                </ul>

                <div class="tab-content" id="benimTab">
                    <div class="tab-pane fade show active" id="gelen" role="tabpanel" aria-labelledby="gelen-tab">';
                    
                    
                    
                    
                    $sonuc=self::mailgetir($vt, array("gelenmail",0));
                    if($sonuc->rowCount() !=0):

                    while($sonucson=$sonuc->fetch(PDO::FETCH_ASSOC)):
                    
                    echo '<div class="row">
    <div class="col-lg-12 bg-light mt-2 font-weight-bold" style="border-radius: 5px; border: 1px solid #eeeeee;">
        <div class="row border-bottom align-items-center"> <!-- align-items-center ile dikey hizalama sağlanır -->
            <div class="col-lg-1 p-1">Ad & Unvan</div>
            <div class="col-lg-2 p-1 text-primary">'.$sonucson["ad"].'</div>
            <div class="col-lg-1 p-1">Mail Adres</div>
            <div class="col-lg-2 p-1 text-primary">'.$sonucson["mailadres"].'</div>
            <div class="col-lg-1 p-1">Konu</div>
            <div class="col-lg-2 p-1 text-primary">'.$sonucson["konu"].'</div>
            <div class="col-lg-1 p-1">Tarih</div>
            <div class="col-lg-1 p-1 text-primary">'.$sonucson["zaman"].'</div>
            <div class="col-lg-1 p-1 text-center"> <!-- İkon için sütun -->
                <a href="control.php?sayfa=mesajoku&id='.$sonucson["id"].'"><i class="fa fa-folder-open text-dark" style="font-size: 20px;"></i></a>
                <a href="control.php?sayfa=mesajarsivle&id='.$sonucson["id"].'"><i class="fa fa-share text-dark" style="font-size: 20px;"></i></a>
                <a href="control.php?sayfa=mesajsil&id='.$sonucson["id"].'"><i class="fa fa-close text-dark" style="font-size: 20px;"></i></a>
            </div>
        </div>
    </div>
</div>';
                    
                    endwhile;

                    else:
                        echo '<div class="alert alert-info mt-5" role="alert">Gelen mesaj yok!</div>';
                    endif;
                    
                    echo '
                    </div>
                    <div class="tab-pane fade" id="okunmus" role="tabpanel" aria-labelledby="okunmus-tab">
                    ';
                    
                    
                    
                    
                    
                    $sonuc = self::mailgetir($vt, array("gelenmail", 1)); // Okunmuş mesajlar
if ($sonuc->rowCount() != 0):

    while($sonucson=$sonuc->fetch(PDO::FETCH_ASSOC)):
                
        echo '<div class="row">
<div class="col-lg-12 bg-light mt-2 font-weight-bold" style="border-radius: 5px; border: 1px solid #eeeeee;">
<div class="row border-bottom align-items-center"> <!-- align-items-center ile dikey hizalama sağlanır -->
<div class="col-lg-1 p-1">Ad & Unvan</div>
<div class="col-lg-2 p-1 text-primary">'.$sonucson["ad"].'</div>
<div class="col-lg-1 p-1">Mail Adres</div>
<div class="col-lg-2 p-1 text-primary">'.$sonucson["mailadres"].'</div>
<div class="col-lg-1 p-1">Konu</div>
<div class="col-lg-2 p-1 text-primary">'.$sonucson["konu"].'</div>
<div class="col-lg-1 p-1">Tarih</div>
<div class="col-lg-1 p-1 text-primary">'.$sonucson["zaman"].'</div>
<div class="col-lg-1 p-1 text-center"> <!-- İkon için sütun -->
    <a href="control.php?sayfa=mesajoku&id='.$sonucson["id"].'"><i class="fa fa-folder-open text-dark" style="font-size: 20px;"></i></a>
    <a href="control.php?sayfa=mesajarsivle&id='.$sonucson["id"].'"><i class="fa fa-share text-dark" style="font-size: 20px;"></i></a>
    <a href="control.php?sayfa=mesajsil&id='.$sonucson["id"].'"><i class="fa fa-close text-dark" style="font-size: 20px;"></i></a>
</div>
</div>
</div>

</div>';
                
endwhile;

else:
    echo '<div class="alert alert-info mt-5" role="alert">Okunmuş mesaj yok!</div>';
endif;


echo '</div>
<div class="tab-pane fade" id="arsiv" role="tabpanel" aria-labelledby="arsiv-tab">
';




$sonuc=self::mailgetir($vt, array("gelenmail",2));
if($sonuc->rowCount() !=0):

while($sonucson=$sonuc->fetch(PDO::FETCH_ASSOC)):

echo '<div class="row">
<div class="col-lg-12 bg-light mt-2 font-weight-bold" style="border-radius: 5px; border: 1px solid #eeeeee;">
<div class="row border-bottom align-items-center"> <!-- align-items-center ile dikey hizalama sağlanır -->
<div class="col-lg-1 p-1">Ad & Unvan</div>
<div class="col-lg-2 p-1 text-primary">'.$sonucson["ad"].'</div>
<div class="col-lg-1 p-1">Mail Adres</div>
<div class="col-lg-2 p-1 text-primary">'.$sonucson["mailadres"].'</div>
<div class="col-lg-1 p-1">Konu</div>
<div class="col-lg-2 p-1 text-primary">'.$sonucson["konu"].'</div>
<div class="col-lg-1 p-1">Tarih</div>
<div class="col-lg-1 p-1 text-primary">'.$sonucson["zaman"].'</div>
<div class="col-lg-1 p-1 text-center"> <!-- İkon için sütun -->
<a href="control.php?sayfa=mesajoku&id='.$sonucson["id"].'"><i class="fa fa-folder-open text-dark" style="font-size: 20px;"></i></a>
<a href="control.php?sayfa=mesajarsivle&id='.$sonucson["id"].'"><i class="fa fa-share text-dark" style="font-size: 20px;"></i></a>
<a href="control.php?sayfa=mesajsil&id='.$sonucson["id"].'"><i class="fa fa-close text-dark" style="font-size: 20px;"></i></a>
</div>
</div>
</div>
</div>';
endwhile;

else:
    echo '<div class="alert alert-info mt-5" role="alert">Arşivlenmiş mesaj yok!</div>';
endif;



echo '</div>

</div>
</div>
</div>
</div> 
</div>';

}



function mesajdetay($vt, $id) {
    // Gelen mesajın detaylarını sorguluyoruz
    $mesajbilgi = self::sorgum($vt, "SELECT * FROM gelenmail WHERE id=$id", 1);

    // Eğer mesaj bulunamazsa hata mesajı gösteriyoruz
    if (!$mesajbilgi) {
        echo '<div class="alert alert-danger mt-3 text-center">Mesaj bulunamadı!</div>';
        return;
    }

    echo '<div class="row text-center">
        <div class="col-lg-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="gelen-tab" data-toggle="tab" href="#gelen" role="tab" aria-controls="gelen" aria-selected="true">
                                <kbd>' . self::mailgetir($vt, array("gelenmail", 0))->rowCount() . '</kbd> Gelen Mesajlar
                            </a>
                            <a class="nav-link" id="okunmus-tab" data-toggle="tab" href="#okunmus" role="tab" aria-controls="okunmus" aria-selected="false">
                                <kbd>' . self::mailgetir($vt, array("gelenmail", 1))->rowCount() . '</kbd> Okunmuş Mesajlar
                            </a>
                            <a class="nav-link" id="arsiv-tab" data-toggle="tab" href="#arsiv" role="tab" aria-controls="arsiv" aria-selected="false">
                                <kbd>' . self::mailgetir($vt, array("gelenmail", 2))->rowCount() . '</kbd> Arşivlenmiş Mesajlar
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="benimTab">
                        <div class="tab-pane fade show active" id="gelen" role="tabpanel" aria-labelledby="gelen-tab">
                            <div class="row" m-2>
                                <div class="col-lg-12 bg-light mt-2 font-weight-bold" style="border-radius: 5px; border: 1px solid #eeeeee;">
                                    <div class="row border-bottom align-items-center">
                                        <div class="col-lg-2 p-1">Ad & Unvan</div>
                                        <div class="col-lg-10 p-1 text-primary">' . htmlspecialchars($mesajbilgi["ad"], ENT_QUOTES, 'UTF-8') . '</div>
                                    </div>
                                    <div class="row border-bottom align-items-center">
                                        <div class="col-lg-2 p-1">Mail Adres</div>
                                        <div class="col-lg-10 p-1 text-primary">' . htmlspecialchars($mesajbilgi["mailadres"], ENT_QUOTES, 'UTF-8') . '</div>
                                   
                                    </div>
                                    <div class="row border-bottom align-items-center">
                                        <div class="col-lg-2 p-1">Konu</div>
                                        <div class="col-lg-10 p-1 text-primary">' . htmlspecialchars($mesajbilgi["konu"], ENT_QUOTES, 'UTF-8') . '</div>
                                    </div>
                                    <div class="row border-bottom align-items-center">
                                        <div class="col-lg-2 p-1">Mesaj</div>
                                        <div class="col-lg-10 p-1 text-primary">' . nl2br(htmlspecialchars($mesajbilgi["mesaj"], ENT_QUOTES, 'UTF-8')) . '</div>
                                    </div>
                                    <div class="row border-bottom align-items-center">
                                        <div class="col-lg-2 p-1">Tarih</div>
                                        <div class="col-lg-10 p-1 text-primary">' . htmlspecialchars($mesajbilgi["zaman"], ENT_QUOTES, 'UTF-8') . '</div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-lg-12 text-center mt-3">
                                            <a href="control.php?sayfa=mesajarsivle&id=' . $mesajbilgi["id"] . '" class="btn btn-sm btn-warning">Arşivle</a>
                                            <a href="control.php?sayfa=mesajsil&id=' . $mesajbilgi["id"] . '" class="btn btn-sm btn-danger">Sil</a>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                          '.$mesajbilgi["mesaj"].'
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   
        </div>';
        self::sorgum($vt, "UPDATE gelenmail SET durum=1 WHERE id=$id", 0);
}

function mesajarsivle($vt, $id) {

    echo'<div class="row text-center">
        <div class="col-lg-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-success mt-1" role="alert">Mesaj arşivlendi</div>
                </div>
            </div>
        </div>
    </div>';
    header("refresh:2,url=control.php?sayfa=gelenmesajlar");
    // Gelen mesajı arşivleme işlemi
    self::sorgum($vt, "UPDATE gelenmail SET durum=2 WHERE id=$id", 0);
}

function mesajsil($vt, $id) {

    echo'<div class="row text-center">
        <div class="col-lg-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-success mt-1" role="alert">Mesaj silindi</div>
                </div>
            </div>
        </div>
    </div>';
    header("refresh:2,url=control.php?sayfa=gelenmesajlar");
    // Gelen mesajı arşivleme işlemi
    self::sorgum($vt, "DELETE FROM gelenmail WHERE id=$id", 0);
}

//Video Ayarları

function videolar($vt) {
    echo '<div class="row text-center">
        <div class="col-lg-12 border-bottom">
            <h3 class="float-left mt-3 text-info">Video Yönetimi</h3>
        </div>
         <a href="control.php?sayfa=videoekle" class="btn btn-success m-2">Video Ekle</a>
         <div class="col-lg-12 border-bottom">
            <a href="control.php?sayfa=videolar&tercih=1"><h5 class="ti-check bg-success float-right p-1  text-info mr-2 mt-3"></h5></a>
            <a href="control.php?sayfa=videolar&tercih=0"><h5 class="ti-close bg-danger float-right p-1 text-info mr-2 mt-3"></h5></a>
        </div>

    </div>';

    echo '<div class="row">'; // Videoları bir satırda düzenlemek için row sınıfı ekleniyor

    if((@$_GET["tercih"]!="")){
        
        $videobilgi = self::sorgum($vt, "SELECT * FROM videolar WHERE durum=" . intval($_GET["tercih"]), 2);
    }
    else{
        $videobilgi = self::sorgum($vt, "SELECT * FROM videolar", 2);
    }

   
    // Videoları veritabanından alıyoruz
    

    if ($videobilgi && is_array($videobilgi)) {
        foreach ($videobilgi as $sonbilgi) {
            echo '<div class="col-lg-3 col-md-4 col-6 ">
                <div class="card mb-3 ">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/' . htmlspecialchars($sonbilgi["link"], ENT_QUOTES, 'UTF-8') . '" allowfullscreen></iframe>
                    </div>
                    <div class="card-body text-center">
                        <a href="control.php?sayfa=videoguncelle&id=' . intval($sonbilgi["id"]) . '" class="btn btn-sm btn-success m-1">Güncelle</a>
                        <a href="control.php?sayfa=videosil&id=' . intval($sonbilgi["id"]) . '" class="btn btn-sm btn-danger m-1">Sil</a>
                   
                        <br/>
                        Sırası : '.$sonbilgi["id"].'<br/>
                        Aktiflik Durumu : '.$sonbilgi["durum"].'<br/>
                        </div>
                </div>
            </div>';
        }
    } else {
        echo '<div class="col-lg-12">
            <div class="alert alert-warning mt-3" role="alert">Hiçbir video bulunamadı!</div>
        </div>';
    }

    echo '</div>'; // row sınıfını kapatıyoruz
}

function videoekleme($vt) {
    echo '<div class="row text-center">';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Form gönderildiğinde yapılacak işlemler
        $videoyol = htmlspecialchars(strip_tags($_POST["videoyol"]), ENT_QUOTES, 'UTF-8');
        $siralama = htmlspecialchars(strip_tags($_POST["siralama"]), ENT_QUOTES, 'UTF-8');
        $durum = htmlspecialchars(strip_tags($_POST["durum"]), ENT_QUOTES, 'UTF-8');

        
        if (empty($videoyol) || empty($siralama)) {
            echo '<div class="alert alert-danger mt-1" role="alert">Video yolu ve sırası boş olamaz.</div>';
            header("refresh:2;url=control.php?sayfa=videolar");
        } else {
            // Veritabanına kaydet
            self::sorgum($vt, "INSERT INTO videolar(link, siralama, durum) VALUES('$videoyol', '$siralama', '$durum')", 0);
            echo '<div class="alert alert-success mt-1" role="alert">Video başarıyla eklendi</div>';
            header("refresh:2;url=control.php?sayfa=videolar");
        }
    } else {
        // Formun ilk kez görüntülenmesi
        echo '
        <div class="col-lg-4 mx-auto mt-2">
            <div class="card card-bordered">
                <div class="card-body">
                    <h5 class="title border-bottom">Video Ekleme Formu</h5>
                    <form action="" method="post">
                        <p class="card-text"><input type="text" name="videoyol" class="form-control" placeholder="Video Yolu" required /></p>
                        <p class="card-text"><input type="text" name="siralama" class="form-control" placeholder="Video Sırası" required /></p>
                        <p class="card-text">
                            <select name="durum" class="form-control">
                                <option value="1">Aktif</option>
                                <option value="0">Pasif</option>
                            </select>
                        </p>
                        <input type="submit" name="buton" class="btn btn-primary mb-1" value="Ekle" />
                    </form>
                </div>
            </div>
        </div>';
    }

    echo '</div>';
}


    
function videosil($vt) {
    $introid = $_GET["id"];
    

    echo '<div class="row text center">
    <div class="col-lg-12">';

  

    // Veritabanından kaydı sil
    self::sorgum($vt, "DELETE FROM videolar WHERE id=$introid", 0);

    echo '<div class="alert alert-success mt-1" role="alert">Video başarıyla silindi</div>';
    echo '</div></div>';
    header("refresh:2,url=control.php?sayfa=videolar");
}




function videoguncelleme($vt) {
    // Gelen ID'yi güvenli bir şekilde alıyoruz
    $gelenintroid = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

    // Veritabanından video bilgilerini alıyoruz
    $sonbilgi = self::sorgum($vt, "SELECT * FROM videolar WHERE id = $gelenintroid", 1);
    if (!$sonbilgi) {
        echo '<div class="alert alert-danger mt-3 text-center">Video bulunamadı!</div>';
        return;
    }

    // Tüm videoları sıralama bilgisiyle alıyoruz
    $tumvideolar = self::sorgum($vt, "SELECT * FROM videolar", 2);

    echo '<div class="row text-center">';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Form gönderildiğinde yapılacak işlemler
        $videoyol = isset($_POST["videoyol"]) ? htmlspecialchars(strip_tags($_POST["videoyol"]), ENT_QUOTES, 'UTF-8') : '';
        $siralama = isset($_POST["siralama"]) ? intval($_POST["siralama"]) : 0;
        $mevcutsira = isset($_POST["mevcutsira"]) ? intval($_POST["mevcutsira"]) : 0;
        $durum = isset($_POST["durum"]) ? intval($_POST["durum"]) : 0;

        if (empty($videoyol) || empty($siralama)) {
            echo '<div class="alert alert-danger mt-1" role="alert">Video yolu ve sırası boş olamaz.</div>';
        } else {
            // Veritabanını güncelleme işlemi
            self::sorgum($vt, "UPDATE videolar SET siralama = $mevcutsira WHERE siralama = $siralama", 0);
            self::sorgum($vt, "UPDATE videolar SET link = '$videoyol', siralama = $siralama, durum = $durum WHERE id = $gelenintroid", 0);

            echo '<div class="alert alert-success mt-1" role="alert">Video başarıyla güncellendi.</div>';
            header("refresh:2;url=control.php?sayfa=videolar");
            exit;
        }
    } else {
        // Formun ilk kez görüntülenmesi
        echo '
        <div class="col-lg-4 mx-auto mt-2">
            <div class="card card-bordered">
                <div class="card-body">
                    <h5 class="title border-bottom">Video Güncelleme Formu</h5>
                    <form action="" method="post">
                        <p class="card-text text-danger">Video Linki
                            <input type="text" name="videoyol" class="form-control" value="' . htmlspecialchars($sonbilgi["link"], ENT_QUOTES, 'UTF-8') . '" required />
                        </p>
                        <p class="card-text text-danger">Video Sırası
                            <select name="siralama" class="form-control">';
        
        // Sıralama seçeneklerini ekliyoruz, mevcut sıralama hariç
        if ($tumvideolar && is_array($tumvideolar)) {
            foreach ($tumvideolar as $tumvideolarSon) {
                if ($tumvideolarSon["siralama"] != $sonbilgi["siralama"]) {
                    echo '<option value="' . intval($tumvideolarSon["siralama"]) . '">' . intval($tumvideolarSon["siralama"]) . '</option>';
                }
            }
        }

        echo '          </select>
                        </p>
                        <p class="card-text text-danger">Video Durumu
                            <select name="durum" class="form-control">
                                <option value="1" ' . ($sonbilgi["durum"] == 1 ? 'selected' : '') . '>Aktif</option>
                                <option value="0" ' . ($sonbilgi["durum"] == 0 ? 'selected' : '') . '>Pasif</option>
                            </select>
                        </p>
                        <input type="hidden" name="mevcutsira" value="' . intval($sonbilgi["siralama"]) . '" />
                        <input type="submit" name="buton" class="btn btn-primary mb-1" value="GÜNCELLE" />
                    </form>
                </div>
            </div>
        </div>';
    }

    echo '</div>';
}



}