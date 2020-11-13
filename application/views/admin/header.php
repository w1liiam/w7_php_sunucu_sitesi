<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?> - <?php echo htmlentities($this->config->item("site_name")); ?></title>
  <meta name="description" content="<?php echo htmlentities($this->config->item("site_description")); ?>">
  <meta name="keywords" content="<?php echo htmlentities($this->config->item("site_tags")); ?>">
  <base href="<?php echo base_url(); ?>">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/theme.min.css">
  <link rel="stylesheet" href="assets/css/aos.min.css">
  <link rel="stylesheet" href="assets/css/toastr.min.css">
  <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/css/responsive.dataTables.min.css">
  <link rel="shortcut icon" href="assets/img/favicon.png" type="image/png">
  <script src="assets/js/jquery.min.js"></script>
</head>
<body class="flex-column">
  <nav class="navbar fixed-top navbar-light bg-white shadow navbar-expand-lg" data-aos="fade">
    <div class="container">
      <a class="navbar-brand" href="./">
        <?php if($this->config->item("logo") == "1"): ?>
          <img src="assets/img/logo.png" alt="Logo">
        <?php else: ?>
          <h1 class="h"><?php echo $this->config->item("site_name"); ?></h1>
        <?php endif; ?>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header1" aria-expanded="false" aria-label="Nav">
        <span class="fas fa-bars"></span>
      </button>
      <div class="collapse navbar-collapse" id="header1">
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0 align-items-center">
        <li class="nav-item <?php echo $page == "admin-panel" ? "active" : ""; ?>"><a class="nav-link" href="./admin"><i class="fas fa-user-cog mr-2"></i><?php echo lang("adminPanel"); ?></a></li>
        <li class="nav-item <?php echo $page == "accounts" || $page == "categories" ? "active" : ""; ?> dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-list mr-2"></i><?php echo lang("accounts"); ?><i class="fas fa-angle-down ml-2"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item <?php echo $page == "categories" ? "active" : ""; ?>" href="./admin/categories"><i class="fas fa-folder-open mr-2"></i><?php echo lang("categories"); ?></a>
          <a class="dropdown-item <?php echo $page == "accounts" ? "active" : ""; ?>" href="./admin/accounts"><i class="fas fa-link mr-2"></i><?php echo lang("accounts"); ?></a>
        </div>
        </li>
        <li class="nav-item <?php echo $page == "payments" ? "active" : ""; ?>"><a class="nav-link" href="./admin/payments"><i class="fas fa-bell mr-2"></i><?php echo lang("payments"); ?></a></li>
        <li class="nav-item <?php echo $page == "users" ? "active" : ""; ?>"><a class="nav-link" href="./admin/users"><i class="fas fa-users mr-2"></i><?php echo lang("users"); ?></a></li>
        <li class="nav-item <?php echo $page == "tickets" ? "active" : ""; ?>"><a class="nav-link" href="./admin/tickets"><i class="fas fa-comments mr-2"></i><?php echo lang("support"); ?></a></li>
        <li class="nav-item <?php echo $page == "pages" || $page == "banks" || $page == "settings" ? "active" : ""; ?> dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-cog mr-2"></i><?php echo lang("settings"); ?><i class="fas fa-angle-down ml-2"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item <?php echo $page == "settings" && $p == "general" ? "active" : ""; ?>" href="./admin/settings"><i class="fas fa-globe mr-2"></i><?php echo lang("siteSettings"); ?></a>
          <a class="dropdown-item <?php echo $page == "settings" && $p == "recaptcha" ? "active" : ""; ?>" href="./admin/settings?page=recaptcha"><i class="fas fa-robot mr-2"></i><?php echo lang("recaptchaSettings"); ?></a>
          <a class="dropdown-item <?php echo $page == "settings" && $p == "smtp" ? "active" : ""; ?>" href="./admin/settings?page=smtp"><i class="fas fa-envelope mr-2"></i><?php echo lang("smtpSettings"); ?></a>
          <a class="dropdown-item <?php echo $page == "settings" && $p == "payment" ? "active" : ""; ?>" href="./admin/settings?page=payment"><i class="fas fa-credit-card mr-2"></i><?php echo lang("paymentSettings"); ?></a>
          <a class="dropdown-item <?php echo $page == "pages" ? "active" : ""; ?>" href="./admin/pages"><i class="fas fa-file-signature mr-2"></i><?php echo lang("pages"); ?></a>
          <a class="dropdown-item <?php echo $page == "banks" ? "active" : ""; ?>" href="./admin/banks"><i class="fas fa-university mr-2"></i><?php echo lang("bankAccounts"); ?></a>
        </div>
        </li>
        </ul>
      </div>
    </div>
  </nav>
  <main class="flex-grow-1">