@extends('admin.layout.master')

@push('styles')
<style media="screen">
  h3 {
    margin: 0px;
  }
  .fileinput .thumbnail img {
    width: 100%;
  }
</style>
@endpush

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>Background Image</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
           <div class="tile">
             <form class="" method="POST" action="{{route('admin.background.update')}}" enctype="multipart/form-data">
               {{csrf_field()}}
               <div class="row">
                 <div class="form-group col-md-6">
                    <div class="card">
                       <div class="card-header bg-primary">
                          <h3 style="color:white;">Slider Background Image</h3>
                       </div>
                       <div class="card-body">
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                             <div class="fileinput-new thumbnail">
                                <img style="width:100%;" src="{{ asset('assets/user/interfaceControl/backgroundImage/sliderarea.jpg') }}" alt="" />
                             </div>
                             <div class="fileinput-preview fileinput-exists thumbnail"> </div>
                             <div>
                                <span class="btn btn-success btn-file">
                                <span class="fileinput-new"> Change Image </span>
                                <span class="fileinput-exists"> Change </span>
                                <input type="file" name="slider_area">
                                </span>
                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                             </div>
                          </div>
                       </div>

                      @if ($errors->has('slider_area'))
                      <div class="card-footer">
                      <p style="color:red">{{$errors->first('slider_area')}}</p>
                      </div>
                      @endif

                    </div>
                 </div>
                  <div class="form-group col-md-6">
                     <div class="card">
                        <div class="card-header bg-primary">
                           <h3 style="color:white;">Page Header Background Image</h3>
                        </div>
                        <div class="card-body">
                           <div class="fileinput fileinput-new" data-provides="fileinput">
                              <div class="fileinput-new thumbnail">
                                 <img style="width:100%;" src="{{ asset('assets/user/interfaceControl/backgroundImage/pageheader.jpg') }}" alt="" />
                              </div>
                              <div class="fileinput-preview fileinput-exists thumbnail"> </div>
                              <div>
                                 <span class="btn btn-success btn-file">
                                 <span class="fileinput-new"> Change Image </span>
                                 <span class="fileinput-exists"> Change </span>
                                 <input type="file" name="page_header">
                                 </span>
                                 <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                              </div>
                           </div>
                        </div>

                       @if ($errors->has('page_header'))
                       <div class="card-footer">
                       <p style="color:red">{{$errors->first('page_header')}}</p>
                       </div>
                       @endif

                     </div>
                  </div>
               </div>



               <div class="row">
                 <div class="form-group col-md-4">
                    <div class="card">
                       <div class="card-header bg-primary">
                          <h3 style="color:white;">Subscription Section Background Image</h3>
                       </div>
                       <div class="card-body">
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                             <div class="fileinput-new thumbnail">
                                <img style="width:100%;" src="{{ asset('assets/user/interfaceControl/backgroundImage/subscription.jpg') }}" alt="" />
                             </div>
                             <div class="fileinput-preview fileinput-exists thumbnail"> </div>
                             <div>
                                <span class="btn btn-success btn-file">
                                <span class="fileinput-new"> Change Image </span>
                                <span class="fileinput-exists"> Change </span>
                                <input type="file" name="subscription">
                                </span>
                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                             </div>
                          </div>
                       </div>

                      @if ($errors->has('subscription'))
                      <div class="card-footer">
                      <p style="color:red">{{$errors->first('subscription')}}</p>
                      </div>
                      @endif

                    </div>
                 </div>

                 <div class="form-group col-md-4">
                    <div class="card">
                       <div class="card-header bg-primary">
                          <h3 style="color:white;">Package Section Background Image</h3>
                       </div>
                       <div class="card-body">
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                             <div class="fileinput-new thumbnail">
                                <img style="width:100%;" src="{{ asset('assets/user/interfaceControl/backgroundImage/package.jpg') }}" alt="" />
                             </div>
                             <div class="fileinput-preview fileinput-exists thumbnail"> </div>
                             <div>
                                <span class="btn btn-success btn-file">
                                <span class="fileinput-new"> Change Image </span>
                                <span class="fileinput-exists"> Change </span>
                                <input type="file" name="package">
                                </span>
                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                             </div>
                          </div>
                       </div>

                      @if ($errors->has('package'))
                      <div class="card-footer">
                      <p style="color:red">{{$errors->first('package')}}</p>
                      </div>
                      @endif

                    </div>
                 </div>

                 <div class="form-group col-md-4">
                    <div class="card">
                       <div class="card-header bg-primary">
                          <h3 style="color:white;">Lounge Section Background Image</h3>
                       </div>
                       <div class="card-body">
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                             <div class="fileinput-new thumbnail">
                                <img style="width:100%;" src="{{ asset('assets/user/interfaceControl/backgroundImage/lounge.jpg') }}" alt="" />
                             </div>
                             <div class="fileinput-preview fileinput-exists thumbnail"> </div>
                             <div>
                                <span class="btn btn-success btn-file">
                                <span class="fileinput-new"> Change Image </span>
                                <span class="fileinput-exists"> Change </span>
                                <input type="file" name="lounge">
                                </span>
                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                             </div>
                          </div>
                       </div>

                      @if ($errors->has('lounge'))
                      <div class="card-footer">
                      <p style="color:red">{{$errors->first('lounge')}}</p>
                      </div>
                      @endif

                    </div>
                 </div>
               </div>



               <div class="row">
                 <div class="col-md-12">
                   <button type="submit" class="btn btn-lg btn-info btn-block">UPDATE</button>
                 </div>
               </div>
             </form>
           </div>
        </div>
     </div>
  </main>
@endsection
