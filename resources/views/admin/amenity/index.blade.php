@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>Amenities Management</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
           <div class="tile">
              <h3 class="tile-title pull-left">Amenities List</h3>
              <div class="pull-right icon-btn">
                <a href="https://fontawesome.com/v4.7.0/icons/" target="_blank" class="btn btn-info">
                  <i class="fa fa-info"></i> Font Awesome Codes
                </a>
                 <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">
                   <i class="fa fa-plus"></i> Add Amenity
                 </button>
              </div>
              <p style="clear:both;margin:0px;"></p>
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
              </div>
              <div class="table-responsive">
                @if (count($ams) == 0)
                  <h2 class="text-center">NO AMENITY FOUND</h2>
                @else
                  <table class="table">
                     <thead>
                        <tr>
                           <th scope="col">SL</th>
                           <th scope="col">Icon</th>
                           <th scope="col">Name</th>
                           <th scope="col">Status</th>
                           <th scope="col">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                          @foreach ($ams as $key => $am)
                            <tr>
                               <td>{{$key+1}}</td>
                               <td><i class="fa fa-{{$am->code}}"></i></td>
                               <td>{{$am->name}}</td>
                               <td>
                                 @if ($am->status == 1)
                                   <h4 style="display:inline-block;"><span class="badge badge-success">Active</span></h4>
                                 @elseif ($am->status == 0)
                                   <h4 style="display:inline-block;"><span class="badge badge-danger">Deactive</span></h4>
                                 @endif
                               </td>
                               <td>
                                 <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{$am->id}}">Edit</button>
                               </td>
                            </tr>
                            @includeif('admin.amenity.partials.edit')
                          @endforeach
                     </tbody>
                  </table>
                @endif
              </div>

              <div class="text-center">
                {{$ams->links()}}
              </div>
           </div>
        </div>
     </div>
  </main>

  {{-- Gateway Add Modal --}}
  @includeif('admin.amenity.partials.add')
@endsection
