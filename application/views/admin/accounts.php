<div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark "><?php echo lang("sellingAccounts"); ?></h2>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="pb-5">
    <div class="container mt-4" data-aos="fade">
      <a href="./admin/accounts/add"><button class="btn btn-primary mb-3 mb-md-0" style="height: calc(2.25rem + 2px);padding: .45rem 1rem;"><?php echo lang("addAccount"); ?></button></a>
      <table class="table dataTable table-striped w-100">
        <thead>
          <td>ID</td>
          <td><?php echo lang("accountCategory"); ?></td>
          <td><?php echo lang("accountDate"); ?></td>
          <td><?php echo lang("mobileVerification"); ?></td>
          <td><?php echo lang("action"); ?></td>
        </thead>
        <tbody>
          <?php if($accounts !== false): ?>
          <?php foreach($accounts as $account): ?>
          <tr>
          <td><?php echo $account["id"]; ?></td>
          <td><?php echo $account["category_name"]; ?></td>
          <td><?php echo date("d/m/Y",$account["created_date"]); ?></td>
          <td><?php echo $account["verified"] == 1 ? lang("yes") : lang("no"); ?></td>
          <td><a href="./admin/accounts/<?php echo $account["id"]; ?>"><button class="btn btn-sm btn-info"><i class="fas fa-edit mr-2"></i><?php echo lang("edit"); ?></button></a></td>
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