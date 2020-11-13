<div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark "><?php echo lang("addBank"); ?></h2>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="pb-5">
    <div class="container mt-4" data-aos="fade">
    <form class="ajaxForm" action="./admin/add-bank" method="post" enctype="multipart/form-data" data-redirect="./admin/banks" data-loading="<?php echo lang("pleaseWait"); ?>" data-loading-button="submitBtn">
    <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
    <div class="row">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("bankName"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" value="" type="text" class="form-control" name="bank_name" placeholder="<?php echo lang("enterBankName"); ?>" required>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("bankOwner"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" value="" type="text" class="form-control" name="name" placeholder="<?php echo lang("enterBankOwner"); ?>" required>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("bankNumber"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" value="" type="text" class="form-control" name="number" placeholder="<?php echo lang("enterBankNumber"); ?>" required>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("bankImage"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" type="file" class="form-control p-2" name="image" accept="image/*" required>
      </div>
    </div>
    <button id="submitBtn" type="submit" class="btn btn-primary mt-3"><?php echo lang("submit"); ?></button>
    </form>
    </div>
  </div>
  <script src="assets/js/ajaxform.js"></script>