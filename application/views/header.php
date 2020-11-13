<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?> - <?php echo htmlentities($this->config->item("site_name")); ?></title>
  <?php if(isset($p["description"])): ?>
  <meta name="description" content="<?php echo htmlentities($p["description"]); ?>">
  <meta name="keywords" content="<?php echo htmlentities($p["tags"]); ?>">
  <?php else: ?>
  <meta name="description" content="<?php echo htmlentities($this->config->item("site_description")); ?>">
  <meta name="keywords" content="<?php echo htmlentities($this->config->item("site_tags")); ?>">
  <?php endif; ?>
  <base href="<?php echo base_url(); ?>">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/theme.min.css">
  <link rel="stylesheet" href="assets/css/aos.min.css">
  <link rel="stylesheet" href="assets/css/toastr.min.css">
  <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
  <link rel="shortcut icon" href="assets/img/favicon.png" type="image/png">
  <script src="assets/js/jquery.min.js"></script>
</head>
<body class="flex-column">
  <nav class="navbar fixed-top navbar-light bg-white shadow navbar-expand-lg" data-aos="fade">
    <div class="container">
      <a class="navbar-brand" href="./"><img src="assets/img/logo.png" alt="Logo"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header1" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="fas fa-bars"></span>
      </button>
      <div class="collapse navbar-collapse" id="header1">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0 align-items-center">
      <?php if(!$this->session->has_userdata('user')): ?>
        <?php foreach($pages as $p): ?>
        <li class="nav-item <?php echo $p["slug"] == $page ? "active" : ""; ?>"><a class="nav-link" href="./p/<?php echo $p["slug"]; ?>"><?php echo $p["name"]; ?></a></li>
        <?php endforeach; ?>
        <?php endif; ?>
      
        
        
      
      
      </ul>
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0 align-items-center">
        <?php if($this->session->has_userdata('user')): ?>
        <li class="nav-item <?php echo $page == "panel" ? "active" : ""; ?>"><a class="nav-link" href="./panel"><i class="fas fa-walking mr-2"></i><?php echo lang("userPanel"); ?></a></li>
        <li class="nav-item <?php echo $page == "my-accounts" ? "active" : ""; ?>"><a class="nav-link" href="./my-accounts"><i class="fas fa-list mr-2"></i><?php echo lang("myAccounts"); ?></a></li>
        <li class="nav-item <?php echo $page == "support" ? "active" : ""; ?>"><a class="nav-link" href="./support"><i class="fas fa-comments mr-2"></i><?php echo lang("support"); ?></a></li>
        <li class="nav-item <?php echo $page == "add-balance" ? "active" : ""; ?>"><a class="nav-link" href="./add-balance"><i class="fas fa-money-bill-alt mr-2"></i><?php echo lang("addBalance"); ?></a></li>
        <a href="http://discord.gg/nationrp" class="btn_1 d-none d-sm-block">Discord</a>
        
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img style="width:30px;height:30px;" class="rounded-circle" src="https://www.gravatar.com/avatar/<?php echo md5($user["email"]); ?>"><span class="ml-2"><?php echo $user["name"]; ?></span><i class="ml-2 fas fa-angle-down"></i></a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <?php if($user["role"] == 1): ?>
              <a class="dropdown-item" href="./admin"><i class="fas fa-user-cog mr-2"></i><?php echo lang("adminPanel"); ?></a>
              <?php endif; ?>
              <a class="dropdown-item <?php echo $page == "profile" ? "active" : ""; ?>" href="./profile"><i class="fas fa-user mr-2"></i><?php echo lang("myProfile"); ?></a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="./logout"><i class="fas fa-sign-in-alt mr-2"></i><?php echo lang("logout"); ?></a>
            </div>
          </li>
          

        <?php else: ?>
          
        
        <a href="https://discord.gg/B7AdxjX" class="btn_1 d-none d-sm-block">Discord</a>
        <li class="nav-item"><a class="nav-link" href="./login"><i class="fas fa-sign-in-alt mr-2"></i><?php echo lang("login"); ?></a></li>
        <li class="nav-item"><a class="btn btn-outline-success ml-lg-2" href="./register"><i class="fas fa-user-plus mr-2"></i><?php echo lang("register"); ?></a></li>
        <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
  <main class="flex-grow-1">