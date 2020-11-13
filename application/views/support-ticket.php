<style>.message img {width:40px;height:40px;}.message small {opacity:.5}.message .rounded {border-radius: 1.2rem!important;}</style>
<div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark "><?php echo sprintf(lang('supportTicket'), $ticket['title']); ?></h2>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="py-5">
    <div class="container" data-aos="fade">
    <?php foreach($ticket_messages as $message): ?>
    <?php if($message["user"] != 0): ?>
      <div class="row mb-5 message">
        <div class="col px-2">
        <div class="bg-light text-dark rounded p-3">
        <p><?php echo htmlentities($message["message"]); ?></p>
        <div class="row">
        <div class="col"><small><i class="far fa-clock mr-2"></i><?php echo date("d/m/Y H:i:s", $message["time"]); ?></small></div>
        <div class="col-auto"></div>
        </div>
        </div>
        </div>
        <div class="col-auto px-2">
        <img src="https://www.gravatar.com/avatar/<?php echo md5($user["email"]); ?>" class="rounded-circle">
        </div>
      </div>
    <?php else: ?>
      <div class="row mb-5 message">
        <div class="col-auto px-2">
        <img src="./assets/img/admin.png" class="rounded-circle">
        </div>
        <div class="col px-2">
        <div class="bg-primary text-light rounded p-3">
        <p><?php echo htmlentities($message["message"]); ?></p>
        <div class="row">
        <div class="col"></div>
        <div class="col-auto"><small><?php echo date("d/m/Y H:i:s", $message["time"]); ?> <i class="far fa-clock ml-1"></i></small></div>
        </div>
        </div>
        </div>
      </div>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php if($ticket["status"] != -1): ?>
    <form class="ajaxForm" action="./ticket-reply/<?php echo $ticket["id"]; ?>" method="post" class="mt-4" data-redirect="./support/<?php echo $ticket["id"]; ?>" data-loading="<?php echo lang("pleaseWait"); ?>" data-loading-button="submitBtn">
    <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
    <h5><?php echo lang("yourMessage"); ?>:</h5>
    <textarea name="message" class="form-control" placeholder="<?php echo lang("enterYourMessage"); ?>" required></textarea>
    <button id="submitBtn" type="submit" class="btn btn-primary mt-3"><?php echo lang("submit"); ?></button>
    </form>
    <?php else: ?>
    <div class="alert alert-danger"><?php echo lang("ticketClosedMessage"); ?></div>
    <?php endif; ?>
    </div>
  </div>
  <script src="assets/js/ajaxform.js"></script>