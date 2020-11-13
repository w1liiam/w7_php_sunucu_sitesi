<div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark "><?php echo lang("pages"); ?></h2>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="pb-5">
    <div class="container mt-4" data-aos="fade">
      <a href="./admin/pages/add"><button class="btn btn-primary mb-3 mb-md-0" style="height: calc(2.25rem + 2px);padding: .45rem 1rem;"><?php echo lang("addPage"); ?></button></a>
      <table class="table dataTable table-striped w-100">
        <thead>
          <td>ID</td>
          <td><?php echo lang("pageName"); ?></td>
          <td><?php echo lang("pageMenu"); ?></td>
          <td><?php echo lang("action"); ?></td>
        </thead>
        <tbody>
          <?php if($pages !== false): ?>
          <?php foreach($pages as $page): ?>
          <tr>
          <td><?php echo $page["id"]; ?></td>
          <td><?php echo $page["name"]; ?></td>
          <td><?php echo $page["menu"] == 1 ? lang("yes") : lang("no"); ?></td>
          <td><a href="./p/<?php echo $page["slug"]; ?>"><button class="btn btn-sm btn-danger mr-2" data-toggle="tooltip" data-placement="top" title="<?php echo lang("view"); ?>"><i class="fas fa-eye"></i></button></a><a href="./admin/pages/<?php echo $page["id"]; ?>"><button class="btn btn-sm btn-info"><i class="fas fa-edit mr-2"></i><?php echo lang("edit"); ?></button></a></td>
          </tr>
          <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>