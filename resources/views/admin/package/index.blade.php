@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>All Packages Management</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
          @if (count($packages) == 0)
          <div class="tile">
            <h3 class="tile-title pull-left">Packages List</h3>
            <div class="pull-right icon-btn">
               <form method="GET" class="form-inline" action="{{route('admin.package.index')}}">
                  <input type="text" name="term" class="form-control" placeholder="Search by package name">
                  <button class="btn btn-outline btn-circle  green" type="submit"><i
                     class="fa fa-search"></i></button>
               </form>
            </div>
            <p style="clear:both;margin:0px;"></p>
            <h2 class="text-center">NO PACKAGE FOUND</h2>
          </div>
          @else
          <div class="tile">
             <h3 class="tile-title pull-left">Packages List</h3>
             <div class="pull-right icon-btn">
                <form method="GET" class="form-inline" action="{{route('admin.package.index')}}">
                   <input type="text" name="term" class="form-control" placeholder="Search by package name">
                   <button class="btn btn-outline btn-circle  green" type="submit"><i
                      class="fa fa-search"></i></button>
                </form>
             </div>
             <div class="table-responsive">
                <table class="table">
                   <thead>
                      <tr>
                         <th scope="col">Serial</th>
                         <th scope="col">Name</th>
                         <th scope="col">Price ({{$gs->base_curr_text}})</th>
                         <th scope="col">Status</th>
                         <th scope="col">Action</th>
                      </tr>
                   </thead>
                   <tbody>
                     @foreach ($packages as $package)
                       <tr>
                         <td>{{$loop->iteration}}</td>
                         <td><a href="{{route('user.package.show', $package->id)}}" target="_blank">{{$package->name}}</a></td>
                         <td>{{$package->price}}</td>
                         <td>
                           @if (strtotime(date('Y-m-d')) < strtotime(date($package->start_date)))
                             <h4 style="display:inline-block;"><strong class="badge badge-info">Not Started</strong></h4>
                           @elseif (strtotime(date('Y-m-d')) >= strtotime(date($package->start_date)) && strtotime(date('Y-m-d')) <= strtotime(date($package->closing_date)))
                             <h4 style="display:inline-block;"><strong class="badge badge-success">Running</strong></h4>
                           @elseif (strtotime(date('Y-m-d')) > strtotime(date($package->closing_date)))
                             <h4 style="display:inline-block;"><strong class="badge badge-danger">Closed</strong></h4>
                           @endif
                         </td>
                         <td>
                           <a href="{{route('admin.package.edit', $package->id)}}" class="btn btn-warning"><i class="fa fa-pencil-square"></i> Edit</a>
                           @if ($package->a_hidden == 0)
                           <button id="hideShowBtn{{$package->id}}" class="btn btn-danger" onclick="showHidePackage(event, {{$package->id}})">Hide</button>
                           @else
                           <button id="hideShowBtn{{$package->id}}" class="btn btn-success" onclick="showHidePackage(event, {{$package->id}})">Show</button>
                           @endif
                         </td>
                       </tr>
                     @endforeach
                   </tbody>
                </table>
             </div>
             <div class="text-center">
               {{$packages->appends(['term' => $term])->links()}}
             </div>
          </div>
          @endif
        </div>
     </div>
  </main>
  @includeif('admin.package.ajaxFunctions')
@endsection
