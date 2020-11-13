<!doctype html>
<html lang="tr">

<head>
	<!-- Sayfa Meta Tagları Başlat Aveiro -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Sunucu Durumu</title>
	<link rel="icon" href="img/favicon.png">
	<!-- Sayfa Meta Tagları Bitir Aveiro -->

<?php require 'base/tags.php'; ?>

<?php require 'base/header.php'; ?>

<body>

	<!-- Body_bg Başlat Aveiro -->
	<div class="body_bg">

<?php require 'base/menubar.php'; ?>
	
	<!-- İçerik Haritası Başlat Aveiro -->
	<section class="breadcrumb breadcrumb_bg4">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="breadcrumb_iner text-center">
						<div class="breadcrumb_iner_item">
							<h4></h4>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- İçerik Haritası Bitir Aveiro -->
		
		<!-- Sunucu Durumu (Status) Başlat Aveiro -->
		<div class="element_page black">
		<section class="sample-text-area">
			<div class="container box_1170">
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
				echo '
				<center>
					<h3>Sunucu Durumu</h3><font style="color: green;">Çevrimiçi</font>
					<div id="server_status">
						<div>icon: <img id="server_icon" src="" alt="Nation Roleplay V.1.0"></div>
						<div id="onesync_enabled"></div>
						<div id="tags"></div>
						<div id="locale"></div>ss
						<div id="sv_maxClients"></div>
						<!--<div id="sv_licenseKeyToken"></div>
						<div id="server"></div>
						<div id="banner_connecting"></div>
						<div id="banner_detail"></div>
						<div id="sv_enhancedHostSupport"></div>
						<div id="sv_lan"></div>
						<div id="sv_scriptHookAllowed"></div>
						<div id="txAdmin_version"></div>-->
					</div>
					</br>
					<h3>Oyuncu Listesi</h3>
					<div id="players">
						<div id="players_count"></div>
						<div id="players_list"></div>
					</div>
				<center/>
				';
			}
			else 
			{
				echo '
				<center>
					<h3>Sunucu Durumu</h3> <font style="color: red;">Aktif</font>
				<center/>
				';
			}
			?>
			</div>
			</div>
		</section>
		<!-- Sunucu Durumu (Status) Bitir Aveiro -->

<?php require 'base/footer.php'; ?>

	</div>
	<!-- Body_bg Bitir Aveiro -->


<?php require 'base/jquery.php'; ?>

    <!-- Status Jquery Başlat Aveiro -->
    <script src="base/status.js"></script>
	<!-- Status Jquery Bitir Aveiro -->

</body>

</html>