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
  <div class="pb-5">
    <div class="container mt-4" data-aos="fade">
      <table class="table dataTable table-striped w-100">
        <thead>
          <td>ID</td>
          <td><?php echo lang("user"); ?></td>
          <td><?php echo lang("ticketTitle"); ?></td>
          <td><?php echo lang("date"); ?></td>
          <td><?php echo lang("status"); ?></td>
          <td><?php echo lang("action"); ?></td>
        </thead>
        <tbody>
          <?php if($tickets !== false): ?>
          <?php foreach($tickets as $ticket): ?>
          <tr>
          <td><?php echo $ticket["id"]; ?></td>
          <td><?php echo $ticket["user_email"]; ?></td>
          <td><?php echo $ticket["title"]; ?></td>
          <td><?php echo date("d/m/Y H:i", $ticket["time"]); ?></td>
          <td><?php
          switch($ticket["status"]) {
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
          <td><a href="./admin/tickets/<?php echo $ticket["id"]; ?>"><button class="btn btn-sm btn-info"><i class="fas fa-eye mr-2"></i><?php echo lang("view"); ?></button></a></td>
          </tr>
          <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  <script>
  function process(id, type) {
    $.post("./admin/"+type+"-payment", {"id":id, "<?php echo $csrf["name"]; ?>":"<?php echo $csrf["hash"]; ?>"}, function(data) {
      if(data.success) {
        toastr.success(data.message);
        setTimeout(() => {
          window.location.href = "./admin";
        }, 2500);
      }
    });
  }
  </script>