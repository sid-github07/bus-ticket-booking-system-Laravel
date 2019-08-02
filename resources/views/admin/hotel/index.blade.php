@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>All Hotels Management</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
          @if (count($hotels) == 0)
          <div class="tile">
            <h3 class="tile-title pull-left">Hotels List</h3>
            <div class="pull-right icon-btn">
               <form method="GET" class="form-inline" action="{{route('admin.hotel.index')}}">
                  <input type="text" name="term" class="form-control" placeholder="Search by hotel name">
                  <button class="btn btn-outline btn-circle  green" type="submit"><i
                     class="fa fa-search"></i></button>
               </form>
            </div>
            <p style="clear:both;margin:0px;"></p>
            <h2 class="text-center">NO HOTEL FOUND</h2>
          </div>
          @else
          <div class="tile">
             <h3 class="tile-title pull-left">Hotels List</h3>
             <div class="pull-right icon-btn">
                <form method="GET" class="form-inline" action="{{route('admin.hotel.index')}}">
                   <input type="text" name="term" class="form-control" placeholder="Search by hotel name">
                   <button class="btn btn-outline btn-circle  green" type="submit"><i
                      class="fa fa-search"></i></button>
                </form>
             </div>
             <div class="table-responsive">
                <table class="table">
                   <thead>
                      <tr>
                         <th scope="col">Serial</th>
                         <th scope="col">Hotel Name</th>
                         <th scope="col">Rooms</th>
                         <th scope="col">Action</th>
                      </tr>
                   </thead>
                   <tbody>
                     @foreach ($hotels as $hotel)
                       <tr>
                         <td>{{$loop->iteration}}</td>
                         <td><a href="{{route('user.hotel.show', $hotel->id)}}" target="_blank">{{$hotel->name}}</a></td>
                         <td>
                           <a href="{{route('admin.hotel.rooms', $hotel->id)}}" class="btn btn-primary"><i class="fa fa-list"></i> All Rooms</a>
                         </td>
                         <td>
                           <a href="{{route('admin.room.create', $hotel->id)}}" class="btn btn-info"><i class="fa fa-plus"></i> Add Room</a>
                           <a href="{{route('admin.hotel.edit', $hotel->id)}}" class="btn btn-warning"><i class="fa fa-pencil-square"></i> Edit</a>
                           @if ($hotel->a_hidden == 0)
                           <button id="hideShowBtn{{$hotel->id}}" class="btn btn-danger" onclick="showHideHotel(event, {{$hotel->id}})">Hide</button>
                           @else
                           <button id="hideShowBtn{{$hotel->id}}" class="btn btn-success" onclick="showHideHotel(event, {{$hotel->id}})">Show</button>
                           @endif
                         </td>
                       </tr>
                     @endforeach
                   </tbody>
                </table>
             </div>
             <div class="text-center">
               {{$hotels->appends(['term' => $term])->links()}}
             </div>
          </div>
          @endif
        </div>
     </div>
  </main>
  @includeif('admin.hotel.ajaxFunctions')
@endsection
