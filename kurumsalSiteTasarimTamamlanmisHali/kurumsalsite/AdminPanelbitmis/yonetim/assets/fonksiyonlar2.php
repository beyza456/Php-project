<?php
include_once("assets/fonksiyonlar.php"); // yonetim sınıfının tanımlandığı dosyanın yolunu ekleyin

class yonetim2 extends yonetim{

    protected $tercihArray =array("Açık","Kapalı");
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
                    // Yeni dosya ismi oluşturma
                    $uzanti = explode(".", $_FILES["dosya"]["name"]);
                    $randdeger = md5(mt_rand(0, 1000000));
                    $yeniresimismi = $randdeger . "." . end($uzanti);

                    // Dosya yolu
                    $dosyaminyolu = '../../img/referans/' . $yeniresimismi;

                    // Dosyayı yükleme
                    if (move_uploaded_file($_FILES["dosya"]["tmp_name"], $dosyaminyolu)):
                        echo '<div class="alert alert-success mt-1" role="alert">Dosya başarıyla yüklendi</div>';
                        header("refresh:2;url=control.php?sayfa=ref");

                        // İlk 6 karakteri silmek için substr kullanıyoruz
                        $veritabaniYolu = substr($dosyaminyolu, 6);

                        // Veritabanına kaydet
                        self::sorgum($vt, "INSERT INTO referanslar(resimyol) VALUES('$veritabaniYolu')", 0);
                    else:
                        echo '<div class="alert alert-danger mt-1" role="alert">Dosya yüklenirken bir hata oluştu.</div>';
                        header("refresh:2;url=control.php?sayfa=ref");
                    endif;

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
//Mail Ayarları



function mailayar($baglanti) {
    $sonuc = $this->sorgum($baglanti, "SELECT * FROM gelenmailayar", 1);

    if ($_POST) :
        // burada veri tabanı işlemleri yapılacak

        $host = htmlspecialchars($_POST["host"]);
        $mailadres = htmlspecialchars($_POST["mailadres"]);
        $sifre = htmlspecialchars($_POST["sifre"]);
        $port = htmlspecialchars($_POST["port"]);
        $alicimail = htmlspecialchars($_POST["alicimail"]);


        // burada bunların boş veya dolu olup olmadığı kontrol edilecek

        $guncelle = $baglanti->prepare("UPDATE gelenmailayar SET host=?, mailadres=?, sifre=?, port=?, aliciadres=? ");

        $guncelle->bindParam(1, $host, PDO::PARAM_STR);
        $guncelle->bindParam(2, $mailadres, PDO::PARAM_STR);
        $guncelle->bindParam(3, $sifre, PDO::PARAM_STR);
        $guncelle->bindParam(4,  $port, PDO::PARAM_STR);
        $guncelle->bindParam(5,  $alicimail, PDO::PARAM_STR);
       

        if ($guncelle->execute()) {
            // Güncelleme Başarılı
            echo '<div class="alert alert-success mt-5" >Güncelleme Başarılı</div>';
            header("refresh:2;url=control.php?sayfa=mailayar");
            exit;
        } else {
            echo '<div class="alert alert-danger" role="alert">Güncelleme Başarısız</div>';
        }

    else :
?>



        <form action="control.php?sayfa=mailayar" method="post">
            <div class="row text-center">
                <div class="col-lg-7 mx-auto mt-2 ">
                    <h3 class="text-info">Mail Ayarları </h3>
                </div>
                <div class="col-lg-7 mx-auto mt-2 border">
                    <div class="row">
                        <div class="col-lg-3 border-right pt-3 text-left">
                            <span id="siteayarfont">Host</span>
                        </div>
                        <div class="col-lg-9 p-1">
                            <input type="text" name="host" class="form-control" value="<?php echo isset($sonuc['host']) ? $sonuc['host'] : ''; ?>" />
                        </div>
                    </div>
                </div>
                <!--***********************-->
                <div class="col-lg-7 mx-auto mt-2 border">
                    <div class="row">
                        <div class="col-lg-3 border-right pt-3 text-left">
                            <span id="siteayarfont">Mail Adres</span>
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
                            <span id="siteayarfont">Host Şifre</span>
                        </div>
                        <div class="col-lg-9 p-1">
                            <input type="text" name="sifre" class="form-control" value="<?php echo isset($sonuc['sifre']) ? $sonuc['sifre'] : ''; ?>" />
                        </div>
                    </div>
                </div>
                <!--***********************-->
                <div class="col-lg-7 mx-auto mt-2 border">
                    <div class="row">
                        <div class="col-lg-3 border-right pt-3 text-left">
                            <span id="siteayarfont">Port</span>
                        </div>
                        <div class="col-lg-9 p-1">
                            <input type="text" name="port" class="form-control" value="<?php echo isset($sonuc['port']) ? $sonuc['port'] : ''; ?>" />
                        </div>
                    </div>
                </div>
                <!--***********************-->
                <div class="col-lg-7 mx-auto mt-2 border">
                    <div class="row">
                        <div class="col-lg-3 border-right pt-3 text-left">
                            <span id="siteayarfont">Alıcı Mail</span>
                        </div>
                        <div class="col-lg-9 p-1">
                            <input type="text" name="alicimail" class="form-control" value="<?php echo isset($sonuc['aliciadres']) ? $sonuc['aliciadres'] : ''; ?>" />
                        </div>
                    </div>
                </div>
                <!--***********************-->
            
                <div class="col-lg-7 mx-auto mt-2 ">
                    <input type="submit" name="buton" class="btn btn rounded btn-info m-1" value="GÜNCELLE" />
                </div>
            </div>
        </form>
<?php
    
endif;
}

//Kullanıcı Ayarları






function ayarlar($baglanti) {
    // Kullanıcı ID'sini çerezden çözüyoruz
    $id = self::coz($_COOKIE["kulbilgi"]);
    $sonuc = self::sorgum($baglanti, "SELECT * FROM yonetim WHERE id=$id", 1);

    // Kullanıcı bulunamazsa hata mesajı gösteriyoruz
    if (!$sonuc) {
        echo '<div class="alert alert-danger mt-5">Kullanıcı bulunamadı!</div>';
        return;
    }

    if ($_POST) :
        // Formdan gelen verileri alıyoruz
        @$kulad = htmlspecialchars($_POST["kulad"]);
        @$eskisif = htmlspecialchars($_POST["sifre"]);
        @$yenisif = htmlspecialchars($_POST["yenisif"]);
        @$yenisif2 = htmlspecialchars($_POST["yenisif2"]);

        // Alanların boş olup olmadığını kontrol ediyoruz
        if ($kulad == "" || $eskisif == "" || $yenisif == "" || $yenisif2 == ""):
            echo '<div class="alert alert-danger mt-5">Hiçbir Alan Boş Geçilemez.</div>';
            header("refresh:2;url=control.php?sayfa=ayarlar");
        else:
            // Eski şifreyi kontrol ediyoruz
            $sifrelihal = md5(sha1(md5($eskisif))); // Şifreyi aynı algoritmayla şifreliyoruz

            if ($sonuc["sifre"] !== $sifrelihal): // Veritabanındaki şifreyle karşılaştırıyoruz
                echo '<div class="alert alert-danger mt-5">Eski Şifre Hatalı</div>';
                header("refresh:2;url=control.php?sayfa=ayarlar");
            else:
                // Yeni şifrelerin eşleşip eşleşmediğini kontrol ediyoruz
                if ($yenisif !== $yenisif2):
                    echo '<div class="alert alert-danger mt-5">Yeni Şifreler Uyuşmuyor</div>';
                    header("refresh:2;url=control.php?sayfa=ayarlar");
                else:
                    // Yeni şifreyi şifreliyoruz
                    $yenisifrelihal = md5(sha1(md5($yenisif)));

                    // Veritabanını güncelliyoruz
                    $guncelle = $baglanti->prepare("UPDATE yonetim SET kulad=?, sifre=? WHERE id=$id");
                    $guncelle->bindParam(1, $kulad, PDO::PARAM_STR);
                    $guncelle->bindParam(2, $yenisifrelihal, PDO::PARAM_STR);

                    if ($guncelle->execute()) {
                        echo '<div class="alert alert-success mt-5">Güncelleme Başarılı</div>';
                        header("refresh:2;url=control.php?sayfa=ayarlar");
                        exit;
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Güncelleme Başarısız</div>';
                    }
                endif;
            endif;
        endif;
    else :
?>
        <form action="control.php?sayfa=ayarlar" method="post">
            <div class="row text-center">
                <div class="col-lg-7 mx-auto mt-2 ">
                    <h3 class="text-info">Kullanıcı Ayarları</h3>
                </div>
                <div class="col-lg-7 mx-auto mt-2 border">
                    <div class="row">
                        <div class="col-lg-3 border-right pt-3 text-left">
                            <span id="siteayarfont">Kullanıcı Adı</span>
                        </div>
                        <div class="col-lg-9 p-1">
                            <input type="text" name="kulad" class="form-control" value="<?php echo isset($sonuc['kulad']) ? $sonuc['kulad'] : ''; ?>" />
                        </div>
                    </div>
                </div>
                <!--***********************-->
                <div class="col-lg-7 mx-auto mt-2 border">
                    <div class="row">
                        <div class="col-lg-3 border-right pt-3 text-left">
                            <span id="siteayarfont">Şifre</span>
                        </div>
                        <div class="col-lg-9 p-1">
                            <input type="password" name="sifre" class="form-control" />
                        </div>
                    </div>
                </div>
                <!--***********************-->
                <div class="col-lg-7 mx-auto mt-2 border">
                    <div class="row">
                        <div class="col-lg-3 border-right pt-3 text-left">
                            <span id="siteayarfont">Yeni Şifre</span>
                        </div>
                        <div class="col-lg-9 p-1">
                            <input type="password" name="yenisif" class="form-control" />
                        </div>
                    </div>
                </div>
                <!--***********************-->
                <div class="col-lg-7 mx-auto mt-2 border">
                    <div class="row">
                        <div class="col-lg-3 border-right pt-3 text-left">
                            <span id="siteayarfont">Yeni Şifre Tekrar</span>
                        </div>
                        <div class="col-lg-9 p-1">
                            <input type="password" name="yenisif2" class="form-control" />
                        </div>
                    </div>
                </div>
                <!--***********************-->
                <div class="col-lg-7 mx-auto mt-2 ">
                    <input type="submit" name="buton" class="btn btn rounded btn-info m-1" value="DEĞİŞTİR" />
                </div>
            </div>
        </form>
<?php
    endif;
}

//Kullanıcı Ekleme ve Silme

function kullistele($vt) {
    $al = self::sorgum($vt, "SELECT * FROM yonetim", 0);
    echo '<div class="row text-center">
          <div class="col-lg-6 mt-5 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title text-dark">
    
                    <a href="control.php?sayfa=yonekle" class="ti-plus bg-dark p-1 text-white mr-2 mt-3"></a>
                    KULLANICILAR
                    </h4>
                    <div class="single-table">
                        <div class="table-responsive">
                        <table class="table text-center">
                        <thead class="text-uppercase">
                            <tr>
                                <th scope="col">Ad</th>
                                <th scope="col">İşlem</th>
                            </tr>
                        </thead>
                        <tbody>';
                        
                        // Veritabanından gelen verileri döngüyle yazdırıyoruz
                        while ($yonson = $al->fetch(PDO::FETCH_ASSOC)):
                            echo '<tr>
                                <th scope="row">' . htmlspecialchars($yonson["kulad"], ENT_QUOTES, 'UTF-8') . '</th>
                                <th scope="row">
                                    <a href="control.php?sayfa=yonsil&id=' . intval($yonson["id"]) . '">
                                        <i class="ti-trash"></i>
                                    </a>
                                </th>
                            </tr>';
                        endwhile;

                        echo '</tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
         
            </div>
        
          </div>';
}

function yonsil($vt, $id) {

    echo'<div class="row text-center">
        <div class="col-lg-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-success mt-1" role="alert">Yönetici silindi</div>
                </div>
            </div>
        </div>
    </div>';
    header("refresh:2,url=control.php?sayfa=kulayar");
    // Gelen mesajı arşivleme işlemi
    self::sorgum($vt, "DELETE FROM yonetim WHERE id=$id", 0);
}


function yonekle($baglanti) {
    

    if ($_POST) :
        // Formdan gelen verileri alıyoruz
        @$kulad = htmlspecialchars($_POST["kulad"]);
        
        @$yenisif = htmlspecialchars($_POST["yenisif"]);
        @$yenisif2 = htmlspecialchars($_POST["yenisif2"]);

        // Alanların boş olup olmadığını kontrol ediyoruz
        if ($kulad == "" ||  $yenisif == "" || $yenisif2 == ""):
            echo '<div class="alert alert-danger mt-5">Hiçbir Alan Boş Geçilemez.</div>';
            header("refresh:2;url=control.php?sayfa=yonekle");
        else:
            // Yeni şifrelerin eşleşip eşleşmediğini kontrol ediyoruz
            if ($yenisif !== $yenisif2):
                echo '<div class="alert alert-danger mt-5">Yeni Şifreler Uyuşmuyor</div>';
                header("refresh:2;url=control.php?sayfa=yonekle");
          
                else:
                    // Yeni şifreyi şifreliyoruz
                    $yenisifrelihal = md5(sha1(md5($yenisif)));

                    // Veritabanını güncelliyoruz
                    $ekle = $baglanti->prepare("INSERT INTO yonetim (kulad, sifre) VALUES (?, ?)");
                    $ekle->bindParam(1, $kulad, PDO::PARAM_STR);
                    $ekle->bindParam(2, $yenisifrelihal, PDO::PARAM_STR);

                    if ($ekle->execute()) {
                        echo '<div class="alert alert-success mt-5">Yönetici Eklendi</div>';
                        header("refresh:2;url=control.php?sayfa=kulayar");
                        exit;
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Yönetici Ekleme Başarısız</div>';
                    }
                endif;
            endif;

    else :
?>
        <form action="control.php?sayfa=yonekle" method="post">
            <div class="row text-center">
                <div class="col-lg-7 mx-auto mt-2 ">
                    <h3 class="text-info">Yönetici Ekle</h3>
                </div>
                <div class="col-lg-7 mx-auto mt-2 border">
                    <div class="row">
                        <div class="col-lg-3 border-right pt-3 text-left">
                            <span id="siteayarfont">Kullanıcı Adı</span>
                        </div>
                        <div class="col-lg-9 p-1">
                            <input type="text" name="kulad" class="form-control"  />
                        </div>
                    </div>
                </div>
                <!--***********************-->
                  <div class="col-lg-7 mx-auto mt-2 border">
                    <div class="row">
                        <div class="col-lg-3 border-right pt-3 text-left">
                            <span id="siteayarfont">Yeni Şifre</span>
                        </div>
                        <div class="col-lg-9 p-1">
                            <input type="password" name="yenisif" class="form-control" />
                        </div>
                    </div>
                </div>
                <!--***********************-->
                <div class="col-lg-7 mx-auto mt-2 border">
                    <div class="row">
                        <div class="col-lg-3 border-right pt-3 text-left">
                            <span id="siteayarfont">Yeni Şifre (Tekrar)</span>
                        </div>
                        <div class="col-lg-9 p-1">
                            <input type="password" name="yenisif2" class="form-control" />
                        </div>
                    </div>
                </div>
                <!--***********************-->
                <div class="col-lg-7 mx-auto mt-2 ">
                    <input type="submit" name="buton" class="btn btn rounded btn-info m-1" value="YÖNETİCİ EKLE" />
                </div>
            </div>
        </form>
<?php
    endif;
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
            echo '<section id="hakkimizda" class="wow fadeInUp">
            <div class="container">
            
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4 d-flex align-items-stretch"> <!-- Her resim için bir sütun -->
                <div class="card h-100 shadow-sm">
                    <img src="../../' . htmlspecialchars($sonbilgi["resim"]) . '" class="card-img-top img-fluid" alt="Hakkımızda Resmi">
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="baslik" class="form-label">Başlık TR</label>
                                <input type="text" name="baslik_tr" class="form-control" value="' . htmlspecialchars($sonbilgi["baslik_tr"]) . '" required>
                            </div>
                            <div class="mb-3">
                                <label for="baslik" class="form-label">Başlık EN</label>
                                <input type="text" name="baslik_en" class="form-control" value="' . htmlspecialchars($sonbilgi["baslik_en"]) . '" required>
                            </div>
                            <div class="mb-3">
                                <label for="icerik" class="form-label">İçerik TR</label>
                                <textarea name="icerik_tr" class="form-control" rows="5" required>' . htmlspecialchars($sonbilgi["icerik_tr"]) . '</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="icerik" class="form-label">İçerik EN</label>
                                <textarea name="icerik_en" class="form-control" rows="5" required>' . htmlspecialchars($sonbilgi["icerik_en"]) . '</textarea>
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
        </div>
        </div>
        </section>';

    }

    echo '</div>'; // row sınıfını kapatıyoruz

    // Form gönderildiğinde güncelleme işlemi
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;
        $baslik_tr = isset($_POST["baslik_tr"]) ? htmlspecialchars($_POST["baslik_tr"], ENT_QUOTES, 'UTF-8') : '';
        $baslik_en = isset($_POST["baslik_en"]) ? htmlspecialchars($_POST["baslik_en"], ENT_QUOTES, 'UTF-8') : '';
        $icerik_tr = isset($_POST["icerik_tr"]) ? htmlspecialchars($_POST["icerik_tr"], ENT_QUOTES, 'UTF-8') : '';
        $icerik_en = isset($_POST["icerik_en"]) ? htmlspecialchars($_POST["icerik_en"], ENT_QUOTES, 'UTF-8') : '';

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

if ($veritabaniYolu) {
    // Resim güncelleniyorsa
    $guncelle = $vt->prepare("UPDATE hakkimizda SET baslik_tr = :baslik_tr, baslik_en = :baslik_en, icerik_tr = :icerik_tr, icerik_en = :icerik_en, resim = :resim WHERE id = :id");
    $guncelle->bindParam(':resim', $veritabaniYolu, PDO::PARAM_STR);
} else {
    // Resim güncellenmiyorsa
    $guncelle = $vt->prepare("UPDATE hakkimizda SET baslik_tr = :baslik_tr, baslik_en = :baslik_en, icerik_tr = :icerik_tr, icerik_en = :icerik_en WHERE id = :id");
}

// Ortak parametreler
$guncelle->bindParam(':baslik_tr', $baslik_tr, PDO::PARAM_STR);
$guncelle->bindParam(':baslik_en', $baslik_en, PDO::PARAM_STR);
$guncelle->bindParam(':icerik_tr', $icerik_tr, PDO::PARAM_STR);
$guncelle->bindParam(':icerik_en', $icerik_en, PDO::PARAM_STR);
$guncelle->bindParam(':id', $id, PDO::PARAM_INT);

// Sorguyu çalıştır
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
                        <h5 class="card-title">' . htmlspecialchars($sonbilgi["baslik_tr"].'-'.$sonbilgi["baslik_en"], ENT_QUOTES, 'UTF-8') . '</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">' . htmlspecialchars($sonbilgi["icerik_tr"], ENT_QUOTES, 'UTF-8') . '</p>

                        <p class="card-text">' . htmlspecialchars($sonbilgi["icerik_en"], ENT_QUOTES, 'UTF-8') . '</p>
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
                        <label for="baslik" class="form-label">TR-Başlık</label>
                        <input type="text" name="baslik_tr" id="baslik" class="form-control" placeholder="Hizmet başlığını girin" required>
                    </div>
                    <div class="mb-3">
                        <label for="baslik" class="form-label">EN-Başlık</label>
                        <input type="text" name="baslik_en" id="baslik" class="form-control"  placeholder="Hizmet başlığını girin" required>
                    </div>
                    <div class="mb-3">
                        <label for="icerik" class="form-label">TR-İçerik</label>
                        <textarea name="icerik_tr" id="icerik" class="form-control" rows="5" placeholder="Hizmet içeriğini girin" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="icerik" class="form-label">EN-İçerik</label>
                        <textarea name="icerik_en" id="icerik" class="form-control" rows="5" placeholder="Hizmet içeriğini girin" required></textarea>
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
        
        $baslik_tr = isset($_POST["baslik_tr"]) ? htmlspecialchars($_POST["baslik_tr"], ENT_QUOTES, 'UTF-8') : '';
        $baslik_en = isset($_POST["baslik_en"]) ? htmlspecialchars($_POST["baslik_en"], ENT_QUOTES, 'UTF-8') : '';
        $icerik_tr = isset($_POST["icerik_tr"]) ? htmlspecialchars($_POST["icerik_tr"], ENT_QUOTES, 'UTF-8') : '';

        $icerik_en = isset($_POST["icerik_en"]) ? htmlspecialchars($_POST["icerik_en"], ENT_QUOTES, 'UTF-8') : '';
        $kayitidsi = isset($_POST["kayitidsi"]) ? htmlspecialchars($_POST["kayitidsi"], ENT_QUOTES, 'UTF-8') : '';

        if (!empty($baslik_tr) && !empty($icerik_tr) && !empty($baslik_en) && !empty($icerik_en)) {
            $ekle = $vt->prepare("INSERT INTO hizmetler (baslik_tr,baslik_en, icerik_tr, icerik_en) VALUES (:baslik_tr,:baslik_en, :icerik_tr, :icerik_en)");
            $ekle->bindParam(':baslik_tr', $baslik_tr, PDO::PARAM_STR);
            $ekle->bindParam(':baslik_en', $baslik_en, PDO::PARAM_STR);
            $ekle->bindParam(':icerik_tr', $icerik_tr, PDO::PARAM_STR);
            $ekle->bindParam(':icerik_en', $icerik_en, PDO::PARAM_STR);

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
                        <label for="baslik" class="form-label">TR-Başlık</label>
                        <input type="text" name="baslik_tr" id="baslik" class="form-control" value="'.$kayitbilgial["baslik_tr"].'" placeholder="Hizmet başlığını girin" required>
                    </div>
                    <div class="mb-3">
                        <label for="baslik" class="form-label">EN-Başlık</label>
                        <input type="text" name="baslik_en" id="baslik" class="form-control" value="'.$kayitbilgial["baslik_en"].'" placeholder="Hizmet başlığını girin" required>
                    </div>
                    <div class="mb-3">
                        <label for="icerik" class="form-label">TR-İçerik</label>
                        <textarea name="icerik_tr" id="icerik" class="form-control" rows="5" placeholder="Hizmet içeriğini girin" required>'.$kayitbilgial["icerik_tr"].'</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="icerik" class="form-label">EN-İçerik</label>
                        <textarea name="icerik_en" id="icerik" class="form-control" rows="5" placeholder="Hizmet içeriğini girin" required>'.$kayitbilgial["icerik_en"].'</textarea>
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
        $baslik_tr = isset($_POST["baslik_tr"]) ? htmlspecialchars($_POST["baslik_tr"], ENT_QUOTES, 'UTF-8') : '';
        $baslik_en = isset($_POST["baslik_en"]) ? htmlspecialchars($_POST["baslik_en"], ENT_QUOTES, 'UTF-8') : '';
        $icerik_tr = isset($_POST["icerik_tr"]) ? htmlspecialchars($_POST["icerik_tr"], ENT_QUOTES, 'UTF-8') : '';

        $icerik_en = isset($_POST["icerik_en"]) ? htmlspecialchars($_POST["icerik_en"], ENT_QUOTES, 'UTF-8') : '';
        $kayitidsi = isset($_POST["kayitidsi"]) ? htmlspecialchars($_POST["kayitidsi"], ENT_QUOTES, 'UTF-8') : '';

        if (!empty($baslik_tr) && !empty($icerik_tr) && !empty($baslik_en) && !empty($icerik_en)) {
            $ekle = $vt->prepare("UPDATE hizmetler SET baslik_tr = :baslik_tr, baslik_en = :baslik_en, icerik_tr = :icerik_tr , icerik_en = :icerik_en WHERE id = :kayitidsi");
            $ekle->bindParam(':kayitidsi', $kayitidsi, PDO::PARAM_INT);
            $ekle->bindParam(':baslik_tr', $baslik_tr, PDO::PARAM_STR);
            $ekle->bindParam(':baslik_en', $baslik_en, PDO::PARAM_STR);
            $ekle->bindParam(':icerik_tr', $icerik_tr, PDO::PARAM_STR);
            $ekle->bindParam(':icerik_en', $icerik_en, PDO::PARAM_STR);

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

//Tasarımı Güncelleme



function tasarimGetir($gelenTercih, $radioName) {
    foreach($this->tercihArray as $key=>$value):
        if($gelenTercih==$key):
            
             echo'<label>'.$value.'<input type="radio" name="'.$radioName.'" value="'.$key.'" checked="checked" ></label>';
                
    
        else:
            echo'<label>'.$value.'<input type="radio" name="'.$radioName.'" value="'.$key.'" ></label>';
                
       
        endif;
    endforeach;
}

//Tasarım Ayarları

function tasarimYonetim($vt) {
    echo '<div class="row text-center">


        <div class="col-lg-12 border-bottom">
            <h3 class="float-left mt-3 text-dark mb-2">TASARIM YÖNETİM</h3>
        
            </div>
    </div>';

    // Veritabanından tasarım bilgilerini alıyoruz
    $kayitbilgial = self::sorgum($vt, "SELECT * FROM tasarim", 1);

    if (!$kayitbilgial) {
        echo '<div class="alert alert-danger mt-3 text-center">Tasarım bilgisi bulunamadı!</div>';
        return;
   
    }

    echo '<div class="row justify-content-center mt-4">'; // Ortalamak için justify-content-center sınıfı ekleniyor

    // Form başlıyor
    echo '<div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white text-center">
                <h5>Hizmet Tercih</h5>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">';
                
                // Hizmet Tercih
                self::tasarimGetir($kayitbilgial["hiztercih"], "hiztercih");

    echo '      </form>
            </div>
            <div class="card-header bg-info text-white text-center">
                <h5>Referans Tercih</h5>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">';
                
                // Hizmet Tercih
                
                self::tasarimGetir($kayitbilgial["reftercih"], "reftercih");

    echo '      </form>
            </div>
            <div class="card-header bg-info text-white text-center">
                <h5>Yorum Tercih</h5>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">';
                
                
                // Hizmet Tercih
                self::tasarimGetir($kayitbilgial["yorumtercih"], "yorumtercih");

    echo '      </form>
            </div>
            <div class="card-header bg-info text-white text-center">
                <h5>Video Tercih</h5>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">';
                
              // Hizmet Tercih
              self::tasarimGetir($kayitbilgial["videotercih"], "vidtercih");  



    echo '      </form>
            </div>
            <div class="card-header bg-info text-white text-center">
                <h5>Bülten Tercih</h5>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">';
                
               // Hizmet Tercih
              self::tasarimGetir($kayitbilgial["bultentercih"], "bultentercih");

    echo '      </form>
            </div>
            <div class="col-lg-12 border-top p-2 text-center">
                <form action="" method="post">
                    <input type="hidden" name="kayitidsi" value="' . htmlspecialchars($kayitbilgial["id"], ENT_QUOTES, 'UTF-8') . '">
                    <input type="submit" name="buton" class="btn btn-primary" value="Tasarım Güncelle">
                </form>
            </div>
        </div>
    </div>';

    echo '</div>'; // row sınıfını kapatıyoruz

    // Form gönderildiğinde veritabanına güncelleme işlemi
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $hiztercih1 = isset($_POST["hiztercih"]) ? htmlspecialchars($_POST["hiztercih"], ENT_QUOTES, 'UTF-8') : '';
        $reftercih1 = isset($_POST["reftercih"]) ? htmlspecialchars($_POST["reftercih"], ENT_QUOTES, 'UTF-8') : '';
        $yorumtercih1 = isset($_POST["yorumtercih"]) ? htmlspecialchars($_POST["yorumtercih"], ENT_QUOTES, 'UTF-8') : '';
        $vidtercih1 = isset($_POST["vidtercih"]) ? htmlspecialchars($_POST["vidtercih"], ENT_QUOTES, 'UTF-8') : '';
        $bultentercih1 = isset($_POST["bultentercih"]) ? htmlspecialchars($_POST["bultentercih"], ENT_QUOTES, 'UTF-8') : '';
        $kayitidsi = isset($_POST["kayitidsi"]) ? htmlspecialchars($_POST["kayitidsi"], ENT_QUOTES, 'UTF-8') : '';

        // PDO ile parametre bağlama işlemi
        $sorgu = $vt->prepare("UPDATE tasarim SET hiztercih = :hiztercih, reftercih = :reftercih, yorumtercih = :yorumtercih, videotercih = :vidtercih, bultentercih = :bultentercih WHERE id = :kayitidsi");
        $sorgu->bindParam(':hiztercih', $hiztercih1, PDO::PARAM_INT);
        $sorgu->bindParam(':reftercih', $reftercih1, PDO::PARAM_INT);
        $sorgu->bindParam(':yorumtercih', $yorumtercih1, PDO::PARAM_INT);
        $sorgu->bindParam(':vidtercih', $vidtercih1, PDO::PARAM_INT);
        $sorgu->bindParam(':bultentercih', $bultentercih1, PDO::PARAM_INT);
        $sorgu->bindParam(':kayitidsi', $kayitidsi, PDO::PARAM_INT);

        if ($sorgu->execute()) {
            echo '<div class="col-lg-6 mx-auto">
            <div class="alert alert-success mt-3 text-center">Tasarım Güncellemesi Başarılı!</div>
            </div>';
           
            header("refresh:32;url=control.php?sayfa=tas");
        } else {
            echo '<div class="alert alert-danger mt-3 text-center">Güncelleme başarısız oldu!</div>';
        }

        // Tasarım Bölümleri Alanı
        $tasarimbilgial = self::sorgum($vt, "SELECT * FROM tasarimbolumler ORDER BY siralama ASC;",0); // 2: Tüm sonuçları döndür
        
        if (!$tasarimbilgial) {
            echo '<div class="alert alert-danger mt-3 text-center">Tasarım bilgisi bulunamadı!</div>';
            return;
        }
        
        echo '<div class="row justify-content-center mt-4">'; // Ortalamak için justify-content-center sınıfı ekleniyor
        
        // Form başlıyor
        echo '<div class="col-lg-6">
            <div class="card shadow-sm">
                <table class="table table-striped mt-1 table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Bölüm Adı</th>
                            <th class="text-center">Sıralama</th>
                        </tr>
                    </thead>
                   
                    <tbody>';
        
        // Dinamik tablo satırları
        while ($bolumson = $tasarimbilgial->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>
                <td class="text-center">' . htmlspecialchars($bolumson["ad"], ENT_QUOTES, 'UTF-8') . '</td>
                <td class="text-center">' . htmlspecialchars($bolumson["siralama"], ENT_QUOTES, 'UTF-8') . '</td>
                <td> <a href="control.php?sayfa=tasarimguncelle&id=' . $bolumson["id"] . '" class="ti-reload text-success" style="font-size:20px;"></a></td>
            </tr>';
        }
        
        echo '</tbody>
                </table>
            </div>
        </div>';
        
        echo '</div>'; // row sınıfını kapatıyoruz
    
}
}

//Bölüm Güncelleme Yönetim Ayarları

function tasarimGuncelleme($vt) {
    // Tüm linkleri sıralama bilgisiyle alıyoruz
    $linklerebak = parent::sorgum($vt, "SELECT * FROM tasarimbolumler ORDER BY siralama ASC", 2);

    echo '<div class="row text-center">
        <div class="col-lg-12 border-bottom">
            <h3 class="mt-3 text-info">Bölüm Bilgisi</h3>
        </div>
    </div>';

    // Gelen ID'yi alıyoruz
    $kayitid = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
    if ($kayitid <= 0) {
        echo '<div class="alert alert-danger mt-3 text-center">Geçersiz ID!</div>';
        return;
    }

    // Veritabanından mevcut kaydı alıyoruz
    $kayitbilgial = parent::sorgum($vt, "SELECT * FROM tasarimbolumler WHERE id=$kayitid", 1);
    if (!$kayitbilgial) {
        echo '<div class="alert alert-danger mt-3 text-center">Kayıt bulunamadı!</div>';
        return;
    }

    echo '<div class="row justify-content-center mt-4">'; // Ortalamak için justify-content-center sınıfı ekleniyor

    // Link güncelleme formu
    echo '<div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white text-center">
                <h5>Bölüm Güncelle</h5>
            </div>
            <div class="card-body">

            
                <div class="row">
                    <div class="col-lg-2 pt-3">Bölüm Sırası</div>
                    <div class="col-lg-10 p-2">
                        <form action="" method="post">
                            <select name="gideceksira" id="sira" class="form-control">';
    
    // Sıralama seçeneklerini ekliyoruz
    if ($linklerebak && is_array($linklerebak)) {
        foreach ($linklerebak as $sonbilgi) {
            $selected = ($sonbilgi["siralama"] == $kayitbilgial["siralama"]) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($sonbilgi["siralama"], ENT_QUOTES, 'UTF-8') . '" ' . $selected . '>'
                . htmlspecialchars($sonbilgi["siralama"], ENT_QUOTES, 'UTF-8') . ' - ' 
                . htmlspecialchars($sonbilgi["ad"], ENT_QUOTES, 'UTF-8') . 
                '</option>';
        }
    } else {
        echo '<option value="">Sıralama bilgisi bulunamadı</option>';
    }

    echo '              </select>
                        <div class="col-lg-12 border-top p-2 text-center">
                            <input type="hidden" name="kayitidsi" value="' . htmlspecialchars($kayitid, ENT_QUOTES, 'UTF-8') . '">
                            <input type="hidden" name="mevcutsira" value="' . htmlspecialchars($kayitbilgial["siralama"], ENT_QUOTES, 'UTF-8') . '">
                            <input type="submit" name="buton" class="btn btn-primary" value="Bölüm Güncelle">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>';

    echo '</div>'; // row sınıfını kapatıyoruz

    // Form gönderildiğinde veritabanına güncelleme işlemi
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $gideceksira = isset($_POST["gideceksira"]) ? intval($_POST["gideceksira"]) : 0;
        $mevcutsira = isset($_POST["mevcutsira"]) ? intval($_POST["mevcutsira"]) : 0;
        $kayitidsi = isset($_POST["kayitidsi"]) ? intval($_POST["kayitidsi"]) : 0;

        if (!empty($gideceksira) && $gideceksira > 0 && $kayitidsi > 0) {
            try {
                $vt->beginTransaction();

                // Eski sırayı boşalt
                $bosalt = $vt->prepare("UPDATE tasarimbolumler SET siralama = :mevcutsira WHERE siralama = :gideceksira");
                $bosalt->bindParam(':mevcutsira', $mevcutsira, PDO::PARAM_INT);
                $bosalt->bindParam(':gideceksira', $gideceksira, PDO::PARAM_INT);
                $bosalt->execute();

                // Yeni sırayı güncelle
                $guncelle = $vt->prepare("UPDATE tasarimbolumler SET siralama = :gideceksira WHERE id = :kayitidsi");
                $guncelle->bindParam(':gideceksira', $gideceksira, PDO::PARAM_INT);
                $guncelle->bindParam(':kayitidsi', $kayitidsi, PDO::PARAM_INT);
                $guncelle->execute();

                $vt->commit();

                echo '<div class="alert alert-success mt-3 text-center">Tasarım Güncelleme başarılı!</div>';
                header("refresh:2;url=control.php?sayfa=tas");
            } catch (Exception $e) {
                $vt->rollBack();
                echo '<div class="alert alert-danger mt-3 text-center">Güncelleme yapılırken bir hata oluştu: ' . $e->getMessage() . '</div>';
            }
        } else {
            echo '<div class="alert alert-warning mt-3 text-center">Lütfen tüm alanları doldurun!</div>';
        }
    }
}


function bakim($db) {
    echo '<div class="row text-center">';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Veritabanındaki tüm tabloları alıyoruz
        $tablolar = self::sorgum($db, "SHOW TABLES", 2); // Tercih 2, array döndürür

        if (is_array($tablolar)) {
            // Her tabloyu döngüyle işliyoruz
            foreach ($tablolar as $tabloson) {
                $tabloAdi = $tabloson["Tables_in_" . $db->query("SELECT DATABASE()")->fetchColumn()];
                $db->query("REPAIR TABLE " . $tabloAdi);
                $db->query("OPTIMIZE TABLE " . $tabloAdi);
                echo '<div class="alert alert-success mt-2 col-lg-9 mx-auto text-center">' . htmlspecialchars($tabloAdi) . ' tablosu onarıldı ve optimize edildi.</div><br>';
            }
            echo '<div class="alert alert-success mt-3 text-center">Veritabanı bakımı tamamlandı!</div>';
        } else {
            echo '<div class="alert alert-danger mt-3 text-center">Tablolar alınamadı!</div>';
        }

        // Bakım zamanını güncelliyoruz
        $zaman = date("Y-m-d H:i:s");
        $sorgu = $db->prepare("UPDATE ayarlar SET bakimzaman = :zaman");
        $sorgu->bindParam(':zaman', $zaman, PDO::PARAM_STR);
        $sorgu->execute();
    } else {
        // Bakım başlatma formu
        echo '
        <div class="col-lg-4 mx-auto mt-2">
            <div class="card card-bordered">
                <div class="card-body">
                    <h5 class="title border-bottom">VERİTABANI BAKIM</h5>
                    <form action="" method="post">
                        <input type="submit" name="buton" class="btn btn-primary mb-1" value="BAKIMI BAŞLAT" />
                    </form>
                </div>
            </div>
        </div>';
    }

    // Bakım zamanı gösterimi
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        $zamanbak = self::sorgum($db, "SELECT bakimzaman FROM ayarlar", 1);

        echo '
        <div class="col-lg-4 mx-auto mt-2">
            <div class="card card-bordered">
                <div class="card-body">';
                
        if ($zamanbak && isset($zamanbak["bakimzaman"])) {
            echo '<p class="mt-3">Son Bakım Zamanı: <strong>' . htmlspecialchars($zamanbak["bakimzaman"]) . '</strong></p>';
        } else {
            echo '<p class="mt-3">Son Bakım Zamanı: <strong>Henüz yapılmadı</strong></p>';
        }

        echo '
                </div>
            </div>
        </div>';
    }

   
    echo '</div>'; // row sınıfını kapatıyoruz
}

//Duyuru ve haber bölümü ayarları





function haberler($vt) {
			
    echo '<div class="row text-center">
    <div class="col-lg-12 border-bottom"><h4 class="float-left mt-3 text-dark mb-2">
    <a href="control.php?sayfa=haberekle" class="ti-plus bg-dark p-1 text-white mr-2 mt-3" ></a>
    HABER VE DUYURULAR</h4>
    </div>';
    
$introbilgiler=self::sorgum($vt,"select * from haberler",0);
    
    while ($sonbilgi=$introbilgiler->fetch(PDO::FETCH_ASSOC)) :
    
    echo '<div class="col-lg-6">
    
            <div class="row card-bordered p-1 m-1 bg-light">
            
                <div class="col-lg-10 pt-1 pb-1 text-left text-danger">
                    <b class="text-dark"> TARİH : </b>  '.$sonbilgi["tarih"].'					
                </div>
                
                <div class="col-lg-2 text-right">
                <a href="control.php?sayfa=haberguncelle&id='.$sonbilgi["id"].'" class="ti-reload text-success" style="font-size:20px;"></a>
                
                    <a href="control.php?sayfa=habersil&id='.$sonbilgi["id"].'" class="ti-trash text-danger pl-2" style="font-size:20px;"></a>
                </div>
                
                <div class="col-lg-12 border-top text-secondary text-left bg-white"><b class="text-dark">TR :</b> 
                '.$sonbilgi["icerik_tr"].'
                </div>
                
                <div class="col-lg-12 border-top text-secondary text-left bg-white"><b class="text-dark">EN :</b> 
                '.$sonbilgi["icerik_en"].'
                </div>
                
            
                
        </div>		
                
    </div>';
    
    endwhile;
    
    echo '</div>';
    
} // haber geliyor

function haberekleme($vt) {
    
    echo '<div class="row text-center">
    <div class="col-lg-12 border-bottom"><h3 class="mt-3 text-dark">HABER EKLE</h3>
    </div>';
    

if (!$_POST):


    
    echo '<div class="col-lg-6 mx-auto">
    
            <div class="row card-bordered p-1 m-1 bg-light">
            
                
                
            
                
                <div class="col-lg-12 border-top p-2">
                <form action="" method="post">
                TR - İçerik
                </div>
                <div class="col-lg-12 border-top p-2">
                <textarea name="icerik_tr" rows="5" class="form-control"></textarea>
                </div>
                
                <div class="col-lg-12 border-top p-2">
                EN - İçerik
                </div>
                <div class="col-lg-12 border-top p-2">
                <textarea name="icerik_en" rows="5" class="form-control"></textarea>
                </div>
                
                <div class="col-lg-12 border-top p-2">
                <input type="submit" name="buton" value="HABER EKLE" class="btn btn-primary">
                </form>
                </div>
                
            
                
        </div>		
                
    </div>';
    
    
    
    else:
    
    
    $icerik_tr=htmlspecialchars($_POST["icerik_tr"]);			
    $icerik_en=htmlspecialchars($_POST["icerik_en"]);

    
    if ($icerik_tr=="" && $icerik_en=="") :
                
                
                    echo '<div class="col-lg-6 mx-auto">
        <div class="alert alert-danger mt-5">VERİLER BOŞ OLAMAZ<div>
        
        <div>';		
    
    header("refresh:2,url=control.php?sayfa=haberler");	
    
                    else:
                    
                
                    
                    
self::sorgum($vt,"insert into haberler (icerik_tr,icerik_en) VALUES('$icerik_tr','$icerik_en')",0);	

echo '<div class="col-lg-6 mx-auto">
        <div class="alert alert-success mt-5">EKLEME BAŞARILI<div>
        
        <div>';		
    
    header("refresh:2,url=control.php?sayfa=haberler");	
            
            
            endif;
            
    
    
    endif;
    
    
    
    echo '</div>';
    
} // haber ekle
    
function haberguncelleme($vt) {
    
    echo '<div class="row text-center">
    <div class="col-lg-12 border-bottom"><h3 class="mt-3 text-dark">HABER GÜNCELLE</h3>
    </div>';
    


$kayitid=$_GET["id"];

$kayitbilgial=self::sorgum($vt,"select * from haberler where id=$kayitid",1);	
    

if (!$_POST):


    
    echo '<div class="col-lg-6 mx-auto">
    
            <div class="row card-bordered p-1 m-1 bg-light">
            
            
                
                
            
                
                <div class="col-lg-12 border-top p-2">
                <form action="" method="post">
                TR - İçerik
                </div>
                <div class="col-lg-12 border-top p-2">
                <textarea name="icerik_tr" rows="5" class="form-control">'.$kayitbilgial["icerik_tr"].'</textarea>
                </div>
                
                    <div class="col-lg-12 border-top p-2">
                EN - İçerik
                </div>
                <div class="col-lg-12 border-top p-2">
                <textarea name="icerik_en" rows="5" class="form-control">'.$kayitbilgial["icerik_en"].'</textarea>
                </div>
                
                
                
                
                
                <div class="col-lg-12 border-top p-2">
                <input type="hidden" name="kayitidsi" value="'.$kayitid.'">
                <input type="submit" name="buton" value="HABER GÜNCELLE" class="btn btn-primary">
                </form>
                </div>
                
            
                
        </div>		
                
    </div>';
    
    
    
    else:
    

    $icerik_tr=htmlspecialchars($_POST["icerik_tr"]);			
    $icerik_en=htmlspecialchars($_POST["icerik_en"]);

    
    $kayitidsi=htmlspecialchars($_POST["kayitidsi"]);
    
            if ($icerik_tr=="" && $icerik_en=="") :
                
                
                    echo '<div class="col-lg-6 mx-auto">
        <div class="alert alert-danger mt-5">VERİLER BOŞ OLAMAZ<div>
        
        <div>';		
    
    header("refresh:2,url=control.php?sayfa=haberler");	
    
                    else:
                    
                    
self::sorgum($vt,"update haberler set icerik_tr='$icerik_tr',icerik_en='$icerik_en',tarih=CURRENT_TIMESTAMP() where id=$kayitidsi",0);	

echo '<div class="col-lg-6 mx-auto">
        <div class="alert alert-success mt-5">GÜNCELLEME BAŞARILI<div>
        
        <div>';		
    
    header("refresh:2,url=control.php?sayfa=haberler");	
            
            
            endif;
            
    
    
    endif;
    
    
    
    echo '</div>';
    
} // haber güncelle

function habersil ($vt) {


$kayitid=$_GET["id"];

    echo '<div class="row text-center">
    <div class="col-lg-12">';
    
    self::sorgum($vt,"delete from haberler where id=$kayitid",0);		

echo '<div class="alert alert-success mt-5">SİLME BAŞARILI<div>';	
    echo '</div></div>';
    
    header("refresh:2,url=control.php?sayfa=haberler");

} // haber sil
                    
}
?>

                    