@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>All Rooms Management</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
          @if (count($rooms) == 0)
          <div class="tile">
            <h3 class="tile-title pull-left" style="display:inline-block;">Rooms List</h3>
            <div class="pull-right icon-btn">
              <a class="btn btn-info" href="{{route('admin.hotel.index')}}">
                <i class="fa fa-list"></i>
                All Hotels
              </a>
               <form method="GET" class="form-inline" action="{{route('admin.allUsersSearchResult')}}" style="display:inline-block;">
                  <input type="text" name="term" class="form-control" placeholder="Search by room name">
                  <button class="btn btn-outline btn-circle  green" type="submit"><i
                     class="fa fa-search"></i></button>
               </form>
            </div>
            <p style="clear:both;margin:0px;"></p>
            <h2 class="text-center">NO ROOM FOUND</h2>
          </div>
          @else
          <div class="tile">
             <h3 class="tile-title pull-left" style="display:inline-block;">Rooms List</h3>
             <div class="pull-right icon-btn">
               <a class="btn btn-info" href="{{route('admin.hotel.index')}}">
                 <i class="fa fa-list"></i>
                 All Hotels
               </a>
                <form method="GET" class="form-inline" action="{{route('admin.allUsersSearchResult')}}" style="display:inline-block;">
                   <input type="text" name="term" class="form-control" placeholder="Search by room name">
                   <button class="btn btn-outline btn-circle  green" type="submit"><i
                      class="fa fa-search"></i></button>
                </form>
             </div>
             <div class="table-responsive">
                <table class="table">
                   <thead>
                      <tr>
                         <th scope="col">Serial</th>
                         <th scope="col">Room Name</th>
                         <th scope="col">No of persons (Adults)</th>
                         <th scope="col">Payment({{$gs->base_curr_text}})/night</th>
                         @if (request()->path() == 'admin/room/rejrequest')
                         <th scope="col">Reason</th>
                         @endif
                         <th scope="col">Action</th>
                      </tr>
                   </thead>
                   <tbody>
                     @foreach ($rooms as $room)
                       <tr>
                         <td>{{$loop->iteration}}</td>
                         <td>{{$room->name}}</td>
                         <td>{{$room->no_of_persons}}</td>
                         <td>{{$room->payment}}</td>
                         <td>
                           <a href="{{route('admin.room.edit', $room->id)}}" class="btn btn-warning"><i class="fa fa-pencil-square"></i> Edit</a>
                           @if ($room->a_hidden == 0)
                           <button id="hideShowBtn{{$room->id}}" class="btn btn-danger" onclick="showHideRoom(event, {{$room->id}})">Hide</button>
                           @else
                           <button id="hideShowBtn{{$room->id}}" class="btn btn-success" onclick="showHideRoom(event, {{$room->id}})">Show</button>
                           @endif
                         </td>
                       </tr>
                     @endforeach
                   </tbody>
                </table>
             </div>
             <div class="text-center">
               {{$rooms->appends(['term' => $term])->links()}}
             </div>
          </div>
          @endif
        </div>
     </div>
  </main>
  @includeif('admin.room.ajaxFunctions')
@endsection
