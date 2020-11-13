<div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark "><?php echo lang("categories"); ?></h2>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="pb-5">
    <div class="container mt-4" data-aos="fade">
      <a href="./admin/categories/add"><button class="btn btn-primary mb-3 mb-md-0" style="height: calc(2.25rem + 2px);padding: .45rem 1rem;"><?php echo lang("addCategory"); ?></button></a>
      <table class="table dataTable table-striped w-100">
        <thead>
          <td>ID</td>
          <td><?php echo lang("category_name"); ?></td>
          <td><?php echo lang("status"); ?></td>
          <td><?php echo lang("action"); ?></td>
        </thead>
        <tbody>
          <?php if($categories !== false): ?>
          <?php foreach($categories as $category): ?>
          <tr>
          <td><?php echo $category["id"]; ?></td>
          <td><?php echo $category["name"]; ?></td>
          <td><?php echo $category["active"] == 1 ? lang("active") : "deactive"; ?></td>
          <td><a href="./admin/categories/<?php echo $category["id"]; ?>"><button class="btn btn-sm btn-info"><i class="fas fa-edit mr-2"></i><?php echo lang("edit"); ?></button></a></td>
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