<?php
session_start(); // Oturumu başlatıyoruz


$dil = isset($_GET["dil"]) ? htmlspecialchars($_GET["dil"], ENT_QUOTES, 'UTF-8') : null;

if (in_array($dil, ["tr", "en"])) {
    $_SESSION["dil"] = $dil;
    header("Location: deneme.php");
    exit;
} else {
    if (!isset($_SESSION["dil"])) {
       
        $_SESSION["dil"] = "tr";
    }
}


include_once("lib/fonksiyon.php");
include_once("lib/tasarim.php");

// Sınıf nesneleri
$sinif = new kurumsal;
$tas = new tasarim;

// PDO bağlantısını kontrol ediyoruz
if (!$sinif->baglanti) {
    
    error_log("PDO bağlantısı başarısız.");
    die("Veritabanı bağlantısı kurulamadı. Lütfen daha sonra tekrar deneyin.");
}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($sinif->normaltitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <meta name="title" content="<?php echo htmlspecialchars($sinif->metatitle, ENT_QUOTES, 'UTF-8'); ?>" />
    <meta name="description" content="<?php echo htmlspecialchars($sinif->metadesc, ENT_QUOTES, 'UTF-8'); ?>" />
    <meta name="keywords" content="<?php echo htmlspecialchars($sinif->metakey, ENT_QUOTES, 'UTF-8'); ?>" />
    <meta name="author" content="<?php echo htmlspecialchars($sinif->metaout, ENT_QUOTES, 'UTF-8'); ?>" />
    <meta name="owner" content="<?php echo htmlspecialchars($sinif->metaown, ENT_QUOTES, 'UTF-8'); ?>" />
    <meta name="copyright" content="<?php echo htmlspecialchars($sinif->metacopy, ENT_QUOTES, 'UTF-8'); ?>" />

    <!-- Kütüphaneler -->
    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/jquery/jquery-migrate.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/superfish/hoverIntent.js"></script>
    <script src="lib/superfish/superfish.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/magnific-popup/magnific-popup.min.js"></script>
    <script src="lib/sticky/sticky.js"></script>
    <script src="js/main.js"></script>

    <!-- Fontlar -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800|Montserrat:300,400,700" rel="stylesheet">

    <!-- Stil dosyaları -->
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/magnific-popup/magnific-popup.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <script>
        $(document).ready(function(e) {

           
            $("#gonderbtn").click(function() {
                $.ajax({
                    type: "POST",
                    url: "lib/mail/PhpMailler/gonder.php",
                    data: $('#mailform').serialize(),
                    success: function(donen) {
                        $('#mailform').trigger("reset");
                        $('#formtutucu').fadeOut(500);
                        $('#mesajsonuc').html(donen);
                    },
                    error: function(xhr, status, error) {
                        $('#mesajhata').html("Bir hata oluştu: " + error);
                    }
                });
            });
        });
        
       
        $(document).ready(function(e) {
        $('#bultensonuc').hide();
            $("#bultenbtn").click(function() {
                $.ajax({
                    type: "POST",
                    url: "lib/islem.php?islem=bultenislem",
                    data: $('#bultenform').serialize(),
                    success: function(donen) {
                        $('#bultenform').trigger("reset");
                        $('#bultentutucu').fadeOut();
                        $('#bultensonuc').html(donen).fadeIn();
                    },
                    error: function(xhr, status, error) {
                        $('#mesajhata').html("Bir hata oluştu: " + error);
                   
                    }
                });
            });

        });
      
    </script>
</head>

<body id="body">

    <!-- ÜST BAR -->
    <section id="topbar" class="d-none d-lg-block">
        <div class="container clearfix">
            <div class="contact-info float-left">
                <i class="fa fa-envelope-o"></i><a href="mailto:<?php echo htmlspecialchars($sinif->mailadres, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($sinif->mailadres, ENT_QUOTES, 'UTF-8'); ?></a>
                <i class="fa fa-phone"></i><?php echo htmlspecialchars($sinif->telno, ENT_QUOTES, 'UTF-8'); ?>
            </div>
            <div class="social-links float-right">
                <a href="<?php echo htmlspecialchars($sinif->tvit, ENT_QUOTES, 'UTF-8'); ?>" class="twitter"><i class="fa fa-twitter"></i></a>
                <a href="<?php echo htmlspecialchars($sinif->face, ENT_QUOTES, 'UTF-8'); ?>" class="facebook"><i class="fa fa-facebook"></i></a>
                <a href="<?php echo htmlspecialchars($sinif->ints, ENT_QUOTES, 'UTF-8'); ?>" class="instagram"><i class="fa fa-instagram"></i></a>
                <a href="deneme.php?dil=tr" class="twitter">TR</a>
                <a href="deneme.php?dil=en" class="twitter">EN</a>
            </div>
        </div>
    </section>

   

    <!-- HEADER -->
    <header id="header">
        <div class="container">
            <div id="logo" class="pull-left">
                <h1><a href="#body" class="scrollto"><?php echo htmlspecialchars($sinif->logoyazi, ENT_QUOTES, 'UTF-8'); ?></a></h1>
            </div>
            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <?php $sinif->linkler($sinif->baglanti); ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- İNTRO -->
    <section id="intro">
        <div class="intro-content">
            <h2><?php echo htmlspecialchars($sinif->slogan, ENT_QUOTES, 'UTF-8'); ?></h2>
        </div>
        <div id="intro-carousel" class="owl-carousel">
            <?php $sinif->introbak(); ?>
        </div>
    </section>

    <!-- ANA MAIN -->
    <main id="main">
        <section id="hakkimizda" class="wow fadeInUp">
            <div class="container">
                <?php $sinif->hakkimizda(); ?>
            </div>
        </section>

        <!-- Hizmetler -->
        <section id="hizmetler">
            <div class="container">
                <?php $tas->HizmettasarimDuzen(); ?>
            </div>
        </section>

        <!-- Referanslar -->
        <?php $tas->ReftasarimDuzen(); ?>

        <!-- Filomuz -->
        <section id="filo" class="wow fadeInUp">
            <?php echo $sinif->filomuz(); ?>
        </section>

        <!-- Videolar -->
        <?php $tas->VideotasarimDuzen(); ?>

        <!-- Yorumlar -->
        <?php $tas->YorumtasarimDuzen(); ?>

        <!-- İletişim -->
        <section id="iletisim" class="wow fadeInUp">
            <div class="container">
                <div class="section-header">
                    <h2>İletişim</h2>
                    <p><?php echo htmlspecialchars($sinif->iletisimbaslik, ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                <div class="row contact-info">
                    <div class="col-md-4">
                        <div class="contact-address">
                            <i class="ion-ios-location-outline"></i>
                            <h3><?php echo htmlspecialchars($sinif->adresBilgi, ENT_QUOTES, 'UTF-8'); ?></h3>
                            <address><?php echo htmlspecialchars($sinif->normaladres, ENT_QUOTES, 'UTF-8'); ?></address>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-phone">
                            <i class="ion-ios-telephone-outline"></i>
                            <h3><?php echo htmlspecialchars($sinif->telefonBilgi, ENT_QUOTES, 'UTF-8'); ?></h3>
                            <p><a href="tel:<?php echo htmlspecialchars($sinif->telno, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($sinif->telno, ENT_QUOTES, 'UTF-8'); ?></a></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-email">
                            <i class="ion-ios-email-outline"></i>
                            <h3>Mail</h3>
                         
                            <p><a href="mailto:<?php echo htmlspecialchars($sinif->mailadres, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($sinif->mailadres, ENT_QUOTES, 'UTF-8'); ?></a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mb-4">
                <iframe src="<?php echo htmlspecialchars(!empty($sinif->haritabilgi) ? $sinif->haritabilgi : "https://www.google.com/maps/embed?...", ENT_QUOTES, 'UTF-8'); ?>" width="100%" height="380" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
            <div class="container">
                <div class="form">
                    <div id="mesajsonuc"></div>
                    <div id="mesajhata"></div>
                    <div id="formtutucu">
                        <form id="mailform">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input type="text" name="isim" class="form-control" placeholder="<?php echo htmlspecialchars($sinif->adbilgi, ENT_QUOTES, 'UTF-8'); ?>" required="required" />
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" name="mail" class="form-control" placeholder="<?php echo htmlspecialchars($sinif->mailBilgi, ENT_QUOTES, 'UTF-8'); ?>" required="required" />
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" name="konu" class="form-control" placeholder="<?php echo htmlspecialchars($sinif->konuBilgi, ENT_QUOTES, 'UTF-8'); ?>" required="required" />
                            </div>
                           
                            <div class="form-group">
                                <textarea class="form-control" name="mesaj" rows="5"></textarea>
                            </div>
                            <div class="text-center"><input type="button" value="<?php echo htmlspecialchars($sinif->butonBilgi, ENT_QUOTES, 'UTF-8'); ?>" id="gonderbtn" class="btn btn-info" /></div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer id="footer">
        <div class="row ">


        <div class="col-lg-6 text-center">
         <?php  $tas->BultentasarimDuzen();?>
        </div>


        
       
        <div class="col-lg-4">
        <div class="container">
            <div class="copyright">
                <?php echo htmlspecialchars($sinif->footer, ENT_QUOTES, 'UTF-8'); ?>
            </div>
            <div class="credits">
                <?php echo htmlspecialchars($sinif->metaown, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        </div>
        </div>

        
        </div>
    </footer>
    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
</body>

</html>