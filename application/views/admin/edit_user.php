<div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark "><?php echo lang("editUser"); ?></h2>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="pb-5">
    <div class="container mt-4" data-aos="fade">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="account-tab" data-toggle="tab" href="#account" role="tab" aria-controls="account" aria-selected="true"><?php echo lang("userDetails"); ?></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="bought-tab" data-toggle="tab" href="#bought" role="tab" aria-controls="bought" aria-selected="false"><?php echo lang("userAccounts"); ?></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="payments-tab" data-toggle="tab" href="#payments" role="tab" aria-controls="payments" aria-selected="false"><?php echo lang("paymentNotifications"); ?></a>
  </li>
</ul>
<div class="tab-content mt-4" id="myTabContent">
  <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
  <form class="ajaxForm" action="./admin/edit-user" method="post" enctype="multipart/form-data" data-redirect="./admin/users/<?php echo $user["id"]; ?>" data-loading="<?php echo lang("pleaseWait"); ?>" data-loading-button="submitBtn">
      <input type="hidden" name="id" value="<?php echo $user["id"]; ?>">
      <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
      <div class="row">
        <div class="col-md-12">
          <h5 class="text-secondary"><?php echo lang("name"); ?>:</h5>
          <input style="height: calc(2.25rem + 12px);" value="<?php echo htmlentities($user["name"]); ?>" type="text" class="form-control" name="name" required>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-12">
          <h5 class="text-secondary"><?php echo lang("email"); ?>:</h5>
          <input style="height: calc(2.25rem + 12px);" value="<?php echo htmlentities($user["email"]); ?>" type="email" class="form-control" name="email" required>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-12">
          <h5 class="text-secondary"><?php echo lang("balance"); ?>:</h5>
          <input style="height: calc(2.25rem + 12px);" value="<?php echo $user["balance"]; ?>" type="number" step="any" class="form-control" name="balance" required>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-12">
          <h5 class="text-secondary"><?php echo lang("password"); ?>:</h5>
          <input style="height: calc(2.25rem + 12px);" value="" type="password" class="form-control" name="password">
          <small><?php echo lang("keepEmptyText"); ?></small>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-12">
          <h5 class="text-secondary"><?php echo lang("userRole"); ?>:</h5>
          <select name="role" class="form-control">
            <option value="0" <?php echo $user["role"] == 0 ? "selected" : ""; ?>><?php echo lang("user"); ?></option>
            <option value="1" <?php echo $user["role"] == 1 ? "selected" : ""; ?>><?php echo lang("admin"); ?></option>
          </select>
        </div>
      </div>
      <div class="row my-3">
        <div class="col-md-12">
          <h5 class="text-secondary"><?php echo lang("registerDate"); ?>:</h5>
          <input disabled style="height: calc(2.25rem + 12px);" value="<?php echo date("d/m/Y H:i:s", $user["created_date"]); ?>" type="text" class="form-control">
        </div>
      </div>
      <button id="submitBtn" type="submit" class="btn btn-primary"><?php echo lang("submit"); ?></button>
      <button class="btn btn-danger" type="button" onclick="$('#deleteForm').submit();"><?php echo lang("deleteUser"); ?></button>
  </form>
  </div>
  <div class="tab-pane fade" id="bought" role="tabpanel" aria-labelledby="bought-tab">
  <table class="dataTable table table-striped w-100">
                <thead>
                    <td>ID</td>
                    <td><?php echo lang("category_name"); ?></td>
                    <td><?php echo lang("accountDate"); ?></td>
                    <td><?php echo lang("accountDays"); ?></td>
                    <td><?php echo lang("mobileVerification"); ?></td>
                    <td><?php echo lang("action"); ?></td>
                </thead>
                <tbody>
                <?php if($accounts != null): ?>
                    <?php foreach($accounts as $result): ?>
                    <tr>
                    <td><?php echo $result["id"]; ?></td>
                    <td><?php echo $result["category_name"]; ?></td>
                    <td><?php echo date("d/m/Y", $result["created_date"]); ?></td>
                    <td><?php echo $result["days"] == 0 ? lang("limitless") : $result["days"]; ?></td>
                    <td><?php echo $result["verified"] == 1 ? lang("yes") : lang("no"); ?></td>
                    <td><button onclick="showDetails('<?php echo rawurlencode($result["details"]); ?>','<?php echo rawurlencode($result["email"]); ?>','<?php echo rawurlencode($result["password"]); ?>')" class="btn btn-info btn-sm"><i class="fas fa-eye mr-2"></i><?php echo lang("details"); ?></button></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
  </div>
  <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
  <table class="dataTable table table-striped w-100">
    <thead>
    <td><?php echo lang("bank"); ?></td>
    <td><?php echo lang("amount"); ?></td>
    <td><?php echo lang("date"); ?></td>
    <td><?php echo lang("status"); ?></td>
    </thead>
    <tbody>
    <?php if($payments !== false): ?>
    <?php foreach($payments as $payment): ?>
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
    <?php endif; ?>
    </tbody>
    </table>
  </div>
</div>
  <form class="ajaxForm" id="deleteForm" action="./admin/delete-user" data-redirect="./admin/users" method="POST">
  <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
  <input type="hidden" name="id" value="<?php echo $user["id"]; ?>">
  </form>  
    </div>
  </div>
  <div class="modal fade" id="detailsModal" role="dialog">
    <div class="modal-dialog">
          <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><?php echo lang("accountDetails"); ?></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo lang("close"); ?></button>
        </div>
      </div>
    </div>
  </div>
  <script>
  function showDetails(details, email, password) {
    $("#detailsModal p").html(decodeURIComponent(details)+"<br/><hr/><b class='font-bold'><?php echo lang("email"); ?>:</b> "+decodeURIComponent(email)+"<br/><b class='font-bold'><?php echo lang("password"); ?>:</b> "+decodeURIComponent(password));
    $("#detailsModal").modal("show");
  }
  </script>
  <script src="assets/js/ajaxform.js"></script>