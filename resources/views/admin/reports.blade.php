@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>Reports</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
          @if (count($reports) == 0)
            <div class="tile">
              <h2 class="text-center">NO REPORT FOUND</h2>
            </div>
          @else
            <div class="tile">
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <tr>
                           <th>Serial</th>
                           <th scope="col">Reporter Username</th>
                           <th scope="col">Product Owner</th>
                           <th scope="col">Product Title</th>
                           <th scope="col">Message</th>
                           <th scope="col">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                       @php
                         $i = 0;
                       @endphp
                       @foreach ($reports as $report)
                         <tr>
                            <td>{{++$i}}</td>
                            <td data-label="Name"><a target="_blank" href="{{route('admin.userDetails', $report->user->id)}}">{{\App\User::find($report->user->id)->username}}</a></td>
                            <td data-label="Name"><a target="_blank" href="{{route('admin.userDetails', $report->product->user->id)}}">{{\App\User::find($report->product->user->id)->username}}</a></td>
                            <td data-label="Email">
                              <a target="_blank" href="{{route('user.product.details', $report->product->id)}}">{{strlen($report->product->title) > 40 ? substr($report->product->title, 0, 40) . '...' : $report->product->title}}</a>
                            </td>
                            <td data-label="Username">
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#messagemodal{{$report->id}}">
                                <i class="fa fa-eye"></i> View
                              </button>
                            </td>
                            <td data-label="Balance">
                              <a href="{{route('admin.userDetails', $report->product->user->id)}}" class="btn btn-danger" target="_blank">Take Action</a>
                            </td>
                         </tr>

                         <!-- Modal -->
                         <div class="modal fade" id="messagemodal{{$report->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                           <div class="modal-dialog modal-dialog-centered" role="document">
                             <div class="modal-content">
                               <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalLongTitle">Complain</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                   <span aria-hidden="true">&times;</span>
                                 </button>
                               </div>
                               <div class="modal-body">
                                 <div class="well">
                                   {{$report->reason}}
                                 </div>
                               </div>
                               <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                               </div>
                             </div>
                           </div>
                         </div>
                       @endforeach
                     </tbody>
                  </table>
               </div>
               <div class="text-center">
                 {{$reports->links()}}
               </div>
            </div>
          @endif
        </div>
     </div>
  </main>
@endsection
