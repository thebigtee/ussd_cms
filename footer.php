

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js">
</script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!--bootstrap datetimepicker  -->
<script src="bootstrap/js/bootstrap-datetimepicker.min.js"></script>
<!-- page script -->
    <script>
      $(function () {
        $("#example1").DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
// Confirmation to Delete
    $('.confirmation').on('click', function () {
        return confirm('Are you sure?');
    });
    </script>
    <!-- Page script -->
<script>
  $(function () {
    $('.DatetimeGame').datetimepicker({
      format: "YYYY-MM-D HH:mm:ss"
    });
    // Fixtures Magic
    var teams = '<?php echo($teams_output);?>';
    $("#PNFixtures").change(function(){
      var num_of_fixtures = $("#PNFixtures").val();
      $('#fixtureBlock').empty();
      for( var i=1; i <= num_of_fixtures; i++){
        $("#fixtureBlock").append("<div class=\"fixtureRow\">" +
         "<div class=\"row\">" +
         "<div class=\"col-sm-2 col-xs-2\">" +
         "<div class=\"form-group\">" +
         "<select name=\"HTName"+i+"\"class=\"form-control TeamHomeId\"" +
         "title=\"Home Team\" placeholder=\"Home Team\">" +
         "<option>---Select Team---</option>" +
         teams +
         "</select>" +
         "</div>" +
         "</div>" +
         "<div class=\"col-md-1\">" +
         "<div class=\"form-group\">" +
         "<input name=\"HTScore"+i+"\"type=\"text\"" +
         "class=\"form-control ScoreHome\" " +
         "title=\"Home Team Score\" placeholder=\"Home Team Score\">" +
         "</div>" +
         "</div>" +
         "<div class=\"col-md-2\">" +
         "<div class=\"form-group\">" +
         "<select name=\"ATName"+i+"\" class=\"form-control TeamAwayId\" title=\"Away Team\" placeholder=\"Away Team\">" +
         "<option value=\"\">---Select Team---</option>" +
              teams +
         "</select>" +
         "</div>" +
         "</div>" +
         "<div class=\"col-md-1\">" +
         "<div class=\"form-group \">" +
         "<input name=\"ATScore"+i+"\" type=\"text\" class=\"form-control ScoreAway\" title=\"Away Team Score\" placeholder=\"Away Team Score\">" +
         "</div>" +
         "</div>" +
         "<div class=\"col-md-2\">" +
         "<div class=\"form-group\">" +
         "<input name=\"FxDate"+i+"\" id=\"FxDate"+i+"\" type=\"text\" class=\"form-control DatetimeGame\" title=\"Game Date\" placeholder=\"Game Date\">" +
         "</div>" +
         "</div>" +
         "<div class=\"col-md-2\">" +
         "<div class=\"form-group\">" +
         "<select name=\"FxOut"+i+"\" class=\"form-control Outcome\" title=\"Outcome\" placeholder=\"Outcome\">" +
         "<option value=\"0\">Select</option>" +
         "<option value=\"1\">Home Win</option>" +
         "<option value=\"2\">Draw</option>" +
         "<option value=\"3\">Away Win</option>" +
         "</select>" +
         "</div>" +
         "</div>" +
         "<div class=\"col-md-2\">" +
         "<div class=\"form-group\">" +
         "<input name=\"FxComm"+i+"\" type=\"text\" class=\"form-control Comment\" title=\"Comment\" placeholder=\"Comment\">" +
         "</div>" +
         "</div>" +
         "</div>" +
         "</div>").show("slow");
      }
      $('.DatetimeGame').datetimepicker({
        format: "YYYY-MM-D HH:mm:ss"
      });
    });


  });

</script>
      </body>
</html>
