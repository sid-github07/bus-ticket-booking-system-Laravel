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
           <h1>Choose us Section</h1>
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
                <form role="form" method="POST" action="{{route('admin.choose.textupdate')}}">
                    {{ csrf_field() }}
                            <div class="form-group">
                                <label for="title"><strong>Choose us Section Title</strong></label>
                                <input type="text" value="{{$gs->choose_title}}" name="title" class="form-control">
                            </div>
                             <div class="form-group">
                                <label for="details"><strong>Choose us Section Details</strong></label>
                               <input name="details" class="form-control" value="{{$gs->choose_details}}">
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
                    <h5 style="color:white;display:inline-block;">Services</h5>
                    <a target="_blank" href="https://fontawesome.com/icons?d=gallery" class="btn btn-sm btn-danger float-right">
                      <i class="fa fa-plus"></i> Font awesome icon link
                    </a>
                    <button type="button" class="btn btn-sm btn-default float-right" style="margin-right:10px;" data-toggle="modal" data-target="#addtest">
                      <i class="fa fa-plus"></i>
                      New Service
                    </button>
                  </div>
                  <div class="card-body">
                      @if (count($chooses) == 0)
                        <h3 class="text-center"> NO SERVICE FOUND</h3>
                      @else
                        @foreach ($chooses as $choose)
                          @if ($loop->iteration % 4 == 1)
                          <div class="row"> {{-- .row start --}}
                          @endif
                          <div class="col-md-3">
                            <div class="card testimonial">
                              <div class="card-header bg-primary">
                                <h5 style="color:white">Service</h5>
                              </div>
                              <div class="card-body text-center">
                                <i style="font-size:60px;" class="fa fa-{{$choose->icon}}"></i>

                                <h3 style="margin-top:20px;">{{$choose->bold_text}}</h3>
                                <p>
                                  {{$choose->small_text}}
                                </p>
                              </div>
                              <div class="card-footer text-center">
                                <button style="color:white;" type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edittest{{$choose->id}}">
                                  <i class="fa fa-pencil-square"></i>
                                  Edit
                                </button>
                                <form action="{{route('admin.choose.destroy')}}" method="POST" style="display: inline-block;">
                               {{csrf_field()}}
                               {{-- {{ method_field('DELETE') }} --}}
                               <input type="hidden" name="chooseid" value="{{$choose->id}}">
                               <button style="color:white;" type="submit" class="btn btn-danger btn-sm" name="button">
                                 <i class="fa fa-trash"></i>
                                 Delete
                               </button>
                             </form>

                              </div>
                            </div>
                          </div>
                          @if ($loop->iteration % 4 == 0)
                          </div> {{-- .row end --}}
                          <br>
                          @endif

                          <!-- Edit Modal -->
                          <div class="modal fade" id="edittest{{$choose->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalCenterTitle">Edit Service {{$choose->bold_text}}</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <form role="form" method="POST" action="{{route('admin.choose.update',$choose->id)}}" enctype="multipart/form-data">
                                   {{ csrf_field() }}
                                   <div class="form-group">
                                       <label for="name">Icon</label>
                                       <input type="text" class="form-control" value="{{$choose->icon}}" id="name" name="icon" >
                                   </div>
                                  <div class="form-group">
                                      <label for="name">Bold Text</label>
                                      <input type="text" class="form-control" value="{{$choose->bold_text}}" id="name" name="bold_text" >
                                  </div>
                                  <div class="form-group">
                                      <label for="company">Small Text</label>
                                      <input type="text" class="form-control" value="{{$choose->small_text}}"  id="company" name="small_text" >
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
          <h5 class="modal-title" id="exampleModalCenterTitle">Add New Service</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" method="POST" action="{{route('admin.choose.store')}}" enctype="multipart/form-data">
           {{ csrf_field() }}
             <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">fa fa-</span>
              </div>
              <input type="text" name="icon" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
            </div>
              <div class="form-group">
                  <label for="name">Bold Text</label>
                  <input type="text" class="form-control" id="name" name="bold_text" >
              </div>
              <div class="form-group">
                  <label for="company">Small Text</label>
                  <input type="text" class="form-control" id="company" name="small_text" >
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
