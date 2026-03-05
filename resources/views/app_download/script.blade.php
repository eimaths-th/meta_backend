<script>
  function formModal_app(route) {
    $.get(route, function (res) {
      $('#modal_form_content').empty();
      $('#modal_form_content').html(res);
      $('#modal_form').modal('show');

      $('.select2test').select2({
        maximumSelectionLength: 2,
        allowClear: true
      });
      $('.select2-paper_report').select2({
        allowClear: true
      });

      // $(".select3_single").select2({
      //     maximumSelectionLength: 1,
      //     // allowClear: true
      // });

      // $(".select2_multiple").select2({
      //     maximumSelectionLength: 2,
      //     //placeholder: "With Max Selection limit 4",
      //     allowClear: true
      // });
      // $(".timepicker").timepicker();
      // $(".timepicker").timepicker({
      //     timeFormat: 'H:mm', // Use 'H:mm' for 24-hour format
      //     interval: 15, // Set the time interval
      //     scrollbar: true // Enable the scrollbar for easier time selection
      // });

      // $("#datepicker-autoClose").datepicker({
      //     todayHighlight: true,
      //     autoclose: true
      // });
    });
  }
</script>
