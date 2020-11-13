<?php if($this->config->item("recaptcha_enabled") == "1"): ?><script src="https://www.google.com/recaptcha/api.js" async defer></script><?php endif; ?>
  <div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark "><?php echo lang("resetPassword"); ?></h2>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="py-5">
    <div class="container overflow-x-hidden">
    <div class="row align-items-center">
      <div class="col-md-6" data-aos="fade-right">
      <h3 class="font-bold"><?php echo lang("resetPassword"); ?></h3>
      <p class="my-4"><?php echo lang("resetPasswordText"); ?></p>
      <?php if(is_null($key)): ?>
      <form class="ajaxForm" action="" method="post" data-loading="<?php echo lang("pleaseWait"); ?>" data-loading-button="resetSubmitBtn" data-redirect="./reset-password">
      <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
      </div>
      <input type="email" name="email" class="form-control" placeholder="<?php echo lang("enterEmailAddress"); ?>" required>
      </div>
      <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
      <?php if($this->config->item("recaptcha_enabled") == "1"): ?><div class="mt-4 g-recaptcha" data-sitekey="<?php echo $this->config->item("recaptcha_site_key"); ?>"></div><?php endif; ?>
      <button id="resetSubmitBtn" type="submit" class="mt-4 btn btn-primary"><?php echo lang("resetPassword"); ?></button>
      </form>
      <?php else: ?>
      <form class="ajaxForm" action="./reset-password/<?php echo $key; ?>" method="post" data-loading="<?php echo lang("pleaseWait"); ?>" data-loading-button="resetSubmitBtn" data-redirect="./login">
      <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-key"></i></span>
      </div>
      <input type="password" name="password" class="form-control" placeholder="<?php echo lang("enterNewPassword"); ?>" required>
      </div>
      <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
      <?php if($this->config->item("recaptcha_enabled") == "1"): ?><div class="mt-4 g-recaptcha" data-sitekey="<?php echo $this->config->item("recaptcha_site_key"); ?>"></div><?php endif; ?>
      <button id="resetSubmitBtn" type="submit" class="mt-4 btn btn-primary"><?php echo lang("resetPassword"); ?></button>
      </form>
      <?php endif; ?>
      </div>
      <div class="mt-4 mt-md-0 col-md-6 text-right" data-aos="fade-left">
        <img src="assets/img/reset-password.png" class="mw-100" style="max-height:400px" alt="<?php echo lang("resetPassword"); ?>">
      </div>
    </div>
    </div>
  </div>
  <script src="assets/js/ajaxform.js"></script>