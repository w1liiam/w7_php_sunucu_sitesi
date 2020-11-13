<div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark "><?php echo lang("supportTickets"); ?></h2>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="py-5">
    <div class="container">
        <div class="row align-items-center" data-aos="fade">
        <div class="col-lg"></div>
        <div class="col-auto mb-3">
        <button class="btn btn-primary" data-toggle="modal" data-target="#ticketModal" style="height: calc(2.25rem + 2px);padding: .45rem 1rem;"><?php echo lang("newSupportTicket"); ?> <i class="fas fa-comment ml-2"></i></button>
        </div>
        </div>
        <div class="table-responsive" data-aos="fade">
            <table class="table table-striped">
                <thead>
                    <td>ID</td>
                    <td><?php echo lang("ticketTitle"); ?></td>
                    <td><?php echo lang("date"); ?></td>
                    <td><?php echo lang("status"); ?></td>
                    <td><?php echo lang("action"); ?></td>
                </thead>
                <tbody>
                <?php if($results != null): ?>
                    <?php foreach($results as $result): ?>
                    <tr>
                    <td><?php echo $result["id"]; ?></td>
                    <td><?php echo strlen($result["title"]) > 25 ? substr($result["title"], 0, 22)."..." : $result["title"]; ?></td>
                    <td><?php echo date("d/m/Y H:i", $result["time"]); ?></td>
                    <td><?php
                    switch($result["status"]) {
                      case 0:
                        echo "<span class='badge badge-info'>".lang("ticketWaiting")."</span>";
                      break;
                      case 1:
                        echo "<span class='badge badge-success'>".lang("ticketAnswered")."</span>";
                      break;
                      case -1:
                        echo "<span class='badge badge-danger'>".lang("ticketClosed")."</span>";
                      break;
                    }
                    ?></td>
                    <td><a href="./support/<?php echo $result["id"]; ?>"><button class="btn btn-info btn-sm"><i class="fas fa-eye mr-1"></i><?php echo lang("view"); ?></button></a></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                    <td colspan="6"><?php echo lang("noSupportTickets"); ?></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            <p><?php echo $links; ?></p>
        </div>
    </div>
  </div>
  <div class="modal fade" id="ticketModal" role="dialog">
    <div class="modal-dialog">
          <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><?php echo lang("newSupportTicket"); ?></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        <form class="ajaxForm" action="./new-ticket" method="POST" data-loading="<?php echo lang("pleaseWait"); ?>" data-loading-button="submitBtn">
          <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
          <div>
          <span><?php echo lang("ticketTitle"); ?>:</span>
          <input type="text" class="form-control" name="title" required>
          </div>
          <div class="mt-2">
          <span><?php echo lang("ticketMessage"); ?>:</span>
          <textarea type="text" class="form-control" name="message" required></textarea>
          </div>
          <button id="submitBtn" type="submit" class="mt-2 btn btn-primary"><?php echo lang("create"); ?></button>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo lang("close"); ?></button>
        </div>
      </div>
      
    </div>
  </div>
  <script src="assets/js/ajaxform.js"></script>