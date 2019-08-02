@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>
             @if (request()->path() == 'admin/lounge/all')
             All
           @elseif (request()->path() == 'admin/lounge/rejected')
             Rejected
             @endif
             @if (request()->path() == 'admin/lounge/rejrequest')
               Rejection Reuqest of
             @endif
             Lounge Bookings
           </h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
          @if (count($loungebookings) == 0)
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
                           <th scope="col">Username</th>
                           <th scope="col">Phone</th>
                           <th>Lounge Name</th>
                           <th scope="col">Total Payment</th>
                           <th scope="col">Persons</th>
                           <th scope="col">Booking Date</th>
                           <th scope="col">Checkin Date</th>
                           <th scope="col">Checkin Time</th>
                           @if (request()->path() == 'admin/lounge/rejrequest')
                           <th scope="col">Reason</th>
                           @endif
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                       @php
                         $i = 0;
                       @endphp
                       @foreach ($loungebookings as $loungebooking)
                         <tr>
                            <td>{{++$i}}</td>
                            <td data-label="Name"><a target="_blank" href="{{route('admin.userDetails', $loungebooking->user_id)}}">{{$loungebooking->user->username}}</a></td>
                            <td data-label="Email">{{$loungebooking->user->phone}}</td>
                            <td><a target="_blank" href="{{route('user.lounge.show', $loungebooking->lounge_id)}}">{{$loungebooking->lounge->name}}</a></td>
                            <td data-label="Mobile">{{$loungebooking->lounge->price*$loungebooking->persons}} {{$gs->base_curr_text}}</td>
                            <td data-label="Mobile">{{$loungebooking->persons}}</td>
                            <td data-label="Balance">{{date('jS F, Y' ,strtotime($loungebooking->created_at))}}</td>
                            <td data-label="Balance">{{date('jS F, Y' ,strtotime($loungebooking->checkin_date))}}</td>
                            <td data-label="Balance" style="text-transform:uppercase;">{{$loungebooking->checkin_time}}</td>
                            @if (request()->path() == 'admin/lounge/rejrequest')
                            <td>
                              <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#reason{{$loungebooking->id}}">
                                <i class="fa fa-eye"></i> Show
                              </button>
                            </td>
                            @endif
                            <td>
                              @if ($loungebooking->status == 0)
                                <form class="inline-block" action="{{route('admin.lounge.reject')}}" method="post">
                                  {{csrf_field()}}
                                  <input type="hidden" name="userid" value="{{$loungebooking->user_id}}">
                                  <input type="hidden" name="loungebookingid" value="{{$loungebooking->id}}">
                                  <input type="hidden" name="loungeid" value="{{$loungebooking->lounge_id}}">
                                  <button type="submit" class="btn btn-danger" name="button"><i class="fa fa-times"></i> Reject</button>
                                </form>
                              @endif
                              @if ($loungebooking->status == -1)
                                <form class="inline-block" action="{{route('admin.lounge.accept')}}" method="post">
                                  {{csrf_field()}}
                                  <input type="hidden" name="userid" value="{{$loungebooking->user_id}}">
                                  <input type="hidden" name="loungebookingid" value="{{$loungebooking->id}}">
                                  <input type="hidden" name="loungeid" value="{{$loungebooking->lounge_id}}">
                                  <button type="submit" class="btn btn-success" name="button"><i class="fa fa-check"></i> Accept</button>
                                </form>
                              @endif

                              <a target="_blank" href="{{route('admin.emailToUser', $loungebooking->user_id)}}" class="btn btn-warning"><i class="fa fa-envelope"></i> Send Mail</a>
                            </td>
                         </tr>

                         @if (request()->path() == 'admin/lounge/rejrequest')
                           <!-- Modal -->
                            <div class="modal fade" id="reason{{$loungebooking->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Reason</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    {{$loungebooking->message}}
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
                 {{$loungebookings->links()}}
               </div>
            </div>
          @endif
        </div>
     </div>
  </main>
@endsection
