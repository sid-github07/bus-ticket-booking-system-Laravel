@extends('admin.layout.master')

@push('styles')
<style media="screen">
  h3, h5 {
    margin: 0px;
  }
  .testimonial img {
    height: 100px;
    width: 100px;
    border-radius: 50%;
  }
</style>
@endpush

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>Client Testimonial Section</h1>
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
                <form role="form" method="POST" action="{{route('admin.testm.testmUpdate')}}">
                    {{ csrf_field() }}
                   <div class="form-group">
                            <label for="testm_title"><strong>Testimonial Section Title</strong></label>
                                <input type="text" value="{{$gs->testm_title}}" name="title" class="form-control">
                            </div>
                             <div class="form-group">
                                <label for="testm_details"><strong>Testimonial Section Details</strong></label>
                               <input name="details" class="form-control" value="{{$gs->testm_details}}">
                            </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-success btn-block" >Update</button>
                    </div>
                </form>
              </div>

            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header bg-primary">
                    <h5 style="color:white;display:inline-block;">TESTIMONIALS</h5>
                    <button type="button" class="btn btn-sm btn-default float-right" data-toggle="modal" data-target="#addtest">
                      <i class="fa fa-plus"></i>
                      New Testimonial
                    </button>
                  </div>
                  <div class="card-body">
                      @if (count($testims) == 0)
                        <h3 class="text-center"> NO TESTIMONIAL FOUND</h3>
                      @else
                        @foreach ($testims as $testim)
                          @if ($loop->iteration % 3 == 1)
                          <div class="row"> {{-- .row start --}}
                          @endif
                          <div class="col-md-4">
                            <div class="card testimonial">
                              <div class="card-header bg-primary">
                                <h5 style="color:white">Testimonial</h5>
                              </div>
                              <div class="card-body text-center">
                                <img src="{{asset('assets/user/interfaceControl/testimonial/'.$testim->image)}}" alt="">

                                <h3 style="margin-top:20px;">{{$testim->name}}</h3>
                                <p>{{$testim->company}}</p>
                                <p>
                                  "{{$testim->comment}}"
                                </p>
                              </div>
                              <div class="card-footer text-center">
                                <button style="color:white;" type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edittest{{$testim->id}}">
                                  <i class="fa fa-pencil-square"></i>
                                  Edit
                                </button>
                                <form action="{{route('admin.testim.destroy')}}" method="POST" style="display: inline-block;">
                               {{csrf_field()}}
                               {{-- {{ method_field('DELETE') }} --}}
                               <input type="hidden" name="testimID" value="{{$testim->id}}">
                               <button style="color:white;" type="submit" class="btn btn-danger btn-sm" name="button">
                                 <i class="fa fa-trash"></i>
                                 Delete
                               </button>
                             </form>

                              </div>
                            </div>
                          </div>
                          @if ($loop->iteration % 3 == 0)
                          </div> {{-- .row end --}}
                          <br>
                          @endif

                          <!-- Edit Modal -->
                          <div class="modal fade" id="edittest{{$testim->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalCenterTitle">Edit Testimonial {{$testim->name}}</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <form role="form" method="POST" action="{{route('admin.testim.update',$testim)}}" enctype="multipart/form-data">
                                   {{ csrf_field() }}
                                      <div class="form-group">
                                         <div class="fileinput fileinput-new" data-provides="fileinput">
                                          <div class="fileinput-new thumbnail">
                                            <img src="{{ asset('assets/user/interfaceControl/testimonial') }}/{{$testim->image}}" alt="" /> </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 80px; max-height: 80px;"> </div>
                                            <div>
                                              <span class="btn btn-success btn-file">
                                                <span class="fileinput-new"> Change Image </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" name="photo"> </span>
                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                              </div>
                                            </div>
                                      </div>
                                  <div class="form-group">
                                      <label for="name">Name</label>
                                      <input type="text" class="form-control" value="{{$testim->name}}" id="name" name="name" >
                                  </div>
                                  <div class="form-group">
                                      <label for="company">Company</label>
                                      <input type="text" class="form-control" value="{{$testim->company}}"  id="company" name="company" >
                                  </div>
                                  <div class="form-group">
                                      <label for="comment" >Comment</label>
                                      <input type="text" name="comment" value="{{$testim->comment}}" class="form-control">
                                  </div>
                                      <div class="form-group">
                                          <button type="submit" class="btn btn-lg btn-block btn-success" >Update</button>
                                      </div>
                                  </form>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endforeach
                      @endif

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
     </div>
  </main>

  <!-- Add Modal -->
  <div class="modal fade" id="addtest" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Add New Testimonial</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" method="POST" action="{{route('admin.testim.store')}}" enctype="multipart/form-data">
           {{ csrf_field() }}
              <div class="form-group">
              <div class="fileinput fileinput-new" data-provides="fileinput">
              <div class="fileinput-new thumbnail">
                <img src="http://via.placeholder.com/100X100" alt="" /> </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 80px; max-height: 80px;"> </div>
                <div>
                  <span class="btn btn-success btn-file">
                    <span class="fileinput-new"> Change Image </span>
                    <span class="fileinput-exists"> Change </span>
                    <input type="file" name="photo"> </span>
                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                  </div>
                </div>
              </div>
              <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" id="name" name="name" >
              </div>
              <div class="form-group">
                  <label for="company">Company</label>
                  <input type="text" class="form-control" id="company" name="company" >
              </div>
              <div class="form-group">
                  <label for="comment" >Comment</label>
                  <textarea class="form-control" name="comment" rows="5" cols="80"></textarea>
              </div>
              <div class="form-group">
                  <button type="submit" class="btn btn-lg btn-success btn-block" >Save</button>
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection
