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
           <h1>Comment Script</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">

          <div class="tile">
            <div class="row">

              <div class="col-md-12">
                <form method="post" role="form" action="{{route('admin.fbComment.update')}}">
                    {{csrf_field()}}
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-12"><strong style="text-transform: uppercase;"> Comment Script</strong></label>
                            <div class="col-md-12">
                                <textarea id="area1" class="form-control" rows="8" name="comment_script">{{$gs->comment_script}}</textarea>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                              <div class="col-md-12">
                                <button type="submit" class="btn btn-info btn-block btn-lg"><i class="fa fa-send"></i> Update Script</button>
                              </div>
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
