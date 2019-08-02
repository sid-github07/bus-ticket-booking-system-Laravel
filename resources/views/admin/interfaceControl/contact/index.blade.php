@extends('admin.layout.master')

@push('styles')
<style media="screen">
  h3 {
    margin: 0px;
  }
</style>
@endpush

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>Contact Setting</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">

          <div class="tile">
            <div class="row">

              <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="form-horizontal" action="{{route('admin.contact.update')}}" method="post" role="form">
                   {{csrf_field()}}
                   <div class="form-body">
                     <div class="form-group">
                        <label class="col-md-12 "><strong style="text-transform: uppercase;">Title</strong></label>
                        <div class="col-md-12">
                           <input class="form-control input-lg" name="con_title" value="{{$gs->con_title}}" type="text">
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-12 "><strong style="text-transform: uppercase;">Short Details</strong></label>
                        <div class="col-md-12">
                           <input class="form-control input-lg" name="con_sdetails" value="{{$gs->con_sdetails}}" type="text">
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-12 "><strong style="text-transform: uppercase;">Address</strong></label>
                        <div class="col-md-12">
                           <input class="form-control input-lg" name="address" value="{{$gs->address}}" type="text">
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-12 "><strong style="text-transform: uppercase;">Phone</strong></label>
                        <div class="col-md-12">
                           <input class="form-control input-lg" name="phone" value="{{$gs->phone}}" type="text">
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-12 "><strong style="text-transform: uppercase;">Email</strong></label>
                        <div class="col-md-12">
                           <input class="form-control input-lg" name="email" value="{{$gs->email}}" type="text">
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-12 "><strong style="text-transform: uppercase;">Latitude</strong></label>
                        <div class="col-md-12">
                           <input class="form-control input-lg" name="latitude" value="{{$gs->latitude}}" type="text">
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-md-12 "><strong style="text-transform: uppercase;">Longitude</strong></label>
                        <div class="col-md-12">
                           <input class="form-control input-lg" name="longitude" value="{{$gs->longitude}}" type="text">
                        </div>
                     </div>
                      <div class="form-group">
                         <div class="col-md-12">
                            <button type="submit" class="btn btn-info btn-block btn-lg">UPDATE</button>
                         </div>
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
