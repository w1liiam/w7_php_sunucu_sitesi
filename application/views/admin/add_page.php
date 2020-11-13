<div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark "><?php echo lang("addPage"); ?></h2>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="pb-5">
    <div class="container mt-4" data-aos="fade">
    <form class="ajaxForm" action="./admin/add-page" method="post" enctype="multipart/form-data" data-redirect="./admin/pages" data-loading="<?php echo lang("pleaseWait"); ?>" data-loading-button="submitBtn">
    <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
    <div class="row">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("pageName"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" value="" type="text" class="form-control" name="name" placeholder="<?php echo lang("enterPageName"); ?>" required>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("pageDesc"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" value="" type="text" class="form-control" name="description" placeholder="<?php echo lang("enterPageDesc"); ?>">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("pageTags"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" value="" type="text" class="form-control" name="tags" placeholder="<?php echo lang("enterPageTags"); ?>">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("pageMenu"); ?>:</h5>
        <select name="menu" class="form-control">
          <option value="1"><?php echo lang("yes"); ?></option>
          <option value="0"><?php echo lang("no"); ?></option>
        </select>
      </div>
    </div>
    <div class="row my-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("pageContent"); ?>:</h5>
        <textarea name="content" id="content" class="form-control"></textarea>
      </div>
    </div>
    <button id="submitBtn" type="submit" class="btn btn-primary mt-3"><?php echo lang("submit"); ?></button>
    </form>
    </div>
  </div>
  <script src="assets/js/ajaxform.js"></script>
  <script src="assets/ckeditor/ckeditor.js"></script>
  <script>CKEDITOR.replace("content");</script>