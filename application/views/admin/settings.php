<div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark"><?php
                      switch($page) {
                        case "general":
                          echo lang("siteSettings");
                        break;
                        case "recaptcha":
                          echo lang("recaptchaSettings");
                        break;
                        case "payment":
                          echo lang("paymentSettings");
                        break;
                        case "smtp":
                          echo lang("smtpSettings");
                        break;
                      }; ?></h2>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="pb-5">
    <div class="container mt-4" data-aos="fade">
    <form class="ajaxForm" action="./admin/update-settings" method="post" enctype="multipart/form-data" data-redirect="./admin/settings?page=<?php echo $page; ?>" data-loading="<?php echo lang("pleaseWait"); ?>" data-loading-button="submitBtn">
    <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
    <?php if($page == "general"): ?>
    <div class="row">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("siteName"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" value="<?php echo htmlentities($this->config->item("site_name")); ?>" type="text" class="form-control" name="site_name">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("siteDescription"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" value="<?php echo htmlentities($this->config->item("site_description")); ?>" type="text" class="form-control" name="site_description">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("siteTags"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" value="<?php echo htmlentities($this->config->item("site_tags")); ?>" type="text" class="form-control" name="site_tags">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("siteLanguage"); ?>:</h5>
        <select name="site_lang" class="form-control">
          <option value="tr" <?php echo $this->config->item("site_lang") == "tr" ? "selected" : ""; ?>>Türkçe</option>
          <option value="en" <?php echo $this->config->item("site_lang") == "en" ? "selected" : ""; ?>>English</option>
        </select>
      </div>
    </div>
    <?php include(realpath("./application/libraries/Timezones.php")); ?>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("siteTimezone"); ?>:</h5>
        <select name="site_timezone" class="form-control">
        <?php foreach($timezones as $key=>$value): ?>
          <option value="<?php echo $key; ?>" <?php echo $this->config->item("site_timezone") == $key ? "selected" : ""; ?>><?php echo $value; ?></option>
        <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("showLogo"); ?>:</h5>
        <select name="logo" class="form-control">
          <option value="1" <?php echo $this->config->item("logo") == "1" ? "selected" : ""; ?>><?php echo lang("yes"); ?></option>
          <option value="0" <?php echo $this->config->item("logo") == "0" ? "selected" : ""; ?>><?php echo lang("no"); ?></option>
        </select>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("siteLogo"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" type="file" class="form-control p-2" name="logo" accept="image/*">
        <small><?php echo lang("keepEmptyText"); ?></small>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("siteFavicon"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" type="file" class="form-control p-2" name="favicon" accept="image/*">
        <small><?php echo lang("keepEmptyText"); ?></small>
      </div>
    </div>
    <?php elseif($page == "recaptcha"): ?>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("recaptchaEnabled"); ?>:</h5>
        <select name="recaptcha_enabled" class="form-control">
          <option value="1" <?php echo $this->config->item("recaptcha_enabled") == "1" ? "selected" : ""; ?>><?php echo lang("yes"); ?></option>
          <option value="0" <?php echo $this->config->item("recaptcha_enabled") == "0" ? "selected" : ""; ?>><?php echo lang("no"); ?></option>
        </select>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("recaptchaSiteKey"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" value="<?php echo htmlentities($this->config->item("recaptcha_site_key")); ?>" type="text" class="form-control" name="recaptcha_site_key">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("recaptchaSecretKey"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" value="<?php echo htmlentities($this->config->item("recaptcha_secret_key")); ?>" type="text" class="form-control" name="recaptcha_secret_key">
      </div>
    </div>
    <?php elseif($page == "smtp"): ?>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("smtpHost"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" value="<?php echo htmlentities($this->config->item("smtp_host")); ?>" type="text" class="form-control" name="smtp_host">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("smtpUser"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" value="<?php echo htmlentities($this->config->item("smtp_user")); ?>" type="text" class="form-control" name="smtp_user">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("smtpPassword"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" value="<?php echo htmlentities($this->config->item("smtp_pass")); ?>" type="text" class="form-control" name="smtp_pass">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("smtpPort"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" value="<?php echo htmlentities($this->config->item("smtp_port")); ?>" type="text" class="form-control" name="smtp_port">
      </div>
    </div>
    <?php elseif($page == "payment"): ?>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("siteCurrency"); ?>:</h5>
        <select name="site_money_sign" class="form-control">
          <option value="₺" <?php echo $this->config->item("site_money_sign") == "₺" ? "selected" : ""; ?>>₺ - TL</option>
          <option value="$" <?php echo $this->config->item("site_money_sign") == "$" ? "selected" : ""; ?>>$ - USD</option>
          <option value="€" <?php echo $this->config->item("site_money_sign") == "€" ? "selected" : ""; ?>>€ - EUR</option>
        </select>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("minimumPayment"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" min="0" value="<?php echo htmlentities($this->config->item("minimum_payment")); ?>" type="number" step="any" class="form-control" name="minimum_payment">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("paymentCommission"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" value="<?php echo htmlentities($this->config->item("payment_commission")); ?>" type="number" step="any" class="form-control" name="payment_commission">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("paymentGateway"); ?>:</h5>
        <select name="payment_method" class="form-control">
          <option value="shopier" <?php echo $this->config->item("payment_method") == "shopier" ? "selected" : ""; ?>>Shopier</option>
          <option value="weepay" <?php echo $this->config->item("payment_method") == "weepay" ? "selected" : ""; ?>>Weepay</option>
        </select>
      </div>
    </div>
    <div class="payment" id="shopier">
      <div class="row mt-3">
        <div class="col-md-12">
          <h5 class="text-secondary"><?php echo lang("shopierApiKey"); ?>:</h5>
          <input style="height: calc(2.25rem + 12px);" value="<?php echo htmlentities($this->config->item("shopier_api_key")); ?>" type="text" class="form-control" name="shopier_api_key">
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-12">
          <h5 class="text-secondary"><?php echo lang("shopierApiSecret"); ?>:</h5>
          <input style="height: calc(2.25rem + 12px);" value="<?php echo htmlentities($this->config->item("shopier_api_secret")); ?>" type="text" class="form-control" name="shopier_api_secret">
        </div>
      </div>
      <div class="row my-3">
        <div class="col-md-12">
          <h5 class="text-secondary"><?php echo lang("shopierSiteIndex"); ?>:</h5>
          <input style="height: calc(2.25rem + 12px);" value="<?php echo htmlentities($this->config->item("shopier_site_index")); ?>" type="text" class="form-control" name="shopier_site_index">
        </div>
      </div>
      <small><?php echo sprintf(lang("callbackUrlText"), base_url("payment-card/callback")); ?></small>
    </div>
    <div class="payment" id="weepay">
      <div class="row mt-3">
        <div class="col-md-12">
          <h5 class="text-secondary"><?php echo lang("weepaySellerId"); ?>:</h5>
          <input style="height: calc(2.25rem + 12px);" value="<?php echo htmlentities($this->config->item("weepay_seller_id")); ?>" type="text" class="form-control" name="weepay_seller_id">
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-12">
          <h5 class="text-secondary"><?php echo lang("weepayApiKey"); ?>:</h5>
          <input style="height: calc(2.25rem + 12px);" value="<?php echo htmlentities($this->config->item("weepay_api_key")); ?>" type="text" class="form-control" name="weepay_api_key">
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-12">
          <h5 class="text-secondary"><?php echo lang("weepaySecretKey"); ?>:</h5>
          <input style="height: calc(2.25rem + 12px);" value="<?php echo htmlentities($this->config->item("weepay_secret_key")); ?>" type="text" class="form-control" name="weepay_secret_key">
        </div>
      </div>
    </div>
    <script>
    $("select[name='payment_method']").change(function() {
      $(".payment").hide();
      $(".payment#"+$(this).val()).show();
    });
    $("select[name='payment_method']").change();
    </script>
    <?php endif; ?>
    <button id="submitBtn" type="submit" class="btn btn-primary mt-3"><?php echo lang("submit"); ?></button>
    </form>
    </div>
  </div>
  <script src="assets/js/ajaxform.js"></script>