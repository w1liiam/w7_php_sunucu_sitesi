<div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark "><?php echo lang("addAccount"); ?></h2>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="pb-5">
    <div class="container mt-4" data-aos="fade">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="single-tab" data-toggle="tab" href="#single" role="tab" aria-controls="single" aria-selected="true"><?php echo lang("addSingle"); ?></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="bulk-tab" data-toggle="tab" href="#bulk" role="tab" aria-controls="bulk" aria-selected="false"><?php echo lang("addBulk"); ?></a>
    </li>
    </ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="single" role="tabpanel" aria-labelledby="single-tab">
  <form class="mt-4 ajaxForm" action="./admin/add-account" method="post" enctype="multipart/form-data" data-redirect="./admin/accounts" data-loading="<?php echo lang("pleaseWait"); ?>" data-loading-button="submitBtn">
    <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
    <div class="row">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("accountCategory"); ?>:</h5>
        <select name="category" class="form-control" required>
          <?php foreach($categories as $category): ?>
          <option value="<?php echo $category["id"]; ?>"><?php echo $category["name"]; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("accountDate"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control p-2" name="date">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("accountDays"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" type="number" value="0" class="form-control p-2" name="days" required>
        <small><?php echo lang("accountDaysText"); ?></small>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("mobileVerification"); ?>:</h5>
        <select name="verified" class="form-control" required>
          <option value="0"><?php echo lang("no"); ?></option>
          <option value="1"><?php echo lang("yes"); ?></option>
        </select>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("accountEmail"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" type="text" value="" class="form-control p-2" name="email" required>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("accountPassword"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" type="text" value="" class="form-control p-2" name="password" required>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("accountPrice"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" type="number" step="any" value="" class="form-control p-2" name="price" required>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("accountDetails"); ?>:</h5>
        <textarea name="details" style="height:100px" class="form-control" placeholder="<?php echo lang("accountDetailsText"); ?>"></textarea>
      </div>
    </div>
    <button id="submitBtn" type="submit" class="btn btn-primary mt-3"><?php echo lang("submit"); ?></button>
    </form>
  </div>
  <div class="tab-pane fade" id="bulk" role="tabpanel" aria-labelledby="bulk-tab">
  <form class="mt-4 ajaxForm" action="./admin/add-accounts" method="post" enctype="multipart/form-data" data-redirect="./admin/accounts" data-loading="<?php echo lang("pleaseWait"); ?>" data-loading-button="submitBtn">
    <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
    <div class="alert alert-info"><?php echo lang("bulkAccountInfo"); ?></div>
    <div class="row">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("accountCategory"); ?>:</h5>
        <select name="category" class="form-control" required>
          <?php foreach($categories as $category): ?>
          <option value="<?php echo $category["id"]; ?>"><?php echo $category["name"]; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("accountDate"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" type="date" value="<?php echo date("Y-m-d"); ?>" class="form-control p-2" name="date">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("accountDays"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" type="number" value="0" class="form-control p-2" name="days" required>
        <small><?php echo lang("accountDaysText"); ?></small>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("mobileVerification"); ?>:</h5>
        <select name="verified" class="form-control" required>
          <option value="0"><?php echo lang("no"); ?></option>
          <option value="1"><?php echo lang("yes"); ?></option>
        </select>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("accountsData"); ?>:</h5>
        <textarea name="data" style="height:100px" class="form-control" placeholder="<?php echo lang("bulkAccountText"); ?>"></textarea>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("accountPrice"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" type="number" step="any" value="" class="form-control p-2" name="price" required>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("accountDetails"); ?>:</h5>
        <textarea name="details" style="height:100px" class="form-control" placeholder="<?php echo lang("accountDetailsText"); ?>"></textarea>
      </div>
    </div>
    <button id="submitBtn" type="submit" class="btn btn-primary mt-3"><?php echo lang("submit"); ?></button>
    </form>
  </div>
</div>
    </div>
  </div>
  <script src="assets/js/ajaxform.js"></script>