<div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark "><?php echo lang("addBalance"); ?></h2>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="py-5">
    <div class="container">
    <ul class="nav nav-tabs" id="paymentGateways" role="tablist" data-aos="fade">
    <li class="nav-item">
      <a class="nav-link active" id="card-tab" data-toggle="tab" href="#card" role="tab" aria-controls="card" aria-selected="true"><i class="fas fa-credit-card mr-2"></i><?php echo lang("creditBankCard"); ?></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="bank-tab" data-toggle="tab" href="#bank" role="tab" aria-controls="bank" aria-selected="false"><i class="fas fa-university mr-2"></i><?php echo lang("bankEft"); ?></a>
    </li>
  </ul>
  <div class="tab-content py-4" id="paymentGatewaysContent" data-aos="fade">
    <div class="tab-pane fade show active" id="card" role="tabpanel" aria-labelledby="card-tab">
    <div class="alert alert-info"><i class="fas fa-info mr-3"></i><?php echo sprintf(lang("minimumPaymentText"), $this->config->item("minimum_payment"), $this->config->item("site_money_sign")); ?></div>
    <form action="./payment-card" method="post">
    <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
    <div class="row">
      <div class="col-md-6">
        <div class="mt-3 input-group mb-4">
          <div class="input-group-prepend">
            <div class="input-group-text"><i class="fas fa-money-bill-alt"></i></div>
          </div>
          <input style="height: calc(2.25rem + 12px);" required type="number" class="form-control" name="amount" min="<?php echo $this->config->item("minimum_payment"); ?>" placeholder="<?php echo lang("enterMoneyAmount"); ?>">
        </div>
        <div class="input-group mb-4">
          <div class="input-group-prepend">
            <div class="input-group-text"><i class="fas fa-phone"></i></div>
          </div>
          <input style="height: calc(2.25rem + 12px);" required type="text" class="form-control" name="phone" placeholder="<?php echo lang("enterPhoneNumber"); ?>">
        </div>
      </div>
    </div>
        <p class="mb-4"><?php echo lang("paymentText"); ?></p>
        <button id="btnSubmit" type="submit" class="btn btn-info"><i class="fas fa-shopping-cart mr-2"></i><?php echo lang("goCheckoutPage"); ?></button>
    </form>
    </div>
    <div class="tab-pane fade" id="bank" role="tabpanel" aria-labelledby="bank-tab">
      <div class="row">
      <?php if($bank_accounts !== false): ?>
      <?php foreach($bank_accounts as $bank_account): ?>
      <div class="col-md-6 p-1 mb-4">
        <div class="card shadow p-4 h-100">
        <div class="row align-items-center h-100">
        <div class="col-md-8">
        <h4><?php echo sprintf(lang("bankName"), $bank_account["bank_name"]); ?></h4>
        <h4><?php echo sprintf(lang("bankOwner"), $bank_account["name"]); ?></h4>
        <h4><?php echo sprintf(lang("bankNumber"), $bank_account["number"]); ?></h4>
        </div>
        <div class="col-md-4 text-left text-md-right">
        <?php if(file_exists("assets/uploads/banks/".$bank_account["id"].".png")): ?>
        <img src="assets/uploads/banks/<?php echo $bank_account["id"]; ?>.png" class="mw-100" style="max-height:70px;">
        <?php endif; ?>
        </div>
        </div>
        </div>
      </div>
      <?php endforeach; ?>
      <?php else: ?>
      <div class="col-12"><div class="alert alert-danger"><i class="fas fa-times-circle mr-2"></i> <?php echo lang("noBankAccounts"); ?></div></div>
      <?php endif; ?>
      </div>
      <?php if($bank_accounts !== false): ?>
      <h3 class="font-bold"><?php echo lang("paymentNotification"); ?></h3>
      <p class="mt-4 mb-2"><?php echo lang("paymentNotificationText"); ?></p>
      <form action="./payment-bank" method="post" class="ajaxForm" data-loading="<?php echo lang("pleaseWait"); ?>" data-loading-button="submitBtn" data-redirect="./profile">
      <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
      <div class="row">
      <div class="col-md-6">
        <div class="mt-3 input-group mb-4">
          <div class="input-group-prepend">
            <div class="input-group-text"><i class="fas fa-university"></i></div>
          </div>
          <select name="bank" class="form-control">
            <option value="0" disabled selected><?php echo lang("selectBank"); ?></option>
            <?php foreach($bank_accounts as $bank_account): ?>
            <option value="<?php echo $bank_account["id"]; ?>"><?php echo $bank_account["bank_name"]; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mt-3 input-group mb-4">
          <div class="input-group-prepend">
            <div class="input-group-text"><i class="fas fa-user"></i></div>
          </div>
          <input style="height: calc(2.25rem + 12px);" required type="text" class="form-control" name="name" placeholder="<?php echo lang("enterAccountName"); ?>">
        </div>
        <div class="input-group mb-4">
          <div class="input-group-prepend">
            <div class="input-group-text"><i class="fas fa-money-bill-alt"></i></div>
          </div>
          <input style="height: calc(2.25rem + 12px);" required type="number" class="form-control" name="amount" min="1" placeholder="<?php echo lang("enterAccountAmount"); ?>">
        </div>
        </div>
      </div>
      <button id="submitBtn" type="submit" class="btn btn-info"><?php echo lang("submit"); ?></button>
      </form>
      <?php endif; ?>
    </div>
  </div>
    </div>
  </div>
  <script src="assets/js/ajaxform.js"></script>
  <?php if($status == 1): ?><script>$(document).ready(function() {toastr.success('<?php echo lang("paymentSuccessMessage"); ?>');});</script><?php endif; ?>
    <?php if($status == 2): ?><script>$(document).ready(function() {toastr.error('<?php echo lang("paymentFailedMessage"); ?>');});</script><?php endif; ?>