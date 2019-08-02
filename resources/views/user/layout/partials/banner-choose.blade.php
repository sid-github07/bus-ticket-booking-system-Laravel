<section id="banner">
  <div class="overly"></div>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-8 col-md-10">
        <div class="banner_slider">

          <div class="banner_info2 text-center">
            @foreach ($sliders as $slider)
              <article>
                <h2>{{$slider->bold_text}}</h2>
                <p>{{$slider->small_text}}</p>
              </article>
            @endforeach

          </div>
        </div>
      </div>
    </div>
  </div>

</section>
<!-- =========== banner end =========== -->

<!-- =========== Whay Choose Us Start ============ -->
<section id="choose-us">
  <div id="index-2-serch-top">
    <div class="i-s-t-nav">
      <div class="container">
        <div class="col-12">
          <div class="h-seaerch-area">
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link normal-t active" id="nav-Packages-tab" data-toggle="tab" href="#nav-Packages" role="tab"
                  aria-controls="nav-Rooms" aria-selected="true">
                  Packages
                </a>
                <a class="nav-item nav-link normal-t" id="nav-Rooms-tab" data-toggle="tab" href="#nav-Rooms" role="tab"
                  aria-controls="nav-Rooms" aria-selected="true">
                  Rooms
                </a>
                <a class="nav-item nav-link advance" id="nav-Vehicles-tab" data-toggle="tab" href="#nav-Vehicles" role="tab"
                  aria-controls="nav-Vehicles" aria-selected="false">
                  Rent Vehicles
                </a>
                <a class="nav-item nav-link advance" id="nav-Airport-tab" data-toggle="tab" href="#nav-Airport" role="tab"
                  aria-controls="nav-Airport" aria-selected="false">
                  Airport Pickup
                </a>
                <a class="nav-item nav-link advance" id="nav-Lounges-tab" data-toggle="tab" href="#nav-Lounges" role="tab"
                  aria-controls="nav-Lounges" aria-selected="false">
                  Lounges
                </a>
              </div>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <div class="i-s-t-content">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="h-seaerch-area">
              <!-- Nav tabs -->

              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show normal active" id="nav-Packages" role="tabpanel" aria-labelledby="nav-Packages-tab">
                  <form action="{{route('user.package.search')}}" method="get" target="_blank">
                    <div class="form-row">
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Leaving From</label>
                          <select name="leaving_from" class="js-example-basic-single form-control">
                            @foreach ($package_lf as $lf)
                              <option value="{{$lf->leaving_from}}">{{$lf->leaving_from}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Leaving To</label>
                          <select name="leaving_to" class="js-example-basic-single form-control">
                            @foreach ($package_lt as $lt)
                              <option value="{{$lt->leaving_to}}">{{$lt->leaving_to}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Duration</label>
                          <input name="duration" type="number" name="bday" class="form-control" placeholder="Number of days">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Persons</label>
                          <input name="persons" type="number" class="form-control" placeholder="No of persons">
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="index-2-serch-top-btn">
                        <button type="submit"><i class="fa fa-search"></i>SEARCH NOW</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade show normal" id="nav-Rooms" role="tabpanel" aria-labelledby="nav-Rooms-tab">
                  <form action="{{route('user.room.search')}}" method="get" target="_blank">
                    <div class="form-row">
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label>Location</label>
                          <select name="address" class="js-example-basic-single form-control" style="width:100%;">
                            @foreach ($hotel_ad as $ha)
                              <option value="{{$ha->address}}">{{$ha->address}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Checkin Date</label>
                          <input placeholder="Enter a checkin date" type="text" name="checkin_date" class="form-control" data-toggle="datepicker" autocomplete="off" readonly onchange="disenduration(this.value);">
                        </div>
                      </div>
                      <script>
                        $(document).ready(function() {
                          disenduration('');
                        });
                        function disenduration(checkin) {
                          console.log(checkin.length);
                          if (checkin.length > 0) {
                            document.getElementById('roomduration').disabled = false;
                          } else {
                            document.getElementById('roomduration').disabled = true;
                          }
                        }
                      </script>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Duration</label>
                          <input type="number" min="1" name="duration" class="form-control" placeholder="Number of days to stay" id="roomduration" title="Select a checkin date before entering duration">
                        </div>
                      </div>
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label>Persons</label>
                          <input type="number" name="persons" class="form-control" placeholder="No of persons">
                        </div>
                      </div>
                      <div class="col-lg-2">
                        <div class="form-group">
                          <label>Beds</label>
                          <input type="number" name="beds" class="form-control" placeholder="No of beds">
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="index-2-serch-top-btn">
                        <button type="submit"><i class="fa fa-search"></i>SEARCH NOW</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade advance-c" id="nav-Vehicles" role="tabpanel" aria-labelledby="nav-Vehicles-tab">
                  <form action="{{route('user.rentcar.search')}}" method="get" target="_blank">
                    <div class="form-row">
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Location</label>
                          <select name="address" class="js-example-basic-single form-control" style="width:100%;">
                            @foreach ($rent_ad as $ra)
                              <option value="{{$ra->address}}">{{$ra->address}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Rent Date</label>
                          <input type="text" name="rent_date" data-toggle="datepicker" autocomplete="off" readonly onchange="disenrentduration(this.value);" class="form-control" placeholder="Enter a rent date">
                        </div>
                      </div>
                      <script>
                        $(document).ready(function() {
                          disenrentduration('');
                        });
                        function disenrentduration(checkin) {
                          console.log(checkin.length);
                          if (checkin.length > 0) {
                            document.getElementById('rentduration').disabled = false;
                          } else {
                            document.getElementById('rentduration').disabled = true;
                          }
                        }
                      </script>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Duration</label>
                          <input type="number" name="duration" class="form-control" placeholder="Number of days" id="rentduration">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Persons</label>
                          <input type="number" name="persons" class="form-control" placeholder="Number of persons">
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="index-2-serch-top-btn">
                        <button type="submit"><i class="fa fa-search"></i>SEARCH NOW</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade advance-c" id="nav-Airport" role="tabpanel" aria-labelledby="nav-Airport-tab">
                  <form action="{{route('user.pickup.search')}}" method="get" target="_blank">
                    <div class="form-row">
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Pick Up Location</label>
                          {{-- <input type="text" name="pickup_location" class="form-control"> --}}
                          <select name="pickup_location" class="js-example-basic-single form-control" style="width:100%;">
                            @foreach ($pickup_loc as $pl)
                              <option value="{{$pl->pickup_location}}">{{$pl->pickup_location}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Pick Up Date</label>
                          <input name="pickup_date" type="text" data-toggle="datepicker" readonly placeholder="Select a pickup date" class="form-control">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Drop Off Location</label>
                          <select name="drop_location" class="js-example-basic-single form-control" style="width:100%;">
                            @foreach ($drop_loc as $dl)
                              <option value="{{$dl->location}}">{{$dl->location}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Persons</label>
                          <input name="persons" type="number" min="1" class="form-control" placeholder="No of persons">
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="index-2-serch-top-btn">
                        <button type="submit"><i class="fa fa-search"></i>SEARCH NOW</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade advance-c" id="nav-Lounges" role="tabpanel" aria-labelledby="nav-Lounges-tab">
                  <form action="{{route('user.lounge.search')}}" method="get" target="_blank">
                    <div class="form-row">
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Place</label>
                          {{-- <input type="text" name="place" class="form-control" placeholder="Place name/city/country"> --}}
                          <select name="place" class="js-example-basic-single form-control" style="width:100%;">
                            @foreach ($lounge_loc as $ll)
                              <option value="{{$ll->location}}">{{$ll->location}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Checkin Date</label>
                          <input name="checkin_date" type="text" class="form-control" data-toggle="datepicker" readonly placeholder="Select checkin date">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Chekin Time</label>
                          <input id="checkintime" type="text" class="form-control" name="checkin_time" data-step="30" placeholder="Enter a checkin time">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Persons</label>
                          <input name="persons" type="number" class="form-control" placeholder="Enter Number of Persons">
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="index-2-serch-top-btn">
                        <button type="submit"><i class="fa fa-search"></i>SEARCH NOW</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7 col-md-10 text-center">
        <h2 class="section-heading">{{$gs->choose_title}}</h2>
        <p class="section-paragraph">{{$gs->choose_details}}</p>
      </div>
    </div>
    <div class="row">
      @foreach ($chooses as $choose)
        <div class="col-lg-3 col-md-6">
          <div class="c-box text-center">
            <div class="icon">
              <i class="fa fa-{{$choose->icon}}"></i>
            </div>
            <h4>{{$choose->bold_text}}</h4>
            <p>{{$choose->small_text}}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
<!-- =========== Whay Choose Us End ============ -->

<script>
$(document).ready(function() {
  var today = new Date();
    $('[data-toggle="datepicker"]').datepicker({
       numberOfMonths: 3,
       minDate: today
     });
});

$( document ).ready(function() {
  // initialize input widgets first
  $('#checkintime').timepicker();
});

$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>
