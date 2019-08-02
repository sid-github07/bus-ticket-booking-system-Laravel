@extends('admin.layout.master')

@push('nicedit-scripts')
  <script src="{{asset('assets/nic-edit/nicEdit.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
    bkLib.onDomLoaded(function() {
      new nicEditor({iconsPath : '{{asset('assets/nic-edit/nicEditorIcons.gif')}}', fullPanel : true}).panelInstance('overview');
    });
  </script>
@endpush

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>Edit Pickup Car</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
           <div class="tile">

              <div class="row">
                <div class="col-md-12">
                  <form id="editpickupform" enctype="multipart/form-data" onsubmit="editpickup(event)">
                    {{csrf_field()}}

                    <input type="hidden" name="pickupid" value="{{$pickup->id}}">

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for=""><strong>Title:</strong></label>
                          <input class="form-control" type="text" name="title" value="{{$pickup->title}}" placeholder="Enter Pickup Car Title">
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                    </div>



                    <div class="row">
                      <div class="col-md-12">
                        <label for=""><strong>Preview Images:</strong></label>
                        <div class="">
                          <table class="table table-striped" id="imgtable">

                          </table>
                        </div>
                        <div class="form-group">
                          <label class="btn btn-info" style="width:100px;cursor:pointer;">
                            <input id="imgs" style="display:none;" type="file" />
                            <i class="fa fa-plus"></i> Add File
                          </label>
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                    </div>
                    <input type="hidden" name="imgs_helper" value="">



                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for=""><strong>Capacity (Number of adult persons):</strong></label>
                          <input class="form-control" type="number" name="capacity" value="{{$pickup->capacity}}" placeholder="Enter Number of Adult Persons">
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for=""><strong>Pickup Location (Airport Name):</strong></label>
                          <input class="form-control" type="text" name="pickup_location" value="{{$pickup->pickup_location}}" placeholder="Enter Location Name">
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                    </div>




                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for=""><strong>Overview: </strong></label>
                          <textarea id="overview" name="overview" rows="10" style="width:100%;">{{$pickup->overview}}</textarea>
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-info btn-block form-control-lg">UPDATE PICKUP CAR</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>

           </div>
        </div>
     </div>
  </main>
@endsection

@push('scripts')
<script>
  var el = 0;
  var imgs = [];
  var imgsdb = [];
  $(document).on('change', '#imgs', function(e) {
      if (this.files.length && (imgs.length+imgsdb.length) < 5) {
        el++;
        $("#imgtable").append('<tr class="trcl" id="tr'+(el-1)+'"><td><img class="preimgs thumbnail"></td><td><button class="rmvbtn btn btn-danger pull-right" type="button" onclick="rmvimg('+(el-1)+')"><i class="fa fa-times"></i></button></td></tr>');
        var file = this.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            var data = e.target.result;

            document.getElementsByClassName('preimgs')[el-1].setAttribute('src', data);
            document.getElementsByClassName('preimgs')[el-1].setAttribute('style', 'width:100px');
        };

        reader.readAsDataURL(file);
        imgs.push(file);
        console.log(imgs);
      }

  });

  function rmvimg(index) {
      $("#tr"+index).remove();
      imgs.splice(index, 1);
      console.log(imgs);
      var trcl = document.getElementsByClassName('trcl');
      var rmvbtn = document.getElementsByClassName('rmvbtn');
      for(el=0; el<trcl.length; el++) {
          trcl[el].setAttribute('id', 'tr'+el);
          rmvbtn[el].setAttribute('onclick', 'rmvimg('+el+')');
      }
  }

  $(document).ready(function(){
    setTimeout(function(){
      $.get("{{route('admin.pickupcar.imgs', $pickup->id)}}", function(data){
          for (var i = 0; i < data.length; i++) {
            imgsdb.push(data[i].image);
            $("#imgtable").append('<tr class="trdb" id="trdb'+i+'"><td width="100px"><div class="thumbnail"><img style="width:100px;" src="{{asset('assets/user/img/pickup_imgs/')}}/'+data[i].image+'" alt="Ad Image"></div></td><td><button type="button" class="btn btn-danger pull-right rmvbtndb" onclick="rmvdbimg('+i+')"><i class="fa fa-times"></i></button></td></tr>');
          }
          console.log(imgsdb);
      });
    },500)
  });

  function rmvdbimg(indb) {
    $("#trdb"+indb).remove();
    imgsdb.splice(indb, 1);
    console.log(imgsdb);
    var trdb = document.getElementsByClassName('trdb');
    var rmvbtndb = document.getElementsByClassName('rmvbtndb');
    for (var i = 0; i < rmvbtndb.length; i++) {
      trdb[i].setAttribute('id', 'trdb'+i);
      rmvbtndb[i].setAttribute('onclick', 'rmvdbimg('+i+')');
    }
  }

  function editpickup(e) {

    e.preventDefault();
    swal({
      title: "Checking...",
      text: "Please wait",
      icon: "{{asset('assets/user/img/ajaxloader/ajax-loading.gif')}}",
      buttons: false,
      closeOnClickOutside: false
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var form = document.getElementById('editpickupform');
    var overviewElement = new nicEditors.findEditor('overview');
    overview = overviewElement.getContent();
    var fd = new FormData(form);
    for (var i = 0; i < imgs.length; i++) {
      fd.append('images[]', imgs[i]);
    }
    for (var k = 0; k < imgsdb.length; k++) {
      fd.append('imgsdb[]', imgsdb[k]);
    }
    fd.append('overview', overview);
    $.ajax({
      url: '{{route('admin.pickupcar.update')}}',
      data: fd,
      type: 'POST',
      contentType: false,
      processData: false,
      success: function(data) {
        swal.close();
        console.log(data);

        var em = document.getElementsByClassName("em");
        for(i=0; i<em.length; i++) {
            em[i].innerHTML = '';
        }


        if(data == "success") {
          swal({
            title: "Success!",
            text: "Pickup Car updated successfully!",
            icon: "success",
            button: "OK!",
          });
        }

        // Showing error messages in the HTML...
        if(typeof data.error != 'undefined') {
          if(typeof data.title != 'undefined') {
            em[0].innerHTML = data.title[0];
          }
          if(typeof data.imgs_helper != 'undefined') {
            em[1].innerHTML = data.imgs_helper[0];
          }
          if(typeof data.capacity != 'undefined') {
            em[2].innerHTML = data.capacity[0];
          }
          if(typeof data.pickup_location != 'undefined') {
            em[3].innerHTML = data.pickup_location[0];
          }
          if(typeof data.overview != 'undefined') {
            em[4].innerHTML = data.overview[0];
          }
        }

      }
    });
  }
</script>
@endpush
