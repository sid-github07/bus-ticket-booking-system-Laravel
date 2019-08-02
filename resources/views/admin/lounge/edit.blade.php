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
           <h1>Edit Lounge</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
           <div class="tile">

              <div class="row">
                <div class="col-md-12">
                  <form id="editloungeform" enctype="multipart/form-data" onsubmit="updatelounge(event)">
                    {{csrf_field()}}

                    <input type="hidden" name="loungeid" value="{{$lounge->id}}">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for=""><strong>Lounge Name:</strong></label>
                          <input class="form-control" type="text" name="name" value="{{$lounge->name}}" placeholder="Enter Lounge Name">
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for=""><strong>Location:</strong></label>
                          <input type="text" class="form-control" name="location" value="{{$lounge->location}}" placeholder="Enter Lounge Location">
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
                          <input class="form-control" type="text" name="price" value="{{$lounge->price}}" placeholder="Enter Price Per Person">
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for=""><strong>Maximum Number of Persons:</strong></label>
                          <input class="form-control" type="number" name="persons" value="{{$lounge->persons}}" placeholder="Enter Number of Persons">
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for=""><strong>Maximum Number of Hours:</strong></label>
                          <input class="form-control" type="text" name="hours" value="{{$lounge->hours}}" placeholder="Enter Maximum Number of Hours">
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
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="{{$ams[$i]->id}}" {{($ams[$i]->lounges()->whereLoungeId($lounge->id)->count() > 0) ? 'checked' : ''}}>
                                <label class="form-check-label">
                                  {{$ams[$i]->name}}
                                </label>
                              </div>
                            @endfor
                            </div>
                            <div class="col-md-6">
                            @for ($i=ceil(count($ams)/2); $i < count($ams); $i++)
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="amenities[]" value="{{$ams[$i]->id}}" {{($ams[$i]->lounges()->whereLoungeId($lounge->id)->count() > 0) ? 'checked' : ''}}>
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
                              <input name="opening_hour" type="text" class="time start form-control" value="{{$lounge->opening_hour}}" />
                              <p class="em no-margin"></p>
                            </div>
                            <div class="col-md-1">
                              to
                            </div>
                            <div class="col-md-5">
                              <input name="closing_hour" type="text" class="time end form-control" value="{{$lounge->closing_hour}}" />
                              <p class="em no-margin"></p>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Closing Days</label>
                          <select class="form-control" name="closing_days[]" multiple>
                            <option value="1" {{$lounge->loungeclosingdays()->where('closing_day', 1)->count() > 0 ? 'selected' : ''}}>Monday</option>
                            <option value="2" {{$lounge->loungeclosingdays()->where('closing_day', 2)->count() > 0 ? 'selected' : ''}}>Tuesday</option>
                            <option value="3" {{$lounge->loungeclosingdays()->where('closing_day', 3)->count() > 0 ? 'selected' : ''}}>Wednesday</option>
                            <option value="4" {{$lounge->loungeclosingdays()->where('closing_day', 4)->count() > 0 ? 'selected' : ''}}>Thursday</option>
                            <option value="5" {{$lounge->loungeclosingdays()->where('closing_day', 5)->count() > 0 ? 'selected' : ''}}>Friday</option>
                            <option value="6" {{$lounge->loungeclosingdays()->where('closing_day', 6)->count() > 0 ? 'selected' : ''}}>Saturday</option>
                            <option value="0" {{$lounge->loungeclosingdays()->where('closing_day', 0)->count() > 0 ? 'selected' : ''}}>Sunday</option>
                          </select>
                          <p class="em no-margin"></p>
                        </div>
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for=""><strong>Condition of entry: </strong></label>
                          <textarea id="coe" name="condition_of_entry" rows="5" style="width:100%;">{{$lounge->condition_of_entry}}</textarea>
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for=""><strong>Overview: </strong></label>
                          <textarea id="overview" name="overview" rows="10" style="width:100%;">{{$lounge->overview}}</textarea>
                          <p class="no-margin em"></p>
                        </div>
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-info btn-block form-control-lg">UPDATE LOUNGE</button>
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
      $.get("{{route('admin.lounge.imgs', $lounge->id)}}", function(data){
          for (var i = 0; i < data.length; i++) {
            imgsdb.push(data[i].image);
            $("#imgtable").append('<tr class="trdb" id="trdb'+i+'"><td width="100px"><div class="thumbnail"><img style="width:100px;" src="{{asset('assets/user/img/lounge_imgs/')}}/'+data[i].image+'" alt="Ad Image"></div></td><td><button type="button" class="btn btn-danger pull-right rmvbtndb" onclick="rmvdbimg('+i+')"><i class="fa fa-times"></i></button></td></tr>');
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

  function updatelounge(e) {

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
    var form = document.getElementById('editloungeform');
    var overviewElement = new nicEditors.findEditor('overview');
    var coeElement = new nicEditors.findEditor('coe');
    overview = overviewElement.getContent();
    coe = coeElement.getContent();
    var fd = new FormData(form);
    for (var i = 0; i < imgs.length; i++) {
      fd.append('images[]', imgs[i]);
    }
    for (var k = 0; k < imgsdb.length; k++) {
      fd.append('imgsdb[]', imgsdb[k]);
    }
    fd.append('overview', overview);
    fd.append('condition_of_entry', coe);
    $.ajax({
      url: '{{route('admin.lounge.update')}}',
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
            text: "Lounge updated successfully!",
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
@endpush
