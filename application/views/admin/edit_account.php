<div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark "><?php echo lang("editAccount"); ?></h2>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="pb-5">
    <div class="container mt-4" data-aos="fade">
    <form class="ajaxForm" action="./admin/edit-account" method="post" enctype="multipart/form-data" data-redirect="./admin/categories/<?php echo $account["id"]; ?>" data-loading="<?php echo lang("pleaseWait"); ?>" data-loading-button="submitBtn">
    <input type="hidden" name="id" value="<?php echo $account["id"]; ?>">
    <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
    <div class="row">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("accountCategory"); ?>:</h5>
        <select name="category" class="form-control" required>
          <?php foreach($categories as $category): ?>
          <option value="<?php echo $category["id"]; ?>" <?php echo $account["category"] == $category["id"] ? "selected" : ""; ?>><?php echo $category["name"]; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("accountDate"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" type="date" value="<?php echo date("Y-m-d", $account["created_date"]); ?>" class="form-control p-2" name="date">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("accountDays"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" type="number" value="<?php echo $account["days"]; ?>" class="form-control p-2" name="days" required>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("mobileVerification"); ?>:</h5>
        <select name="verified" class="form-control" required>
          <option value="0" <?php echo $account["verified"] == 0 ? "selected" : ""; ?>><?php echo lang("no"); ?></option>
          <option value="1" <?php echo $account["verified"] == 1 ? "selected" : ""; ?>><?php echo lang("yes"); ?></option>
        </select>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("accountEmail"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" type="text" value="<?php echo $account["email"]; ?>" class="form-control p-2" name="email" required>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("accountPassword"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" type="text" value="<?php echo $account["password"]; ?>" class="form-control p-2" name="password" required>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("accountPrice"); ?>:</h5>
        <input style="height: calc(2.25rem + 12px);" type="number" step="any" value="<?php echo $account["price"]; ?>" class="form-control p-2" name="price" required>
      </div>
    </div>
    <div class="row my-3">
      <div class="col-md-12">
        <h5 class="text-secondary"><?php echo lang("accountDetails"); ?>:</h5>
        <textarea name="details" style="height:100px" class="form-control" placeholder="<?php echo lang("accountDetailsText"); ?>"><?php echo $account["details"]; ?></textarea>
      </div>
    </div>

    <button id="submitBtn" type="submit" class="btn btn-primary"><?php echo lang("submit"); ?></button>
    <button class="btn btn-danger" type="button" onclick="$('#deleteForm').submit();"><?php echo lang("deleteAccount"); ?></button>
  </form>
  <form class="ajaxForm" id="deleteForm" action="./admin/delete-account" data-redirect="./admin/accounts" method="POST">
  <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
  <input type="hidden" name="id" value="<?php echo $account["id"]; ?>">
  </form>  
    </div>
  </div>
  <script src="assets/js/ajaxform.js"></script>