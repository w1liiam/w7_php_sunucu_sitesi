  <div style="height:70px;"></div>
  <div class="py-5">
    <div class="container overflow-x-hidden">
    <div class="row">
      <div class="col-md-4 p-2" data-aos="fade-right">
        <div class="shadow h-100 rounded bg-success text-light">
          <div class="row py-4 px-5 align-items-center">
            <div class="col p-0">
              <h4 class="font-bold text-light"><?php echo lang("yourBalance"); ?>:</h4>
              <h4 class="text-light"><?php echo $user["balance"]; ?> <?php echo $this->config->item("site_money_sign"); ?></h4>
            </div>
            <div><i class="fas fa-wallet fa-3x text-light"></i></div>
          </div>
        </div>
      </div>
      <div class="col-md-4 p-2" data-aos="fade">
        <div class="shadow h-100 rounded bg-warning text-light">
          <div class="row py-4 px-5 align-items-center">
            <div class="col p-0">
              <h4 class="font-bold text-light"><?php echo lang("boughtAccount"); ?>:</h4>
              <h4 class="text-light"><?php echo sprintf(lang("piece"), $account_count); ?></h4>
            </div>
            <div><i class="fas fa-list fa-3x text-light"></i></div>
          </div>
        </div>
      </div>
      <div class="col-md-4 p-2" data-aos="fade-left">
        <div class="shadow h-100 rounded bg-danger text-light">
          <div class="row py-4 px-5 align-items-center">
            <div class="col p-0">
              <h4 class="font-bold text-light"><?php echo lang("spendedAmount"); ?>:</h4>
              <h4 class="text-light"><?php echo $spended_amount; ?> <?php echo $this->config->item("site_money_sign"); ?></h4>
            </div>
            <div><i class="far fa-money-bill-alt fa-3x text-light"></i></div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
  <div class="pb-5" id="categories">
    <div class="container">
      <div class="mb-5" data-aos="fade"><h3 class="text-primary font-bold"><?php echo lang("accountCategories"); ?>:</h3></div>
      <?php if(count($categories) > 0): ?>
      <div class="row">
        <?php foreach($categories as $category): ?>
        <?php
        $link = base_url(url_title(convert_accented_characters($category["name"]), "dash", true)."-".strval($category["id"]));
        ?>
        <div class="col-md-4 mb-4">
          <div class="card shadow h-100 mb-0" data-aos="flip-left">
              <a href="<?php echo $link; ?>" class="link"><img class="card-img-top" style="width:100%;height:175px" src="<?php echo file_exists("assets/uploads/category-".strval($category["id"]).".jpg") ? "assets/uploads/category-".strval($category["id"]).".jpg" : "assets/uploads/default.jpg"; ?>"></a>
              <div class="px-3 py-4">
              <h5 class="font-medium" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><a href="<?php echo $link; ?>" class="link"><?php echo $category["name"]; ?></a></h5>
              <p class="m-t-20"><i class="fas fa-hand-point-right mr-2"></i><?php echo sprintf(lang("sellingAccountsText"), $category["unused_accounts_count"]); ?> </p>
              <p class="m-t-20 m-b-20"><i class="fas fa-hand-point-right mr-2"></i><?php echo sprintf(lang("selledAccountsText"), $category["accounts_count"]-$category["unused_accounts_count"]); ?></p>    
              <a href="<?php echo $link; ?>" class="link"><button class="btn btn-primary btn-sm"><?php echo lang("viewAccounts"); ?> <i class="fas fa-angle-right ml-1"></i></button></a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center"><?php echo lang("noCategoryFound"); ?></p>
      <?php endif; ?>
      </div>
    </div>
  </div>