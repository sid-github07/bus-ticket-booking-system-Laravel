<script>
  function showHideLounge(e, id) {
    console.log(id);
    console.log(e.target.innerHTML);
    var fd = new FormData();
    fd.append('id', id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if(e.target.innerHTML == 'Hide') {
      document.getElementById('hideShowBtn'+id).innerHTML = '<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>';

      $.ajax({
        url: '{{route('admin.lounge.hide')}}',
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        success: function(data) {
          console.log(data);
          if (data == "success") {
            document.getElementById('hideShowBtn'+id).innerHTML = 'Show';
            document.getElementById('hideShowBtn'+id).setAttribute('class', 'btn btn-success');
          }
          if (data != "success") {
            swal('Sorry!', 'This is Demo version. You can not change anything.', 'error');
          }
        }
      });
    } else {
      document.getElementById('hideShowBtn'+id).innerHTML = '<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>';

      $.ajax({
        url: '{{route('admin.lounge.show')}}',
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        success: function(data) {
          console.log(data);
          if (data == "success") {
            document.getElementById('hideShowBtn'+id).innerHTML = 'Hide';
            document.getElementById('hideShowBtn'+id).setAttribute('class', 'btn btn-danger');
          }
          if (data != "success") {
            swal('Sorry!', 'This is Demo version. You can not change anything.', 'error');
          }
        }
      });
    }

  }
</script>
