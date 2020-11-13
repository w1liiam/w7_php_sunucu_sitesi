<div style="height:70px;"></div>
  <div class="py-5">
    <div class="container overflow-x-hidden">
    <div class="row">
      <div class="col-md-4 p-2" data-aos="fade-right">
        <div class="shadow h-100 rounded bg-success text-light">
          <div class="row py-4 px-5 align-items-center">
            <div class="col p-0">
              <h4 class="font-bold text-light"><?php echo lang("totalBalance"); ?>:</h4>
              <h4 class="text-light"><?php echo $totalBalance; ?> <?php echo $this->config->item("site_money_sign"); ?></h4>
            </div>
            <div><i class="fas fa-wallet fa-3x text-light"></i></div>
          </div>
        </div>
      </div>
      <div class="col-md-4 p-2" data-aos="fade">
        <div class="shadow h-100 rounded bg-warning text-light">
          <div class="row py-4 px-5 align-items-center">
            <div class="col p-0">
              <h4 class="font-bold text-light"><?php echo lang("paymentNotifications"); ?>:</h4>
              <h4 class="text-light"><?php echo sprintf(lang("piece"), $pendingPaymentNotificationsCount); ?></h4>
            </div>
            <div><i class="far fa-bell fa-3x text-light"></i></div>
          </div>
        </div>
      </div>
      <div class="col-md-4 p-2" data-aos="fade-left">
        <div class="shadow h-100 rounded bg-danger text-light">
          <div class="row py-4 px-5 align-items-center">
            <div class="col p-0">
              <h4 class="font-bold text-light"><?php echo lang("supportTickets"); ?>:</h4>
              <h4 class="text-light"><?php echo sprintf(lang("piece"), $activeSupportTicketsCount); ?></h4>
            </div>
            <div><i class="far fa-comments fa-3x text-light"></i></div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
  <div class="pb-5">
    <div class="container" data-aos="fade">
    <h3 class="font-bold"><?php echo lang("pendingPaymentNotifications"); ?></h3>
      <table class="table dataTable table-striped w-100">
        <thead>
          <td>ID</td>
          <td><?php echo lang("name"); ?></td>
          <td><?php echo lang("bank"); ?></td>
          <td><?php echo lang("amount"); ?></td>
          <td><?php echo lang("date"); ?></td>
          <td><?php echo lang("action"); ?></td>
        </thead>
        <tbody>
          <?php if($pendingPaymentNotifications !== false): ?>
          <?php foreach($pendingPaymentNotifications as $payment): ?>
          <tr>
          <td><?php echo $payment["id"]; ?></td>
          <td><?php echo $payment["name"]; ?></td>
          <td><?php echo $payment["bank_name"]; ?></td>
          <td><?php echo sprintf("%s %s", $payment["amount"], $this->config->item("site_money_sign")); ?></td>
          <td><?php echo date("d/m/Y H:i", $payment["time"]); ?></td>
          <td><button class="btn btn-info btn-sm mr-2" onclick="process(<?php echo $payment["id"]; ?>, 'approve')"><?php echo lang("approve"); ?></button><button class="btn btn-danger btn-sm" onclick="process(<?php echo $payment["id"]; ?>, 'reject')"><?php echo lang("reject"); ?></button></td>
          </tr>
          <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  <script>
  function process(id, type) {
    $.post("./admin/"+type+"-payment", {"id":id, "<?php echo $csrf["name"]; ?>":"<?php echo $csrf["hash"]; ?>"}, function(data) {
      if(data.success) {
        toastr.success(data.message);
        setTimeout(() => {
          window.location.href = "./admin";
        }, 2500);
      }
    });
  }
  </script>