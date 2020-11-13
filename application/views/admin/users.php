<div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark "><?php echo lang("users"); ?></h2>
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
          <td><?php echo lang("email"); ?></td>
          <td><?php echo lang("balance"); ?></td>
          <td><?php echo lang("action"); ?></td>
        </thead>
        <tbody>
          <?php if($users !== false): ?>
          <?php foreach($users as $user): ?>
          <tr>
          <td><?php echo $user["id"]; ?></td>
          <td><?php echo $user["name"]; ?></td>
          <td><?php echo $user["email"]; ?></td>
          <td><?php echo sprintf("%s %s", $user["balance"], $this->config->item("site_money_sign")); ?></td>
          <td><a href="./admin/users/<?php echo $user["id"]; ?>"><button class="btn btn-sm btn-info"><i class="fas fa-edit mr-2"></i><?php echo lang("edit"); ?></button></a></td>
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