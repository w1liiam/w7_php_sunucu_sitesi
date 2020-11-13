  <div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark "><?php echo sprintf(lang("categoryText"), $category["name"]); ?></h2>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="py-5">
    <div class="container">
      <div class="row align-items-center" data-aos="fade">
        <div class="col-lg"></div>
        <div class="col-auto">
        <?php if($this->session->has_userdata("user")): ?>
        <button class="btn btn-primary" data-toggle="modal" data-target="#bulkModal" style="height: calc(2.25rem + 2px);padding: .45rem 1rem;"><?php echo lang("bulkBuy"); ?></button>
        <?php endif; ?>
        </div>
        </div>
        <div class="table-responsive mt-3" data-aos="fade">
            <table class="table table-striped">
                <thead>
                    <td>ID</td>
                    <td><?php echo lang("creationDate"); ?></td>
                    <td><?php echo lang("howManyDays"); ?></td>
                    <td><?php echo lang("mobileVerification"); ?></td>
                    <td><?php echo lang("price"); ?></td>
                    <td><?php echo lang("action"); ?></td>
                </thead>
                <tbody>
                <?php if($results != null): ?>
                    <?php foreach($results as $result): ?>
                    <tr>
                    <td><?php echo $result["id"]; ?></td>
                    <td><?php echo date("d/m/Y", $result["created_date"]); ?></td>
                    <td><?php echo $result["days"] == 0 ? lang("limitless") : $result["days"]; ?></td>
                    <td><?php echo $result["verified"] == 1 ? lang("yes") : lang("no"); ?></td>
                    <td><?php echo $result["price"]; ?> <?php echo $this->config->item("site_money_sign"); ?></td>
                    <td><button onclick="showDetails('<?php echo rawurlencode($result["details"]); ?>')" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo lang("details"); ?>"><i class="fas fa-eye"></i></button> <button class="btn btn-danger btn-sm" onclick="buyAccount(<?php echo $result["id"]; ?>,<?php echo $result["price"]; ?>)"><i class="fas fa-check mr-2"></i><?php echo lang("buy"); ?></button></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                    <td colspan="6"><?php echo lang("noAccountsStock"); ?></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            <p><?php echo $links; ?></p>
        </div>
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
  <div class="modal fade" id="confirmModal" role="dialog">
    <div class="modal-dialog">
          <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><?php echo lang("areYouSure"); ?></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p></p>
        </div>
        <div class="modal-footer">
          <button id="confirmButton" data-wait="<?php echo lang("pleaseWait"); ?>" type="button" class="btn btn-info"><?php echo lang("yes"); ?></button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo lang("no"); ?></button>
        </div>
      </div> 
    </div>
  </div>
  <div class="modal fade" id="bulkModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><?php echo lang("bulkBuy"); ?></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form id="bulkForm" action="./buy-bulk/price" method="post" data-category="<?php echo $category["id"]; ?>">
        <div class="modal-body">
          <h5 class="text-secondary"><?php echo lang("accountCount"); ?>:</h5>
          <input type="number" style="height: calc(2.25rem + 12px);" id="bulkCount" required="" min="1" class="form-control">
        </div>
        <div class="modal-footer">
          <button type="submit" data-wait="<?php echo lang("pleaseWait"); ?>" type="button" class="btn btn-info"><?php echo lang("bulkBuy"); ?></button>
        </div>
        </form>
      </div> 
    </div>
  </div>
  <script>

  var confirmButtonText = $("#confirmButton").text();
  function showDetails(details) {
    $("#detailsModal p").html(decodeURIComponent(details));
    $("#detailsModal").modal("show");
  }
  $("#confirmButton").click(function() {
    $("#confirmButton").text($("#confirmButton").data("wait"));
    $("#confirmButton").attr("disabled", "disabled");
    if($("#confirmButton").data("type") == 0) {
      $.post("./buy-account", {"id": $("#confirmButton").data("id"), "<?php echo $csrf["name"]; ?>":"<?php echo $csrf["hash"]; ?>"}, function(data) {
        $("#confirmButton").text(confirmButtonText);
        $("#confirmButton").attr("disabled", false);
        $("#confirmModal").modal("hide");
        if(data.success) {
          toastr.success(data.message);
          setTimeout(() => {
            window.location.href = "./my-accounts";
          }, 2500);
        }
        else {
          toastr.error(data.message);
        }
      });
    }
    else {
      $.post("./buy-bulk", {"category": $("#bulkModal form").data("category"), "piece": $("#confirmButton").data("piece"), "<?php echo $csrf["name"]; ?>":"<?php echo $csrf["hash"]; ?>"}, function(data) {
        $("#confirmButton").text(confirmButtonText);
        $("#confirmButton").attr("disabled", false);
        $("#confirmModal").modal("hide");
        if(data.success) {
          toastr.success(data.message);
          setTimeout(() => {
            window.location.href = "./my-accounts";
          }, 2500);
        }
        else {
          toastr.error(data.message);
        }
      });
    }
  });
  function buyAccount(id, price) {
    <?php if($this->session->has_userdata("user")): ?>
    var buyConfirmText = "<?php echo sprintf(lang("buyConfirmText"), $this->config->item("site_money_sign")); ?>";
    $("#confirmModal p").text(buyConfirmText.replace("(PRICE)", price));
    $("#confirmButton").attr("data-id", id);
    $("#confirmButton").attr("data-type", 0);
    $("#confirmModal").modal("show");
    <?php else: ?>
    toastr.warning('<?php echo lang("needLoginText"); ?>');
    <?php endif; ?>
  }
  var btnBulkText = $("#bulkForm button").text();
  $("#bulkForm").submit(function(e) {
      e.preventDefault();
      var form = $(this);
      $("#bulkForm button").attr("disabled","");
      $("#bulkForm button").text($("#bulkForm button").data("wait"));
      $.post("./buy-bulk/price", {"category":$(this).data("category"), "piece":parseInt($("#bulkCount").val()), "<?php echo $csrf["name"]; ?>":"<?php echo $csrf["hash"]; ?>"}, function(data) {
        if(data.success) {
          $("#confirmModal p").text(data.message);
          $("#confirmButton").attr("data-piece", parseInt($("#bulkCount").val()));
          $("#confirmButton").attr("data-type", 1);
          $("#confirmModal").modal("show");
        }
        else {
          toastr.error(data.message);
        }
        $("#bulkForm button").attr("disabled",false);
        $("#bulkForm button").text(btnBulkText);
        $("#bulkModal").modal("hide");
      });
  });
  </script>