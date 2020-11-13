 
 
  
 <div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row">
                <div class="order-lg-2 col-md-5 col-lg-6 align-self-center ml-auto text-right" data-aos="fade-left">
                      <img src="assets/img/phone.png" style="height:370px" class="img-fluid" />
                      <?php 
                                    error_reporting(0);
                                    /*-----------------------[ AYARLAR ]------------------------------*/
                                     $server_settings['ip'] = "185.255.92.37";
                                    $server_settings['port'] = "30120";
                                     $server_settings['max_slots'] = 256;
                                    /*----------------------------------------------------------------*/
                                    $content = json_decode(file_get_contents("http://".$server_settings['ip'].":".$server_settings['port']."/info.json"), true);
                                    if($content)
                                    {
                                        $gta5_players = file_get_contents("http://".$server_settings['ip'].":".$server_settings['port']."/players.json");
	                                    $content = json_decode($gta5_players, true);
	                                    $pl_count = count($content);
                                        $SRV_STATUS1 = "<font style='color: green;'>Çevrimiçi</font> <font style='color: black;'> </br> Oyuncular:</font> <font style='color: red;'>";
                                        $SRV_STATUS2 = "$pl_count";
                                        $SRV_STATUS3 = "/"; 
                                        $SRV_STATUS4 = "$server_settings[max_slots]";
                                        $SRV_STATUS5 = "</font>";
                                        $SRV_STATUS6 = $SRV_STATUS1 . $SRV_STATUS2 . $SRV_STATUS3 . $SRV_STATUS4 . $SRV_STATUS5;
									}
                                    else
                                    {
                                        $SRV_STATUS6 = "<font style='color: red;'>Çevrimdışı</font>";
									}
                                    echo "<div style=' margin-left: 0px; margin-top: 40px;  position: static; '>";
                                    echo"<font style='color: black;'    >Sunucu Durumu: </font> $SRV_STATUS6 </div>";
                                    ?>  
        

                  </div>
                  <div class="order-lg-1 col-md-7 col-lg-5 align-self-center" data-aos="fade-right">
                      <h2 class="title font-bold h2 text-dark"><?php echo lang("headerTitle"); ?></h2>
                      <p class="m-t-40 m-b-40"><?php echo lang("headerText"); ?></p>
                      <button class="btn btn-primary" onclick="$('html, body').animate({scrollTop: $('#categories').offset().top}, 1000);"><?php echo lang("viewAccounts"); ?> <i class="fas fa-angle-right ml-2"></i></button>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="py-5">
    <div class="container overflow-x-hidden">
      <div class="row">
        <div class="px-3 px-lg-2 mb-3 mb-lg-0" data-aos="fade-right"><img src="assets/img/support.png" style="height:150px" alt="<?php echo lang("instantSupport"); ?>"></div>
        <div class="col-lg px-3 px-lg-2 ml-lg-5" data-aos="fade-left">
          <h4 class="font-bold"><?php echo lang("instantSupport"); ?></h4>
          <p><?php echo lang("instantSupportText"); ?></p>
        </div>
      </div>
      <div class="row mt-2 mt-lg-5">
        <div class="col-md-4 p-3 p-lg-2" data-aos="fade-right">
          <div class="h-100 text-white bg-warning p-4 rounded shadow" style="box-shadow:0 0.125rem .75rem rgba(0, 0, 0, 0.12)">
            <i class="fas fa-check fa-2x"></i>
            <h4 class="text-white my-3"><?php echo lang("guaranteedProducts"); ?></h4>
            <p class="text-white mb-0" style="opacity:.5"><?php echo lang("guaranteedProductsText"); ?></p>
          </div>
        </div>
        <div class="col-md-4 p-3 p-lg-2" data-aos="fade">
          <div class="h-100 text-white bg-success p-4 rounded shadow" style="box-shadow:0 0.125rem .75rem rgba(0, 0, 0, 0.12)">
            <i class="fas fa-rocket fa-2x"></i>
            <h4 class="text-white my-3"><?php echo lang("fastProcess"); ?></h4>
            <p class="text-white mb-0" style="opacity:.5"><?php echo lang("fastProcessText"); ?></p>
          </div>
        </div>
        <div class="col-md-4 p-3 p-lg-2" data-aos="fade-left">
          <div class="h-100 text-white bg-danger p-4 rounded shadow" style="box-shadow:0 0.125rem .75rem rgba(0, 0, 0, 0.12)">
            <i class="fas fa-smile fa-2x"></i>
            <h4 class="text-white my-3"><?php echo lang("customerSatisfaction"); ?></h4>
            <p class="text-white mb-0" style="opacity:.5"><?php echo lang("customerSatisfactionText"); ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="py-5 bg-light">
    <div class="container overflow-x-hidden">
      <div class="row">
        <div class="col-md-6" data-aos="fade-right">
          <h3 class="font-bold mb-4"><?php echo lang("howTheSystemWorks"); ?></h3>
          <p><?php echo lang("howTheSystemWorksText"); ?></p>
        </div>
        <div class="col-md-6 text-right" data-aos="fade-left">
          <img src="assets/img/about.png" class="img-fluid" style="max-height:300px" alt="<?php echo lang("howTheSystemWorks"); ?>">
        </div>
      </div>
    </div>
  </div>
  <div class="py-5" id="categories">
    <div class="container">
      <div class="text-center mb-5"><h3 class="text-primary font-bold"><?php echo lang("accountCategories"); ?></h3></div>
      <?php if(count($categories) > 0): ?>
      <div class="row">
        <?php foreach($categories as $category): ?>
        <?php
        $link = base_url(url_title(convert_accented_characters($category["name"]), "dash", true)."-".strval($category["id"]));
        ?>
        <div class="col-md-4 mb-4">
          <div class="card shadow h-100 mb-0" data-aos="flip-left">
              <a href="<?php echo $link; ?>" class="link"><img class="card-img-top" style="width:100%;height:175px" src="<?php echo file_exists("assets/uploads/category-".strval($category["id"]).".jpg") ? "assets/uploads/category-".strval($category["id"]).".jpg" : "assets/uploads/default.jpg"; ?>"></a>
              <div class="px-3 py-4">
              <h5 class="font-medium" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><a href="<?php echo $link; ?>" class="link"><?php echo $category["name"]; ?></a></h5>
              <p class="m-t-20"><i class="fas fa-hand-point-right mr-2"></i><?php echo sprintf(lang("sellingAccountsText"), $category["unused_accounts_count"]); ?> </p>
              <p class="m-t-20 m-b-20"><i class="fas fa-hand-point-right mr-2"></i><?php echo sprintf(lang("selledAccountsText"), $category["accounts_count"]-$category["unused_accounts_count"]); ?></p>    
              <a href="<?php echo $link; ?>" class="link"><button class="btn btn-primary btn-sm"><?php echo lang("viewAccounts"); ?> <i class="fas fa-angle-right ml-1"></i></button></a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center"><?php echo lang("noCategoryFound"); ?></p>
      <?php endif; ?>
      <?php require 'base/sponsor.php'; ?>
      

      
     

      
<html lang="en">

<!-- Mirrored from donanimarsiviroleplay.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 25 Oct 2020 21:07:10 GMT -->
<head>
</head>
<body 





      
      <!-- Features -->
    <div id="features" class="tabs">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                                                          <h2>ÖZELLİKLER</h2>
                    <div class="p-heading p-large">SUNUCUMUZU TERCİH ETMENİZ İÇİN BAZI ÖZELLİKLER</div>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
            <div class="row">

                <!-- Tabs Links -->
                <ul class="nav nav-tabs" id="lenoTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="nav-tab-2" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false"><i class="fas fa-binoculars"></i>Sunucumuz Hakkında</a>
                    </li>
                </ul>
                <!-- end of tabs links -->


                <!-- Tabs Content-->
                <div class="tab-content" id="lenoTabsContent">
                    
                    <!-- Tab -->
                    <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="tab-1">
                        <div class="container">
                            <div class="row">
                                
                                <!-- Icon Cards Pane -->
                                <div class="col-lg-4">
                                    <div class="card left-pane first">
                                        <div class="card-body">
                                            <div class="text-wrapper">
                                                <h4 class="card-title">Aşırı gerçekçi harita!</h4>
                                            </div>
                                            <div class="card-icon">
                                                <i class="far fa-compass"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card left-pane">
                                        <div class="card-body">
                                            <div class="text-wrapper">
                                                <h4 class="card-title">Kaliteli Scriptler!</h4>
                                            </div>
                                            <div class="card-icon">
                                                <i class="far fa-file-code"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card left-pane">
                                        <div class="card-body">
                                            <div class="text-wrapper">
                                                <h4 class="card-title">+90 FPS Garantisi!</h4>
                                            </div>
                                            <div class="card-icon">
                                                <i class="far fa-gem"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end of icon cards pane -->

                                <!-- Image Pane -->
                                <div class="col-lg-4">
                                    <img class="img-fluid" src="assets/img/features-iphone-1.png" alt="alternative">
                                </div>
                                <!-- end of image pane -->
                                
                                <!-- Icon Cards Pane -->
                                <div class="col-lg-4">
                                    <div class="card right-pane first">
                                        <div class="card-body">
                                            <div class="card-icon">
                                                <i class="far fa-calendar-check"></i>
                                            </div>
                                            <div class="text-wrapper">
                                                <h4 class="card-title">Anında teknik destek!</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card right-pane">
                                        <div class="card-body">
                                            <div class="card-icon">
                                                <i class="far fa-bookmark"></i>
                                            </div>
                                            <div class="text-wrapper">
                                                <h4 class="card-title">7/24 Aktif Ve Deneyimli  Yetkili Ekibi!</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card right-pane">
                                        <div class="card-body">
                                            <div class="card-icon">
                                                <i class="fas fa-cube"></i>
                                            </div>
                                            <div class="text-wrapper">
                                                <h4 class="card-title"> 7000 TL Değerinde İnfinity Paket + 300 Gelişmiş Script!</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end of icon cards pane -->

                            </div> <!-- end of row -->
                        </div> <!-- end of container -->
                    </div> <!-- end of tab-pane -->
                    <!-- end of tab -->

  

                    
    
                    

  </body>

<!-- Mirrored from donanimarsiviroleplay.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 25 Oct 2020 21:07:15 GMT -->
</html>

