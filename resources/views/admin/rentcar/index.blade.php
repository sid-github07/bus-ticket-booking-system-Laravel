@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>All Rent Cars Management</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
          @if (count($rentcars) == 0)
          <div class="tile">
            <h3 class="tile-title pull-left">Rent Cars List</h3>
            <div class="pull-right icon-btn">
               <form method="GET" class="form-inline" action="{{route('admin.rentcar.index')}}">
                  <input type="text" name="term" class="form-control" placeholder="Search by rentcar name">
                  <button class="btn btn-outline btn-circle  green" type="submit"><i
                     class="fa fa-search"></i></button>
               </form>
            </div>
            <p style="clear:both;margin:0px;"></p>
            <h2 class="text-center">NO RENT CAR FOUND</h2>
          </div>
          @else
          <div class="tile">
             <h3 class="tile-title pull-left">Rent Cars List</h3>
             <div class="pull-right icon-btn">
                <form method="GET" class="form-inline" action="{{route('admin.rentcar.index')}}">
                   <input type="text" name="term" class="form-control" placeholder="Search by rentcar name">
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
                         <th scope="col">Payment/Day</th>
                         <th scope="col">Capacity (Adults)</th>
                         <th scope="col">Action</th>
                      </tr>
                   </thead>
                   <tbody>
                     @foreach ($rentcars as $rentcar)
                       <tr>
                         <td>{{$loop->iteration}}</td>
                         <td><a target="_blank" href="{{route('user.rentcar.show', $rentcar->id)}}">{{$rentcar->title}}</a></td>
                         <td>{{$rentcar->payment}}</td>
                         <td>{{$rentcar->capacity}}</td>
                         <td>
                           <a href="{{route('admin.rentcar.edit', $rentcar->id)}}" class="btn btn-warning"><i class="fa fa-pencil-square"></i> Edit</a>
                           @if ($rentcar->a_hidden == 0)
                           <button id="hideShowBtn{{$rentcar->id}}" class="btn btn-danger" onclick="showHideRent(event, {{$rentcar->id}})">Hide</button>
                           @else
                           <button id="hideShowBtn{{$rentcar->id}}" class="btn btn-success" onclick="showHideRent(event, {{$rentcar->id}})">Show</button>
                           @endif
                         </td>
                       </tr>
                     @endforeach
                   </tbody>
                </table>
             </div>
             <div class="text-center">
               {{$rentcars->appends(['term' => $term])->links()}}
             </div>
          </div>
          @endif
        </div>
     </div>
  </main>
  @includeif('admin.rentcar.ajaxFunctions')
@endsection
