<?php
include_once("fonksiyon.php");

class tasarim extends kurumsal {
    public $hiztercih, $reftercih, $yorumtercih, $videotercih, $bultentercih;

    function __construct() {
        try {
            // Veritabanı bağlantısını başlatıyoruz
            $this->baglanti = new PDO("mysql:host=localhost;dbname=kurumsal;charset=utf8", "root", "sdsd3490");
            $this->baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            
            // Tasarım tablosundan verileri alıyoruz
            $introal = $this->baglanti->prepare("SELECT * FROM tasarim LIMIT 1");
            $introal->execute();
            $gelen = $introal->fetch(PDO::FETCH_ASSOC);

            if ($gelen) {
                $this->hiztercih = $gelen["hiztercih"];
                $this->reftercih = $gelen["reftercih"];
                $this->yorumtercih = $gelen["yorumtercih"];
                $this->videotercih = $gelen["videotercih"];
                $this->bultentercih = $gelen["bultentercih"];
            } else {
                // Varsayılan değerler atanıyor
                $this->hiztercih = 1;
                $this->reftercih = 1;
                $this->yorumtercih = 1;
                $this->videotercih = 1;
                $this->bultentercih = 1;
            }
        } catch (PDOException $e) {
            // Hataları log dosyasına yazdırıyoruz ve kullanıcıya genel bir mesaj gösteriyoruz
            error_log("Veritabanı hatası: " . $e->getMessage());
            die("Bir hata oluştu. Lütfen daha sonra tekrar deneyin.");
        }

        // Kurumsal sınıfının yapıcısını çağırıyoruz
        parent::__construct();
    }

    // Linkleri kontrol eden fonksiyon
    function Linkcontrol() {
        if ($this->hiztercih == 0) {
            echo '<li><a href="#hizmetler">' . htmlspecialchars("Hizmetlerimiz", ENT_QUOTES, 'UTF-8') . '</a></li>';
        }

        if ($this->videotercih == 0) {
            echo '<li><a href="#videolar">' . htmlspecialchars("Videolar", ENT_QUOTES, 'UTF-8') . '</a></li>';
        }

        if ($this->reftercih == 0) {
            echo '<li><a href="#referanslar">' . htmlspecialchars("Referanslar", ENT_QUOTES, 'UTF-8') . '</a></li>';
        }

        if ($this->yorumtercih == 0) {
            echo '<li><a href="#yorumlar">' . htmlspecialchars("Yorumlar", ENT_QUOTES, 'UTF-8') . '</a></li>';
        }

        if ($this->bultentercih == 0) {
            echo '<li><a href="#bulten">' . htmlspecialchars("Bülten", ENT_QUOTES, 'UTF-8') . '</a></li>';
        }
    }

    // Hizmet tasarımı düzenleme fonksiyonu
    function HizmettasarimDuzen() {
        if ($this->hiztercih == 0) { // Eğer hiztercih 0 ise, hizmetler bölümü gösterilir
            echo '<section id="hizmetler" class="wow fadeInUp">
                    <div class="container">';
            parent::hizmetler($this->hizmetlerbaslik); // Kurumsal sınıfındaki hizmetler fonksiyonunu çağırıyoruz
            echo '</div>
                  </section>';
        } else {
            echo '<!-- Hizmetler bölümü gizlendi -->';
        }
    }

    // Referans tasarımı düzenleme fonksiyonu
    function ReftasarimDuzen() {
        if ($this->reftercih == 0) {
            echo '<section id="referanslar" class="wow fadeInUp">
                    <div class="container">';
            parent::referanslar($this->referansbaslik); // Kurumsal sınıfındaki referanslar fonksiyonunu çağırıyoruz
            echo '</div>
                  </section>';
        } else {
            echo '<!-- Referanslar bölümü gizlendi -->';
        }
    }

    // Yorum tasarımı düzenleme fonksiyonu
    function YorumtasarimDuzen() {
        if ($this->yorumtercih == 0) {
            echo '<section id="yorumlar" class="wow fadeInUp">
                    <div class="container">';
            parent::yorumlar($this->yorumbaslik); // Kurumsal sınıfındaki yorumlar fonksiyonunu çağırıyoruz
            echo '</div>
                  </section>';
        } else {
            echo '<!-- Yorumlar bölümü gizlendi -->';
        }
    }

    // Video tasarımı düzenleme fonksiyonu
    function VideotasarimDuzen() {
        if ($this->videotercih == 0) {
            echo '<section id="videolar" class="wow fadeInUp">';
            parent::videolar(); // Kurumsal sınıfındaki videolar fonksiyonunu çağırıyoruz
            echo '</section>';
        } else {
            echo '<!-- Videolar bölümü gizlendi -->';
        }
    
    }

    // Bülten tasarımı düzenleme fonksiyonu
    function BultentasarimDuzen() {
        if ($this->bultentercih == 0) {
            echo '
            <div id="bultentutucu" style="float: left; width: 50%; margin-top: 20px;">
                <div class="col-lg-12">
                    <h4 class="pt-2 border-bottom text-center" style="color: #007BFF; font-size: 18px;">Bültenimize Kayıt Olun</h4>
                </div>
                <form id="bultenform" style="padding: 15px; border: 1px solid #ddd; border-radius: 5px;">
                    <div class="row">
                        <div class="col-lg-8 text-center mx-auto" style="margin-bottom: 15px;">
                            <input type="email" name="mail" class="form-control" style="border: 1px solid #ccc; padding: 10px;" 
                            placeholder="Mail Adresi" required />
                        </div>
                        <div class="col-lg-8 mx-auto text-center" style="margin-top: 10px;">
                            <input type="button" name="btn" id="bultenbtn" value="Kayıt Ol" class="btn btn-info" style="width: 100%;"/>
                        </div>
                    </div>
                </form>
                <div id="bultensonuc" style="text-align: center; margin-top: 10px; font-size: 14px; color: #555;">
                    <!-- Sonuç mesajı burada gösterilecek -->
                </div>
            </div>';
        } else {
            echo '<!-- Bülten bölümü gizlendi -->';
        }
    }




    
    function TasarimBolumleri() {
        $bolumler = $this->baglanti->prepare("SELECT * FROM tasarimbolumler ORDER BY siralama ASC");
        $bolumler->execute();
        
        while ($bolumlerson = $bolumler->fetch(PDO::FETCH_ASSOC)):
            $class = $bolumlerson["classAd"];
            $this -> $class();
        endwhile;
    }

}
?>