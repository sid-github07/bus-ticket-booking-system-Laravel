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
           <h1>Add Dropoff Location</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
           <div class="tile">

              <div class="row">
                <div class="col-md-12">
                  <form action="{{route('admin.dropoff.store')}}" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="pickup_car_id" value="{{$pickup_car_id}}">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for=""><strong>Location:</strong></label>
                          <input class="form-control" type="text" name="location" value="" placeholder="Enter Location">
                          @if ($errors->has('location'))
                            <p class="no-margin em">{{$errors->first('location')}}</p>
                          @endif
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for=""><strong>Price ({{$gs->base_curr_text}}):</strong></label>
                          <input class="form-control" type="text" name="price" value="" placeholder="Enter Price">
                          @if ($errors->has('price'))
                            <p class="no-margin em">{{$errors->first('price')}}</p>
                          @endif
                        </div>
                      </div>
                    </div>



                    <div class="row">
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-info btn-block form-control-lg">ADD DROPOFF LOCATION</button>
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
