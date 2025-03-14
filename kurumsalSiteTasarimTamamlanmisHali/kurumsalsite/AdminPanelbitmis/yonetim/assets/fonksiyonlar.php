<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();

try {
    $baglanti = new PDO("mysql:host=localhost;dbname=kurumsal;charset=utf8", "root", "sdsd3490");
    $baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print $e->getMessage();
}


class yonetim {

    function sorgum($vt, $sorgu, $tercih = 0) {
        $al = $vt->prepare($sorgu);
        $al->execute();

        if ($tercih == 1) :
            return $al->fetch();
        elseif ($tercih == 2) :
            return $al->fetch(PDO::FETCH_ASSOC);
        endif;

        $sonuc = $al->fetch();
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
                echo '<div class="alert alert-success" role="alert">Güncelleme Başarılı</div>';
                header("refresh:2;url=index.php");
                exit;
            } else {
                echo '<div class="alert alert-danger" role="alert">Güncelleme Başarısız</div>';
            }

        else :
?>

            <form action="index.php?sayfa=siteayar" method="post">
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

}

?>