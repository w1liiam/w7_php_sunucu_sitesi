  </main>
  <div class="py-3 px-3 px-lg-0 bg-primary text-white">
    <div class="container">
      <div class="row">
      <div class="col-lg p-0"><i class="far fa-copyright mr-2"></i><b><?php echo date("Y"); ?>. <?php echo lang("allRightsReserved"); ?>.</div>
      <div><i class="fas fa-code mr-2"></i><?php echo lang("softwareBy"); ?> <a class="text-white" href="tr/" rel="nofollow" target="_blank">orwell#0007</a></div>
      </div>
    </div>
  </div>

  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/theme.min.js"></script>
  <script src="assets/js/aos.min.js"></script>
  <script src="assets/js/toastr.min.js"></script>
  <script src="assets/js/jquery.dataTables.min.js"></script>
  <script src="assets/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/js/dataTables.responsive.min.js"></script>
  <script>AOS.init({once: true});toastr.options.progressBar = true;</script>
  <script>
  $(document).ready(function() {
    $('.dataTable').DataTable({
      bInfo: false,
      pageLength: 5,
      order: [[ 0, "desc" ]],
      responsive: true,
      lengthChange: false,
      oLanguage: {
        sSearch: "<?php echo lang("search"); ?>:",
        sZeroRecords: "<?php echo lang("noMatchingRecordsFound"); ?>"
      },
      language: {
      paginate: {
        previous: "<i class='fas fa-angle-double-left'></i>",
        next: "<i class='fas fa-angle-double-right'></i>"
      }
      }
    });
    $("a[data-toggle=\"tab\"]").on("shown.bs.tab", function (e) {
    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });
  });
  </script>
</body>
</html>