@extends('admin.layout.master')

@push('nicedit-scripts')
  <script src="{{asset('assets/nic-edit/nicEdit.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
    bkLib.onDomLoaded(function() {
      new nicEditor({iconsPath : '{{asset('assets/nic-edit/nicEditorIcons.gif')}}', fullPanel : true}).panelInstance('coe');
      new nicEditor({iconsPath : '{{asset('assets/nic-edit/nicEditorIcons.gif')}}', fullPanel : true}).panelInstance('overview');
    });
  </script>
@endpush

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>Add Lounge</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
           <div class="tile">

              <div class="row">
                <div class="col-md-12">
                  <form id="addloungeform" enctype="multipart/form-data" onsubmit="storelounge(event)">
                    {{csrf_field()}}
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for=""><strong>Lounge Name:</strong></label>
                          <input class="form-control" type="text" name="name" value="" placeholder="Enter Lounge Name">
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for=""><strong>Location:</strong></label>
                          <input type="text" class="form-control" name="location" value="" placeholder="Enter Lounge Location">
                          <p class="em no-margin"></p>
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
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for=""><strong>Price Per Person ({{$gs->base_curr_text}}):</strong></label>
                          <input class="form-control" type="text" name="price" value="" placeholder="Enter Price Per Person">
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for=""><strong>Maximum Number of Persons:</strong></label>
                          <input class="form-control" type="number" name="persons" value="" placeholder="Enter Number of Persons">
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for=""><strong>Maximum Number of Hours:</strong></label>
                          <input class="form-control" type="text" name="hours" value="" placeholder="Enter Maximum Number of Hours">
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                    </div>



                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for=""><strong>Select Amenities:</strong></label>
                          <div class="row">
                            <div class="col-md-6">
                            @for ($i=0; $i<ceil(count($ams)/2); $i++)
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="{{$ams[$i]->id}}">
                                <label class="form-check-label">
                                  {{$ams[$i]->name}}
                                </label>
                              </div>
                            @endfor
                            </div>
                            <div class="col-md-6">
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

                      <div class="col-md-4">
                        <div class="form-group" id="ohrs">
                          <p class="no-margin"><label for=""><strong>Opening Hours</strong></label></p>
                          <div class="row">
                            <div class="col-md-5">
                              <input name="opening_hour" type="text" class="time start form-control" />
                              <p class="em no-margin"></p>
                            </div>
                            <div class="col-md-1">
                              to
                            </div>
                            <div class="col-md-5">
                              <input name="closing_hour" type="text" class="time end form-control" />
                              <p class="em no-margin"></p>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Closing Days</label>
                          <select class="form-control" name="closing_days[]" multiple>
                            <option value="1">Monday</option>
                            <option value="2">Tuesday</option>
                            <option value="3">Wednesday</option>
                            <option value="4">Thursday</option>
                            <option value="5">Friday</option>
                            <option value="6">Saturday</option>
                            <option value="0">Sunday</option>
                          </select>
                          <p class="em no-margin"></p>
                        </div>
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for=""><strong>Condition of entry: </strong></label>
                          <textarea id="coe" name="condition_of_entry" rows="5" style="width:100%;"></textarea>
                          <p class="no-margin em"></p>
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
                        <button type="submit" class="btn btn-info btn-block form-control-lg">ADD LOUNGE</button>
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

function storelounge(e) {

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
  var form = document.getElementById('addloungeform');
  var overviewElement = new nicEditors.findEditor('overview');
  var coeElement = new nicEditors.findEditor('coe');
  overview = overviewElement.getContent();
  coe = coeElement.getContent();
  var fd = new FormData(form);
  for (var i = 0; i < imgs.length; i++) {
    fd.append('images[]', imgs[i]);
  }
  fd.append('overview', overview);
  fd.append('condition_of_entry', coe);
  $.ajax({
    url: '{{route('admin.lounge.store')}}',
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
        coeElement.setContent('');
        $("#imgtable").remove();
        swal({
          title: "Success!",
          text: "Lounge added successfully!",
          icon: "success",
          button: "OK!",
        });
      }

      // Showing error messages in the HTML...
      if(typeof data.error != 'undefined') {
        if(typeof data.name != 'undefined') {
          em[0].innerHTML = data.name[0];
        }
        if(typeof data.location != 'undefined') {
          em[1].innerHTML = data.location[0];
        }
        if(typeof data.images != 'undefined') {
          em[2].innerHTML = data.images[0];
        }
        if(typeof data.price != 'undefined') {
          em[3].innerHTML = data.price[0];
        }
        if(typeof data.persons != 'undefined') {
          em[4].innerHTML = data.persons[0];
        }
        if(typeof data.hours != 'undefined') {
          em[5].innerHTML = data.hours[0];
        }
        if(typeof data.amenities != 'undefined') {
          em[6].innerHTML = data.amenities[0];
        }
        if(typeof data.opening_hour != 'undefined') {
          em[7].innerHTML = data.opening_hour[0];
        }
        if(typeof data.closing_hour != 'undefined') {
          em[8].innerHTML = data.closing_hour[0];
        }
        if(typeof data.closing_days != 'undefined') {
          em[9].innerHTML = data.closing_days[0];
        }
        if(typeof data.condition_of_entry != 'undefined') {
          em[10].innerHTML = data.condition_of_entry[0];
        }
        if(typeof data.overview != 'undefined') {
          em[11].innerHTML = data.overview[0];
        }
      }

    }
  });
}

</script>

<script src="{{asset('assets/plugins/jquery-timepicker/datepair.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-timepicker/jquery.datepair.js')}}"></script>
<script>
$( document ).ready(function() {
  // initialize input widgets first
  $('#ohrs .time').timepicker({
      'showDuration': true,
      'timeFormat': 'g:ia'
  });

  // initialize datepair
  $('#ohrs').datepair();
});
</script>
@endpush
