<?php
include_once("assets/fonksiyonlar.php"); // yonetim sınıfının tanımlandığı dosyanın yolunu ekleyin
$yonetim = new yonetim;
$yonetim->kontrolet("ind");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['girisyap'])) {
    $kulad = htmlspecialchars($_POST['kuladlab']);
    $sifre = htmlspecialchars($_POST['sifrelab']);

    if ($kulad == "" || $sifre == "") {
        $hata = "Kullanıcı adı ve şifre boş bırakılamaz!";
    } else {
        $yonetim->giriskontrol($kulad, $sifre, $baglanti);
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8">
  <title>Udemy Nakliyat-Yönetim Paneli</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
  
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/themify-icons.css">
  <link rel="stylesheet" href="assets/css/metisMenu.css">
  <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/css/slicknav.min.css">    
  <link rel="stylesheet" href="assets/css/typography.css">
  <link rel="stylesheet" href="assets/css/default-css.css">
  <link rel="stylesheet" href="assets/css/styles.css">
  <link rel="stylesheet" href="assets/css/responsive.css">   
  <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
  <style>
    #siteayarfont {
      font-size: 18px;
    }
    .load-img {
      width: 20px; /* Genişlik */
      height: 20px; /* Yükseklik */
    }
  </style>
</head>

<body>
<div class="login-area">
    <?php if (!$_POST): ?>
        <div class="container">
            <div class="login-box ptb--100">
                <form action="index.php" method="post">
                    <div class="login-form-head">
                        <h4>Yönetim Paneli</h4>
                        <p>Hoşgeldiniz</p>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="kuladlabel">Kullanıcı Adı</label>
                            <input type="text" id="kulad" name="kuladlab" placeholder="Kullanıcı adınızı girin">
                            <i class="ti-user"></i>
                            <div class="text-danger"><?php echo isset($hata) ? $hata : ''; ?></div>
                        </div>
                        <div class="form-gp">
                            <label for="sifrelab">Şifre</label>
                            <input type="password" id="sifre" name="sifrelab" placeholder="Şifrenizi girin">
                            <i class="ti-lock"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="submit-btn-area">
                            <input type="submit" class="btn btn-dark" value="Giriş Yap" name="girisyap">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php else: ?>
        <?php if (isset($hata)): ?>
            <div class="container-fluid bg-white">
                <div class="alert alert-white border border-dark mt-5 p-3 text-dark font-14 font-weight-bold" role="alert">
                    <img src="load.gif" class="mr-3 load-img">Kullanıcı adı ve şifre boş bırakılamaz!
                </div>
            </div>
            <?php header("refresh:2;url=index.php"); exit; ?>
        <?php endif; ?>
    
        <?php endif; ?>
</div>

<div id="preloader">
  <div class="loader"></div>
</div>

<!-- jquery latest version -->
<script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
<!-- bootstrap 4 js -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/metisMenu.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>
<script src="assets/js/jquery.slicknav.min.js"></script>
<!-- others plugins -->
<script src="assets/js/plugins.js"></script>
<script src="assets/js/scripts.js"></script>
</body>
</html>