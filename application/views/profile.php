<div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark "><?php echo lang("myProfile"); ?></h2>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="py-5">
    <div class="container overflow-x-hidden">
    <div class="row">
    <div class="col-md-6" data-aos="fade-right">
    <h3 class="font-bold"><?php echo lang("profileSettings"); ?></h3>
    <form action="./profile-update" method="post" class="ajaxForm" data-loading="<?php echo lang("pleaseWait"); ?>" data-loading-button="submitBtn" data-redirect="./profile">
      <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
        <div class="my-4">
          <h5 class="text-secondary"><?php echo lang("yourName"); ?>:</h5>
          <input style="height: calc(2.25rem + 12px);" required value="<?php echo $user["name"]; ?>" type="text" class="form-control" name="name" placeholder="<?php echo lang("enterYourName"); ?>">
        </div>
        <div class="my-4">
          <h5 class="text-secondary"><?php echo lang("yourEmail"); ?>:</h5>
          <input style="height: calc(2.25rem + 12px);" required value="<?php echo $user["email"]; ?>" type="text" class="form-control" name="email" disabled="disabled" placeholder="<?php echo lang("enterYourName"); ?>">
          <div class="mt-2"><small><?php echo lang("emailText"); ?></small></div>
        </div>
        <div class="my-4">
          <h5 class="text-secondary"><?php echo lang("yourNewPassword"); ?>:</h5>
          <input style="height: calc(2.25rem + 12px);" value="" type="password" class="form-control" name="password" placeholder="<?php echo lang("enterNewPassword"); ?>">
          <div class="mt-2"><small><?php echo lang("newPasswordText"); ?></small></div>
        </div>
      <button id="submitBtn" type="submit" class="btn btn-info"><?php echo lang("submit"); ?></button>
    </form>
    </div>
    <div class="col-md-6" data-aos="fade-left">
    <h3 class="font-bold"><?php echo lang("paymentNotifications"); ?></h3>
    <div class="mt-4 table-responsive">
    <table class="table table-striped">
    <thead>
    <td><?php echo lang("paymentBank"); ?></td>
    <td><?php echo lang("paymentAmount"); ?></td>
    <td><?php echo lang("paymentDate"); ?></td>
    <td><?php echo lang("paymentStatus"); ?></td>
    </thead>
    <tbody>
    <?php if($results !== false): ?>
    <?php foreach($results as $payment): ?>
    <tr>
    <td><?php
    if($payment["bank"] == 0) {
      echo lang("bankCreditCard");
    }
    else {
      $d = array_filter($bank_accounts, function($b) use ($payment) {
        return $b["id"] == $payment["bank"];
      });
      if(count($d) > 0) {
        echo $d[0]["bank_name"];
      }  
    }
    ?>
    </td>
    <td><?php echo sprintf("%s %s", $payment["amount"], $this->config->item("site_money_sign")); ?></td>
    <td><?php echo date("d/m/Y H:i", $payment["time"]); ?></td>
    <td><?php
    switch($payment["status"]) {
        case 0:
          echo "<span class='badge badge-info'>".lang("paymentNotificationWaiting")."</span>";
        break;
        case 1:
          echo "<span class='badge badge-success'>".lang("paymentNotificationConfirmed")."</span>";
        break;
        case -1:
          echo "<span class='badge badge-danger'>".lang("paymentNotificationRejected")."</span>";
        break;
    } ?></td>
    </tr>
    <?php endforeach; ?>
    <?php else: ?>
    <td colspan="4"><?php echo lang("noPaymentNotifications"); ?></td>
    <?php endif; ?>
    </tbody>
    </table>
    <p><?php echo $links; ?></p>
    </div>
    </div>
    </div>
    </div>
  </div>
  <script src="assets/js/ajaxform.js"></script>