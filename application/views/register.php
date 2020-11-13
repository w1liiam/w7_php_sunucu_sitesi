<?php if($this->config->item("recaptcha_enabled") == "1"): ?><script src="https://www.google.com/recaptcha/api.js" async defer></script><?php endif; ?>
  <div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark "><?php echo lang("register"); ?></h2>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="py-5">
    <div class="container overflow-x-hidden">
    <div class="row align-items-center">
      <div class="col-md-6" data-aos="fade-right">
      <h3 class="font-bold"><?php echo lang("registerNow"); ?></h3>
      <p class="my-4"><?php echo lang("registerNowText"); ?></p>
      <form class="ajaxForm" action="" method="post" data-loading="<?php echo lang("pleaseWait"); ?>" data-loading-button="registerSubmitBtn" data-redirect="./panel">
      <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-user"></i></span>
      </div>
      <input type="text" name="name" class="form-control" placeholder="<?php echo lang("enterNameSurname"); ?>" required>
      </div>
      <div class="input-group mt-4">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
      </div>
      <input type="email" name="email" class="form-control" placeholder="<?php echo lang("enterEmailAddress"); ?>" required>
      </div>
      <div class="input-group mt-4">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-key"></i></span>
      </div>
      <input type="password" name="password" class="form-control" placeholder="<?php echo lang("enterPassword"); ?>" required>
      </div>
      <div class="input-group mt-4">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-key"></i></span>
      </div>
      <input type="password" name="password_again" class="form-control" placeholder="<?php echo lang("enterPasswordAgain"); ?>" required>
      </div>
      <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
      <?php if($this->config->item("recaptcha_enabled") == "1"): ?><div class="mt-4 g-recaptcha" data-sitekey="<?php echo $this->config->item("recaptcha_site_key"); ?>"></div><?php endif; ?>
      <button id="registerSubmitBtn" type="submit" class="mt-4 btn btn-primary"><?php echo lang("register"); ?></button>
      </form>
      </div>
      <div class="mt-4 mt-md-0 col-md-6 text-right" data-aos="fade-left">
        <img src="assets/img/register.png" class="mw-100" style="max-height:400px" alt="<?php echo lang("register"); ?>">
      </div>
    </div>
    </div>
  </div>
  <script src="assets/js/ajaxform.js"></script>