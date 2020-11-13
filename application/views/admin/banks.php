<div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark "><?php echo lang("bankAccounts"); ?></h2>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="pb-5">
    <div class="container mt-4" data-aos="fade">
    <a href="./admin/banks/add"><button class="btn btn-primary mb-3 mb-md-0" style="height: calc(2.25rem + 2px);padding: .45rem 1rem;"><?php echo lang("addBank"); ?></button></a>
      <table class="table dataTable table-striped w-100">
        <thead>
          <td>ID</td>
          <td><?php echo lang("bankName"); ?></td>
          <td><?php echo lang("bankOwner"); ?></td>
          <td><?php echo lang("action"); ?></td>
        </thead>
        <tbody>
          <?php if($banks !== false): ?>
          <?php foreach($banks as $bank): ?>
          <tr>
          <td><?php echo $bank["id"]; ?></td>
          <td><?php echo $bank["bank_name"]; ?></td>
          <td><?php echo $bank["name"]; ?></td>
          <td><a href="./admin/banks/<?php echo $bank["id"]; ?>"><button class="btn btn-sm btn-info"><i class="fas fa-edit mr-2"></i><?php echo lang("edit"); ?></button></a></td>
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