<div class="bg-light">
      <div id="header" class="banner spacer">
          <div class="container overflow-x-hidden">
              <div class="row justify-content-center">
                  <div class="col-md-8 text-center" data-aos="fade">
                      <h2 class="title font-bold h2 text-dark "><?php echo lang("boughtAccounts"); ?></h2>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="py-5">
    <div class="container">
        <div class="row align-items-center" data-aos="fade">
        <div class="col-lg">
        <span><?php echo lang("filter"); ?>:</span>
        <form action="" method="GET" class="mb-3">
        <select onchange="this.parentNode.submit();" name="filter" class="form-control" style="width:auto;height: calc(2.25rem + 2px);padding:2px;">
          <option value="day" <?php echo $filter == "day" ? "selected" : ""; ?>><?php echo lang("filter_today"); ?></option>
          <option value="week" <?php echo $filter == "week" ? "selected" : ""; ?>><?php echo lang("filter_week"); ?></option>
          <option value="month" <?php echo $filter == "month" ? "selected" : ""; ?>><?php echo lang("filter_month"); ?></option>
          <option value="all" <?php echo $filter == "all" ? "selected" : ""; ?>><?php echo lang("filter_all"); ?></option>
        </select>
        </form>
        </div>
        <div class="col-auto mb-3 mb-lg-0">
        <button class="btn btn-primary" data-toggle="modal" data-target="#downloadModal" style="height: calc(2.25rem + 2px);padding: .45rem 1rem;"><?php echo lang("bulkDownload"); ?> <i class="fas fa-download"></i></button>
        </div>
        </div>
        <div class="table-responsive" data-aos="fade">
            <table class="table table-striped">
                <thead>
                    <td>ID</td>
                    <td><?php echo lang("category"); ?></td>
                    <td><?php echo lang("creationDate"); ?></td>
                    <td><?php echo lang("howManyDays"); ?></td>
                    <td><?php echo lang("mobileVerification"); ?></td>
                    <td><?php echo lang("action"); ?></td>
                </thead>
                <tbody>
                <?php if($results != null): ?>
                    <?php foreach($results as $result): ?>
                    <tr>
                    <td><?php echo $result["id"]; ?></td>
                    <td><?php echo $result["category_name"]; ?></td>
                    <td><?php echo date("d/m/Y", $result["created_date"]); ?></td>
                    <td><?php echo $result["days"] == 0 ? lang("limitless") : $result["days"]; ?></td>
                    <td><?php echo $result["verified"] == 1 ? lang("yes") : lang("no"); ?></td>
                    <td><button onclick="showDetails('<?php echo rawurlencode($result["details"]); ?>','<?php echo rawurlencode($result["email"]); ?>','<?php echo rawurlencode($result["password"]); ?>')" class="btn btn-info btn-sm"><i class="fas fa-eye mr-2"></i><?php echo lang("details"); ?></button></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                    <td colspan="6"><?php echo lang("noAccountsBought"); ?></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            <p><?php echo $links; ?></p>
        </div>
    </div>
  </div>
  <div class="modal fade" id="detailsModal" role="dialog">
    <div class="modal-dialog">
          <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><?php echo lang("accountDetails"); ?></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo lang("close"); ?></button>
        </div>
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="downloadModal" role="dialog">
    <div class="modal-dialog">
          <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><?php echo lang("bulkDownload"); ?></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p><?php echo lang("selectCategory"); ?>:</p>
          <form action="./bulk-download" method="POST" id="bulkDownload">
          <input type="hidden" name="<?php echo $csrf["name"]; ?>" value="<?php echo $csrf["hash"]; ?>" />
          <select name="category" class="form-control">
          <?php foreach($categories as $category): ?>
          <option value="<?php echo $category["id"]; ?>"><?php echo $category["name"]; ?></option>
          <?php endforeach; ?>
          </select>
          <p class="mt-3"><?php echo lang("downloadFilter"); ?>:</p>
          <select name="filter" class="form-control">
          <option value="day" <?php echo $filter == "day" ? "selected" : ""; ?>><?php echo lang("filter_today"); ?></option>
          <option value="week" <?php echo $filter == "week" ? "selected" : ""; ?>><?php echo lang("filter_week"); ?></option>
          <option value="month" <?php echo $filter == "month" ? "selected" : ""; ?>><?php echo lang("filter_month"); ?></option>
          <option value="all" <?php echo $filter == "all" ? "selected" : ""; ?>><?php echo lang("filter_all"); ?></option>
          </select>
          <button class="mt-3 btn btn-primary" type="submit"><?php echo lang("bulkDownload"); ?><i class="fas fa-download ml-2"></i></button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo lang("close"); ?></button>
        </div>
      </div>
    </div>
  </div>
  <script>

  var confirmButtonText = $("#confirmButton").text();
  function showDetails(details, email, password) {
    $("#detailsModal p").html(decodeURIComponent(details)+"<br/><hr/><b class='font-bold'><?php echo lang("emailOrUsername"); ?>:</b> "+decodeURIComponent(email)+"<br/><b class='font-bold'><?php echo lang("password"); ?>:</b> "+decodeURIComponent(password));
    $("#detailsModal").modal("show");
  }
  $("#bulkDownload").submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr("action");
    $.ajax({
        type: form.attr("method"),
        url: url,
        data: form.serialize(),
        success: function(data)
        {
            if(data != "") {
              data = $("select[name='category'] option:selected").text() + "\n\n" + data.replace(/<br\/>/g, "\n");
              var blob = new Blob([data], {type: 'text'});
              if(window.navigator.msSaveOrOpenBlob) {
                  window.navigator.msSaveBlob(blob, $("select[name='category'] option:selected").text()+'.txt');
              }
              else{
                  var e = window.document.createElement('a');
                  e.href = window.URL.createObjectURL(blob);
                  e.download = $("select[name='category'] option:selected").text()+'.txt';        
                  document.body.appendChild(e);
                  e.click();        
                  document.body.removeChild(e);
              }
            }
            else {
              toastr.error("<?php echo lang("noAccountsBought"); ?>");
            }
        }
        });
    });
  </script>