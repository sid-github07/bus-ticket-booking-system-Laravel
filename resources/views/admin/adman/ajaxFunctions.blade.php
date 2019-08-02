<script>
  function showHide(e, id) {
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
        url: '{{route('admin.ad.hide')}}',
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        success: function(data) {
          console.log(data);
          if (data == "success") {
            document.getElementById('hideShowBtn'+id).innerHTML = 'Show';
            document.getElementById('hideShowBtn'+id).setAttribute('class', 'btn btn-sm btn-success');
          }
          if (data != "success") {
            swal('Sorry!', 'This is Demo version. You can not change anything.', 'error');
          }
        }
      });
    } else {
      document.getElementById('hideShowBtn'+id).innerHTML = '<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>';

      $.ajax({
        url: '{{route('admin.ad.show')}}',
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        success: function(data) {
          console.log(data);
          if (data == "success") {
            document.getElementById('hideShowBtn'+id).innerHTML = 'Hide';
            document.getElementById('hideShowBtn'+id).setAttribute('class', 'btn btn-sm btn-danger');
          }
          if (data != "success") {
            swal('Sorry!', 'This is Demo version. You can not change anything.', 'error');
          }
        }
      });
    }

  }
</script>

<script>
function changePublishStatus(e, id) {
  console.log(id);
  var publishStatus;
  if (e.target.innerHTML == 'Publish') {
    document.getElementById('publishStatusBtn'+id).innerHTML = 'Unpublish';
    document.getElementById('publishStatusBtn'+id).setAttribute('class', 'btn btn-warning btn-sm');
    publishStatus = 1;
  } else {
    document.getElementById('publishStatusBtn'+id).innerHTML = 'Publish';
    document.getElementById('publishStatusBtn'+id).setAttribute('class', 'btn btn-info btn-sm');
    publishStatus = 0;
  }
  var fd = new FormData();
  fd.append('id', id);
  fd.append('publishStatus', publishStatus);
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  document.getElementById('publishStatusBtn'+id).innerHTML = '<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>';

  $.ajax({
    url: '{{route('admin.ad.publish')}}',
    type: 'POST',
    data: fd,
    contentType: false,
    processData: false,
    success: function(data) {
      console.log(data);
      if (data == "success") {
        if(publishStatus == 1) {
          document.getElementById('publishStatusBtn'+id).innerHTML = 'Unpublish';
        } else {
          document.getElementById('publishStatusBtn'+id).innerHTML = 'Publish';
        }
      }
      if(data != "success") {
        swal('Sorry!', 'This is Demo version. You can not change anything.', 'error');
      }
    }
  });
}
</script>
