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
           <h1>Add Room</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
           <div class="tile">

              <div class="row">
                <div class="col-md-12">
                  <form id="addhotelform" enctype="multipart/form-data" onsubmit="addroom(event)">
                    {{csrf_field()}}
                    <input type="hidden" name="hotel_id" value="{{$hotel_id}}">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for=""><strong>Room Name:</strong></label>
                          <input class="form-control" type="text" name="name" value="" placeholder="Enter Room Name">
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
                          <label for=""><strong>No of Bed:</strong></label>
                          <input type="text" class="form-control" name="bed" placeholder="Enter no of beds">
                          <p class="no-margin em"></p>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for=""><strong>No of Bath:</strong></label>
                          <input type="text" class="form-control" name="bath" placeholder="Enter no of baths">
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                    </div>



                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for=""><strong>No of Persons (Adults):</strong></label>
                          <input type="text" class="form-control" name="no_of_persons" placeholder="Enter no of persons (adults)">
                          <p class="no-margin em"></p>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for=""><strong>Payment ({{$gs->base_curr_text}})/ Night:</strong></label>
                          <input type="text" class="form-control" name="payment" placeholder="Enter payment">
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for=""><strong>Select Amenities:</strong></label>
                          <div class="row">
                            <div class="col-md-2">
                            @for ($i=0; $i<ceil(count($ams)/2); $i++)
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="{{$ams[$i]->id}}">
                                <label class="form-check-label">
                                  {{$ams[$i]->name}}
                                </label>
                              </div>
                            @endfor
                            </div>
                            <div class="col-md-2">
                            @for ($i=ceil(count($ams)/2); $i < count($ams); $i++)
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="{{$ams[$i]->id}}">
                                <label class="form-check-label">
                                  {{$ams[$i]->name}}
                                </label>
                              </div>
                            @endfor
                            </div>
                            <div class="col-md-12">
                              <p class="no-margin em"></p>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for=""><strong>Overview: </strong></label>
                          <textarea id="overview" name="overview" rows="10" style="width:100%;"></textarea>
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-info btn-block form-control-lg">ADD ROOM</button>
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

function addroom(e) {

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
  var form = document.getElementById('addhotelform');
  var overviewElement = new nicEditors.findEditor('overview');
  overview = overviewElement.getContent();
  var fd = new FormData(form);
  for (var i = 0; i < imgs.length; i++) {
    fd.append('images[]', imgs[i]);
  }
  fd.append('overview', overview);
  $.ajax({
    url: '{{route('admin.room.store')}}',
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
        overviewElement.setContent('');
        $("#imgtable").remove();
        swal({
          title: "Success!",
          text: "Room added successfully!",
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
        if(typeof data.bed != 'undefined') {
          em[2].innerHTML = data.bed[0];
        }
        if(typeof data.bath != 'undefined') {
          em[3].innerHTML = data.bath[0];
        }
        if(typeof data.no_of_persons != 'undefined') {
          em[4].innerHTML = data.no_of_persons[0];
        }
        if(typeof data.payment != 'undefined') {
          em[5].innerHTML = data.payment[0];
        }
        if(typeof data.amenities != 'undefined') {
          em[6].innerHTML = data.amenities[0];
        }
        if(typeof data.overview != 'undefined') {
          em[7].innerHTML = data.overview[0];
        }
      }

    }
  });
}
</script>
@endpush
