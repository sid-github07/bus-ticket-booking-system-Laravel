@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>All Pickup Cars Management</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
          @if (count($pickups) == 0)
          <div class="tile">
            <h3 class="tile-title pull-left">Pickup Cars List</h3>
            <div class="pull-right icon-btn">
               <form method="GET" class="form-inline" action="{{route('admin.pickupcar.index')}}">
                  <input type="text" name="term" class="form-control" placeholder="Search by pickup name">
                  <button class="btn btn-outline btn-circle  green" type="submit"><i
                     class="fa fa-search"></i></button>
               </form>
            </div>
            <p style="clear:both;margin:0px;"></p>
            <h2 class="text-center">NO PICKUP CAR FOUND</h2>
          </div>
          @else
          <div class="tile">
             <h3 class="tile-title pull-left">Pickup Cars List</h3>
             <div class="pull-right icon-btn">
                <form method="GET" class="form-inline" action="{{route('admin.pickupcar.index')}}">
                   <input type="text" name="term" class="form-control" placeholder="Search by pickup name">
                   <button class="btn btn-outline btn-circle  green" type="submit"><i
                      class="fa fa-search"></i></button>
                </form>
             </div>
             <div class="table-responsive">
                <table class="table">
                   <thead>
                      <tr>
                         <th scope="col">Serial</th>
                         <th scope="col">Title</th>
                         <th scope="col">Pickup Location</th>
                         <th scope="col">Dropoff Locations</th>
                         <th scope="col">Action</th>
                      </tr>
                   </thead>
                   <tbody>
                     @foreach ($pickups as $pickup)
                       <tr>
                         <td>{{$loop->iteration}}</td>
                         <td><a href="{{route('user.pickup.show', $pickup->id)}}" target="_blank">{{$pickup->title}}</a></td>
                         <td>{{$pickup->pickup_location}}</td>
                         <td>
                           <a href="{{route('admin.pickup.dropoffs', $pickup->id)}}" class="btn btn-primary"><i class="fa fa-eye"></i> View Dropoff Locations</a>
                         </td>
                         <td>
                           <a href="{{route('admin.dropoff.create', $pickup->id)}}" class="btn btn-info"><i class="fa fa-plus"></i> Add Dropoff Location</a>
                           <a href="{{route('admin.pickupcar.edit', $pickup->id)}}" class="btn btn-warning"><i class="fa fa-pencil-square"></i> Edit</a>
                           @if ($pickup->a_hidden == 0)
                           <button id="hideShowBtn{{$pickup->id}}" class="btn btn-danger" onclick="showHidePickup(event, {{$pickup->id}})">Hide</button>
                           @else
                           <button id="hideShowBtn{{$pickup->id}}" class="btn btn-success" onclick="showHidePickup(event, {{$pickup->id}})">Show</button>
                           @endif
                         </td>
                       </tr>
                     @endforeach
                   </tbody>
                </table>
             </div>
             <div class="text-center">
               {{$pickups->appends(['term' => $term])->links()}}
             </div>
          </div>
          @endif
        </div>
     </div>
  </main>
  @includeif('admin.pickup.ajaxFunctions')
@endsection
