<div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark "><?php echo lang("editCategory"); ?></h2>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="pb-5">
    <div class="container mt-4" data-aos="fade">
    <form class="ajaxForm" action="./admin/edit-category" method="post" enctype="multipart/form-data" data-redirect="./admin/categories/<?php echo $category["id"]; ?>" data-loading="<?php echo lang("pleaseWait"); ?>" data-loading-button="submitBtn">
    <input type="hidden" name="id" value="<?php echo $category["id"]; ?>">
    <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
    <div class="row">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("categoryName"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" value="<?php echo htmlentities($category["name"]); ?>" type="text" class="form-control" name="name" placeholder="<?php echo lang("enterCategoryName"); ?>" required>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("categoryStatus"); ?>:</h5>
        <select name="active" class="form-control">
          <option value="1" <?php echo $category["active"] == 1 ? "selected" : ""; ?>><?php echo lang("active"); ?></option>
          <option value="0" <?php echo $category["active"] == 0 ? "selected" : ""; ?>><?php echo lang("deactive"); ?></option>
        </select>
      </div>
    </div>
    <div class="row my-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("categoryImage"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" type="file" class="form-control p-2" name="image" accept="image/*">
        <small><?php echo lang("keepEmptyText"); ?></small>
      </div>
    </div>
    <button id="submitBtn" type="submit" class="btn btn-primary"><?php echo lang("submit"); ?></button>
    <button class="btn btn-danger" type="button" onclick="$('#deleteForm').submit();"><?php echo lang("deleteCategory"); ?></button>
  </form>
  <form class="ajaxForm" id="deleteForm" action="./admin/delete-category" data-redirect="./admin/categories" method="POST">
  <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
  <input type="hidden" name="id" value="<?php echo $category["id"]; ?>">
  </form>  
    </div>
  </div>
  <script src="assets/js/ajaxform.js"></script>