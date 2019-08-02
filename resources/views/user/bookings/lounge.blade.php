@extends('user.layout.master')

@section('title', 'Lounge Bookings')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endpush

@section('content')
  <section class="justify-content-center" style="min-height: 755px;position: relative;margin-top: 170px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header base-bg">
              <h2 class="caption no-margin" style="margin-bottom:30px;">Lounge Bookings</h2>
            </div>
            <div class="card-body">
              <table id="lounge-table" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                       <th>Lounge Name</th>
                       <th scope="col">Total Payment</th>
                       <th scope="col">Persons</th>
                       <th scope="col">Booking Date</th>
                       <th scope="col">Checkin Date</th>
                       <th scope="col">Checkin Time</th>
                       <th>Rejection Request</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($loungebookings as $loungebooking)
                      <tr>
                         <td><a target="_blank" href="{{route('user.lounge.show', $loungebooking->lounge_id)}}">{{strlen($loungebooking->lounge->name) > 24 ? substr($loungebooking->lounge->name, 0, 24) . '...' : $loungebooking->lounge->name}}</a></td>
                         <td data-label="Mobile">{{$loungebooking->lounge->price*$loungebooking->persons}} {{$gs->base_curr_text}}</td>
                         <td data-label="Mobile">{{$loungebooking->persons}}</td>
                         <td data-label="Balance">{{date('jS F, Y' ,strtotime($loungebooking->created_at))}}</td>
                         <td data-label="Balance">{{date('jS F, Y' ,strtotime($loungebooking->checkin_date))}}</td>
                         <td data-label="Balance" style="text-transform:uppercase;">{{$loungebooking->checkin_time}}</td>
                         <td>
                           <button class="btn btn-{{empty($loungebooking->message)?'primary':'warning'}} btn-sm" type="button" data-toggle="modal" data-target="#loungemodal{{$loungebooking->id}}">
                             <i class="fa fa-envelope"></i> {{empty($loungebooking->message)?'Message':'Change Message'}}
                           </button>
                         </td>
                      </tr>

                      <!-- Modal -->
                      <div class="modal fade" id="loungemodal{{$loungebooking->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <form class="" action="{{route('user.lounge.message')}}" method="post">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Rejection Request</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">

                                {{csrf_field()}}
                                <input type="hidden" name="lounge_id" value="{{$loungebooking->lounge_id}}">
                                <div class="form-group">
                                  <label for="">Reason <span class="required">**</span></label>
                                  <textarea class="form-control" name="reason" rows="5" required>{{empty($loungebooking->message)?'':$loungebooking->message}}</textarea>
                                </div>

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">{{empty($loungebooking->message)?'Send Request':'Update Request'}}</button>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    $('#lounge-table').DataTable();
} );
</script>
@endpush
