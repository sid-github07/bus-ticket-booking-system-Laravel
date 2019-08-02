@extends('admin.layout.master')

@push('nicedit-scripts')
  <script src="{{asset('assets/nic-edit/nicEdit.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
    bkLib.onDomLoaded(function() {
      new nicEditor({iconsPath : '{{asset('assets/nic-edit/nicEditorIcons.gif')}}', fullPanel : true}).panelInstance('overview');
      new nicEditor({iconsPath : '{{asset('assets/nic-edit/nicEditorIcons.gif')}}', fullPanel : true}).panelInstance('program_schedule');
    });
  </script>
@endpush

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>Add Package</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
           <div class="tile">

              <div class="row">
                <div class="col-md-12">
                  <form id="addpackageform" enctype="multipart/form-data" onsubmit="addpackage(event)">
                    {{csrf_field()}}
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for=""><strong>Package Name:</strong></label>
                          <input class="form-control" type="text" name="name" value="" placeholder="Enter Package Name">
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


                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for=""><strong>Per Person Price:</strong></label>
                          <div class="input-group mb-3">
                            <input type="text" class="form-control" name="price" value="" placeholder="Enter Per Person Price">
                            <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon2">{{$gs->base_curr_text}}</span>
                            </div>
                          </div>
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for=""><strong>Duration:</strong></label>
                          <div class="input-group mb-3">
                            <input type="text" name="duration" class="form-control" placeholder="Enter Tour Duration" aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon2">Days</span>
                            </div>
                          </div>
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                    </div>



                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for=""><strong>Minimum Number of Persons:</strong></label>
                          <input type="number" class="form-control" name="minimum_persons" value="" placeholder="Enter Minimum Number of Persons">
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for=""><strong>Maximum Number of Persons:</strong></label>
                          <input type="number" name="maximum_persons" class="form-control" placeholder="Enter Maximum Number of Persons">
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-md-12">
                        <label for=""><strong>Booking Date:</strong></label>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group">
                          <input class="form-control" type="date" name="start_date" value="">
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                      <div class="col-md-1 text-center">
                        <strong>till</strong>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group">
                          <input class="form-control" type="date" name="closing_date" value="">
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for=""><strong>Leaving From:</strong></label>
                          <input type="text" class="form-control" name="leaving_from" value="" placeholder="Enter The Starting Place of Tour ">
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for=""><strong>Leaving To:</strong></label>
                          <input type="text" name="leaving_to" class="form-control" placeholder="Enter Destination">
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for=""><strong>Overview: </strong></label>
                          <textarea id="overview" name="overview" rows="8" style="width:100%;padding-left:12px;" placeholder="Enter Package Overview"></textarea>
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for=""><strong>Program Schedule: </strong></label>
                          <textarea id="program_schedule" name="program_schedule" rows="10" style="width:100%;"></textarea>
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-info btn-block form-control-lg">ADD PACKAGE</button>
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
$(document).on('change', '#imgs', function(e) {
    if (this.files.length && imgs.length < 5) {
      el++;
      $("#imgtable").append('<tr class="trcl" id="tr'+(el-1)+'"><td><img class="preimgs"></td><td><button class="rmvbtn btn btn-danger" type="button" onclick="rmvimg('+(el-1)+')"><i class="fa fa-times"></i></button></td></tr>');
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

function addpackage(e) {

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
  var form = document.getElementById('addpackageform');
  var psElement = new nicEditors.findEditor('program_schedule');
  var overviewElement = new nicEditors.findEditor('overview');
  ps = psElement.getContent();
  overview = overviewElement.getContent();
  var fd = new FormData(form);
  for (var i = 0; i < imgs.length; i++) {
    fd.append('images[]', imgs[i]);
  }
  fd.append('program_schedule', ps);
  fd.append('overview', overview);
  $.ajax({
    url: '{{route('admin.package.store')}}',
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
        form.reset();
        psElement.setContent('');
        overviewElement.setContent('');
        $("#imgtable").remove();
        swal({
          title: "Success!",
          text: "Package added successfully!",
          icon: "success",
          button: "OK!",
        });
      }

      // Showing error messages in the HTML...
      if(typeof data.error != 'undefined') {
        if(typeof data.name != 'undefined') {
          em[0].innerHTML = data.name[0];
        }
        if(typeof data.images != 'undefined') {
          em[1].innerHTML = data.images[0];
        }
        if(typeof data.price != 'undefined') {
          em[2].innerHTML = data.price[0];
        }
        if(typeof data.duration != 'undefined') {
          em[3].innerHTML = data.duration[0];
        }
        if(typeof data.minimum_persons != 'undefined') {
          em[4].innerHTML = data.minimum_persons[0];
        }
        if(typeof data.maximum_persons != 'undefined') {
          em[5].innerHTML = data.maximum_persons[0];
        }
        if(typeof data.start_date != 'undefined') {
          em[6].innerHTML = data.start_date[0];
        }
        if(typeof data.closing_date != 'undefined') {
          em[7].innerHTML = data.closing_date[0];
        }
        if(typeof data.leaving_from != 'undefined') {
          em[8].innerHTML = data.leaving_from[0];
        }
        if(typeof data.leaving_to != 'undefined') {
          em[9].innerHTML = data.leaving_to[0];
        }
        if(typeof data.overview != 'undefined') {
          em[10].innerHTML = data.overview[0];
        }
        if(typeof data.program_schedule != 'undefined') {
          em[11].innerHTML = data.program_schedule[0];
        }
      }

    }
  });
}
</script>
@endpush
