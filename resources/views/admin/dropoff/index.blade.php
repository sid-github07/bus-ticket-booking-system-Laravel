@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>All Dropoff Locations Management</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
          @if (count($dropoffs) == 0)
          <div class="tile">
            <h3 class="tile-title pull-left" style="display:inline-block;">Dropoff Locations List</h3>
            <div class="pull-right icon-btn">
              <a class="btn btn-info" href="{{route('admin.pickupcar.index')}}">
                <i class="fa fa-list"></i>
                All Pickup Cars
              </a>
               <form method="GET" class="form-inline" action="{{route('admin.allUsersSearchResult')}}" style="display:inline-block;">
                  <input type="text" name="term" class="form-control" placeholder="Search by dropoff name">
                  <button class="btn btn-outline btn-circle  green" type="submit"><i
                     class="fa fa-search"></i></button>
               </form>
            </div>
            <p style="clear:both;margin:0px;"></p>
            <h2 class="text-center">NO DROPOFF LOCATION FOUND</h2>
          </div>
          @else
          <div class="tile">
             <h3 class="tile-title pull-left" style="display:inline-block;">Dropoff Locations List</h3>
             <div class="pull-right icon-btn">
               <a class="btn btn-info" href="{{route('admin.pickupcar.index')}}">
                 <i class="fa fa-list"></i>
                 All Pickup Cars
               </a>
                <form method="GET" class="form-inline" action="{{route('admin.allUsersSearchResult')}}" style="display:inline-block;">
                   <input type="text" name="term" class="form-control" placeholder="Search by dropoff name">
                   <button class="btn btn-outline btn-circle  green" type="submit"><i
                      class="fa fa-search"></i></button>
                </form>
             </div>
             <div class="table-responsive">
                <table class="table">
                   <thead>
                      <tr>
                         <th scope="col">Serial</th>
                         <th scope="col">Dropoff Location Name</th>
                         <th scope="col">Price</th>
                         <th scope="col">Action</th>
                      </tr>
                   </thead>
                   <tbody>
                     @foreach ($dropoffs as $dropoff)
                       <tr>
                         <td>{{$loop->iteration}}</td>
                         <td>{{$dropoff->location}}</td>
                         <td>{{$dropoff->price}} {{$gs->base_curr_text}}</td>
                         <td>
                           <a href="{{route('admin.dropoff.edit', $dropoff->id)}}" class="btn btn-warning"><i class="fa fa-pencil-square"></i> Edit</a>
                           @if ($dropoff->a_hidden == 0)
                           <button id="hideShowBtn{{$dropoff->id}}" class="btn btn-danger" onclick="showHideDropoff(event, {{$dropoff->id}})">Hide</button>
                           @else
                           <button id="hideShowBtn{{$dropoff->id}}" class="btn btn-success" onclick="showHideDropoff(event, {{$dropoff->id}})">Show</button>
                           @endif
                         </td>
                       </tr>
                     @endforeach
                   </tbody>
                </table>
             </div>
             <div class="text-center">
               {{$dropoffs->appends(['term' => $term])->links()}}
             </div>
          </div>
          @endif
        </div>
     </div>
  </main>
  @includeif('admin.dropoff.ajaxFunctions')
@endsection
