<div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark "><?php echo lang("paymentNotifications"); ?></h2>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="pb-5">
    <div class="container mt-4" data-aos="fade">
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
          <?php if($payment_notifications !== false): ?>
          <?php foreach($payment_notifications as $payment): ?>
          <tr>
          <td><?php echo $payment["id"]; ?></td>
          <td><?php echo $payment["name"]; ?></td>
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
          <td>
          <?php if($payment["status"] == 0): ?>
          <button class="btn btn-info btn-sm mr-2" onclick="process(<?php echo $payment["id"]; ?>, 'approve')"><?php echo lang("approve"); ?></button><button class="btn btn-danger btn-sm" onclick="process(<?php echo $payment["id"]; ?>, 'reject')"><?php echo lang("reject"); ?></button></td>
          <?php elseif($payment["status"] == 1): ?>
          <span class="badge badge-success"><?php echo lang("paymentNotificationConfirmed"); ?></span>
          <?php else: ?>
          <span class="badge badge-danger"><?php echo lang("paymentNotificationRejected"); ?></span>
          <?php endif; ?>
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
          window.location.href = "./admin/payments";
        }, 2500);
      }
    });
  }
  </script>