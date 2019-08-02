@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>
             @if (request()->path() == 'admin/package/all')
             All
             @elseif (request()->path() == 'admin/package/rejected')
             Rejected
             @endif
             @if (request()->path() == 'admin/package/rejrequest')
               Rejection Reuqest of
             @endif
             Package Bookings

           </h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
          @if (count($buypackages) == 0)
            <div class="tile">
              <h2 class="text-center">
                NO DATA FOUND
              </h2>
            </div>
          @else
            <div class="tile">
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <tr>
                           <th>Serial</th>
                           <th>Package Title</th>
                           <th scope="col">Username</th>
                           <th scope="col">Phone</th>
                           <th scope="col">Persons</th>
                           <th scope="col">Booking Date</th>
                           <th scope="col">Checkin Date</th>
                           <th scope="col">Total Price</th>
                           @if (request()->path() == 'admin/package/rejrequest')
                           <th scope="col">Reason</th>
                           @endif
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                       @php
                         $i = 0;
                       @endphp
                       @foreach ($buypackages as $buypackage)
                         <tr>
                            <td>{{++$i}}</td>
                            <td><a target="_blank" href="{{route('user.package.show', $buypackage->package_id)}}">{{$buypackage->package->name}}</a></td>
                            <td data-label="Name"><a target="_blank" href="{{route('admin.userDetails', $buypackage->user_id)}}">{{$buypackage->user->username}}</a></td>
                            <td data-label="Email">{{$buypackage->user->phone}}</td>
                            <td data-label="Username">{{$buypackage->persons}}</td>
                            <td data-label="Balance">{{date('jS F, Y' ,strtotime($buypackage->created_at))}}</td>
                            <td data-label="Balance">{{date('jS F, Y' ,strtotime($buypackage->checkin_date))}}</td>
                            <td data-label="Mobile">{{$buypackage->persons*$buypackage->package->price}} {{$gs->base_curr_text}}</td>
                            @if (request()->path() == 'admin/package/rejrequest')
                            <td>
                              <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#reason{{$buypackage->id}}">
                                <i class="fa fa-eye"></i> Show
                              </button>
                            </td>
                            @endif
                            <td>
                              @if ($buypackage->status == 0)
                                <form class="inline-block" action="{{route('admin.package.reject')}}" method="post">
                                  {{csrf_field()}}
                                  <input type="hidden" name="userid" value="{{$buypackage->user_id}}">
                                  <input type="hidden" name="buypackageid" value="{{$buypackage->id}}">
                                  <input type="hidden" name="packageid" value="{{$buypackage->package_id}}">
                                  <button type="submit" class="btn btn-danger" name="button"><i class="fa fa-times"></i> Reject</button>
                                </form>
                              @endif
                              @if ($buypackage->status == -1)
                                <form class="inline-block" action="{{route('admin.package.accept')}}" method="post">
                                  {{csrf_field()}}
                                  <input type="hidden" name="userid" value="{{$buypackage->user_id}}">
                                  <input type="hidden" name="buypackageid" value="{{$buypackage->id}}">
                                  <input type="hidden" name="packageid" value="{{$buypackage->package_id}}">
                                  <button type="submit" class="btn btn-success" name="button"><i class="fa fa-check"></i> Accept</button>
                                </form>
                              @endif

                              <a target="_blank" href="{{route('admin.emailToUser', $buypackage->user_id)}}" class="btn btn-warning"><i class="fa fa-envelope"></i> Send Mail</a>
                            </td>
                         </tr>

                         @if (request()->path() == 'admin/package/rejrequest')
                           <!-- Modal -->
                            <div class="modal fade" id="reason{{$buypackage->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Reason</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    {{$buypackage->message}}
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                         @endif

                       @endforeach
                     </tbody>
                  </table>
               </div>
               <div class="text-center">
                 {{$buypackages->links()}}
               </div>
            </div>
          @endif
        </div>
     </div>
  </main>
@endsection
