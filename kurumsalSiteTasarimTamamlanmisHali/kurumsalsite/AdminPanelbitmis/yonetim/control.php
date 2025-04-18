<?php
include_once("assets/fonksiyonlar.php"); // yonetim sınıfının tanımlandığı dosyanın yolunu ekleyin
$yonetim = new yonetim;
$yonetim->kontrolet("cot");
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
    #hakkimizdayazilar{
      padding-top: 20%;
      font-size: 24px;
    }
    #hakkimizdayazilarm{
      
      font-size: 24px;
    }
  </style>
</head>

<body>
<!-- page container area start -->
<div class="page-container">
  <!-- sidebar menu area start -->
  <div class="sidebar-menu">
    <div class="sidebar-header">
      <div class="logo">
        <a href="control.php"><img src="assets/images/logo/logo.png" alt="logo"></a>
      </div>
    </div>
    <div class="main-menu">
      <div class="menu-inner">
        <nav>
          <ul class="metismenu" id="menu">
            <li><a href="control.php?sayfa=siteayar"><i class="ti-pencil"></i> <span>Site Ayarları</span></a></li>
            <li><a href="control.php?sayfa=introayar"><i class="ti-image"></i> <span>İntro Ayarları</span></a></li>
            <li><a href="control.php?sayfa=aracfilo"><i class="ti-flag"></i> <span>Araç Filosu</span></a></li>
            <li><a href="control.php?sayfa=hakkimiz"><i class="ti-medall"></i> <span>Hakkımızda Ayarları</span></a></li>
            <li><a href="control.php?sayfa=hizmetler"><i class="ti-eye"></i> <span>Hizmetlerimiz Ayarları</span></a></li>
            <li><a href="control.php?sayfa=ref"><i class="ti-car"></i> <span>Referanslar Ayarları</span></a></li>
            <li><a href="control.php?sayfa=yorumlar"><i class="ti-comment-alt"></i> <span>Müşteri Yorumları</span></a></li>
            <li><a href="control.php?sayfa=yorumlar"><i class="fa fa-envelope"></i> <span>Gelen Mesajlar</span></a></li>
            <li><a href="control.php?sayfa=yorumlar"><i class="fa fa-cog"></i> <span>Mail Ayarları</span></a></li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
  <!-- sidebar menu area end -->
  <!-- main content area start -->
  <div class="main-content">
    <!-- header area start -->
    <div class="header-area">
      <div class="row align-items-center">
        <!-- nav and search button -->
        <div class="col-md-6 col-sm-8 clearfix" style="max-height: 30px;">
          <div class="nav-btn pull-left">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div>
        <!-- profile info & task notification -->
        <div class="col-sm-6 clearfix">
          <div class="user-profile pull-right">
            <img class="avatar user-thumb" src="assets/images/author/avatar.png" alt="avatar">
            <h4 class="user-name dropdown-toggle" data-toggle="dropdown"><?php echo $yonetim->kuladial($baglanti); ?> <i class="fa fa-angle-down"></i></h4>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="control.php?sayfa=cikis">Çıkış</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- header area end -->
    <!-- page title area start -->
    <!-- page title area end -->
    <div class="main-content-inner">
      <!-- sales report area start -->
      <div class="row">
        <div class="col-lg-12 mt-2 bg-white text-center" style="min-height:500px;">
          <?php
          @$sayfa = $_GET["sayfa"];
          switch ($sayfa) :
            case "siteayar":
              $yonetim->siteayar($baglanti);
              break;
              
              
              
              case "cikis":
                $yonetim->cikis($baglanti);
                break;

                //İntro Ayarları
                case "introayar":
                  $yonetim->introayar($baglanti);
                  break;
         
                case "introresimguncelle":
                    $yonetim->introresimguncelleme($baglanti);
                    break;

                case "introresimsil":
                      $yonetim->introsil($baglanti);
                      break;

                case "introresimekle":
                        $yonetim->introresimekleme($baglanti);
                        break;
                       
                        //Filo Ayarlari
                        case "aracfilo":
                          $yonetim->aracfilo($baglanti);
                          break;
                 
                        case "aracfiloguncelle":
                            $yonetim->aracfiloguncelleme($baglanti);
                            break;
                        case "aracfilosil":
                              $yonetim->aracfilosil($baglanti);
                              break;
                        case "aracfiloekle":
                                $yonetim->aracfiloekleme($baglanti);
                                break;
                          
                          //Hakkımızda Ayarları
                          case "hakkimiz":
                                $yonetim->hakkimizda($baglanti);
                                break;
                          
                          //Hizmetlerimiz Ayarları
                          case "hizmetler":
                            $yonetim->hizmetlerhepsi($baglanti);
                            break;
                   
                          case "hizmetguncelle":
                              $yonetim->hizmetguncelleme($baglanti);
                              break;
                          case "hizmetsil":
                                $yonetim->hizmetsil($baglanti);
                                break;
                          case "hizmetekle":
                                  $yonetim->hizmetekleme($baglanti);
                                  break;

                          //Referanslar Ayarları
                          case "ref":
                            $yonetim->referanslarhepsi($baglanti);
                            break;
                   
                          case "refsil":
                                $yonetim->refsil($baglanti);
                                break;
                          case "refekle":
                                  $yonetim->refekleme($baglanti);
                                  break;

                          //Müşteri Yorumları Ayarları
                          


                          case "yorumlar":
                            $yonetim->yorumlarhepsi($baglanti);
                            break;
                   
                          case "yorumguncelle":
                              $yonetim->yorumlarguncelleme($baglanti);
                              break;
                          case "yorumsil":
                                $yonetim->yorumlarsil($baglanti);
                                break;
                          case "yorumekle":
                                  $yonetim->yorumlarekleme($baglanti);
                                  break;

            
                    endswitch;
          ?>
        </div>
      </div>
    </div>
  </div>
  <!-- main content area end -->
</div>
<!-- page container area end -->

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