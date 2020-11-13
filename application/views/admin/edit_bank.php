<div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark "><?php echo lang("editBank"); ?></h2>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="pb-5">
    <div class="container mt-4" data-aos="fade">
    <form class="ajaxForm" action="./admin/edit-bank" method="post" enctype="multipart/form-data" data-redirect="./admin/banks/<?php echo $bank["id"]; ?>" data-loading="<?php echo lang("pleaseWait"); ?>" data-loading-button="submitBtn">
    <input type="hidden" name="id" value="<?php echo $bank["id"]; ?>">
    <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("bankName"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" value="<?php echo $bank["bank_name"]; ?>" type="text" class="form-control" name="bank_name" placeholder="<?php echo lang("enterBankName"); ?>" required>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("bankOwner"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" value="<?php echo $bank["name"]; ?>" type="text" class="form-control" name="name" placeholder="<?php echo lang("enterBankOwner"); ?>" required>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("bankNumber"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" value="<?php echo $bank["number"]; ?>" type="text" class="form-control" name="number" placeholder="<?php echo lang("enterBankNumber"); ?>" required>
      </div>
    </div>
    <div class="row my-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("bankImage"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" type="file" class="form-control p-2" name="image" accept="image/*">
        <small><?php echo lang("keepEmptyText"); ?></small>
      </div>
    </div>
    <button id="submitBtn" type="submit" class="btn btn-primary"><?php echo lang("submit"); ?></button>
    <button class="btn btn-danger" type="button" onclick="$('#deleteForm').submit();"><?php echo lang("deleteBank"); ?></button>
  </form>
  <form class="ajaxForm" id="deleteForm" action="./admin/delete-bank" data-redirect="./admin/banks" method="POST">
  <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
  <input type="hidden" name="id" value="<?php echo $bank["id"]; ?>">
  </form>  
    </div>
  </div>
  <script src="assets/js/ajaxform.js"></script>