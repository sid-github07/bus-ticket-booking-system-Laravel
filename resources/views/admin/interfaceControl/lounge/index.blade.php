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
           <h1>Popular Lounge Section Setting</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">

          <div class="tile">
            <div class="row">

              <div class="col-md-12">
                <form action="{{route('admin.plounge.update')}}" method="post" role="form">
                   {{csrf_field()}}
                   <div class="form-body">
                      <div class="form-group">
                        <div class="row">
                          <label class="col-md-12 "><strong style="text-transform: uppercase;">TITLE</strong></label>
                          <div class="col-md-12">
                             <input class="form-control input-lg" name="lounge_title" value="{{$gs->lounge_title}}" type="text">
                             @if ($errors->has('lounge_title'))
                               <p style="color:red;">{{$errors->first('lounge_title')}}</p>
                             @endif
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <label class="col-md-12 "><strong style="text-transform: uppercase;">SHORT DETAILS</strong></label>
                          <div class="col-md-12">
                             <input class="form-control input-lg" name="lounge_details" value="{{$gs->lounge_details}}" type="text">
                             @if ($errors->has('lounge_details'))
                               <p style="color:red;">{{$errors->first('lounge_details')}}</p>
                             @endif
                          </div>
                        </div>
                      </div>
                      <div class="row">
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
