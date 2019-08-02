@extends('user.layout.master')
@section('title', 'Room Bookings')
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
              <h2 class="caption no-margin" style="margin-bottom:30px;">Room Bookings</h2>
            </div>
            <div class="card-body">
              <table id="room-table" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                      <tr>
                          <th>Room Name</th>
                          <th>Hotel Name</th>
                          <th>Total Price</th>
                          <th>Booking Date</th>
                          <th>Checkin Date</th>
                          <th>Duration</th>
                          <th>Rejection Request</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($roombookings as $roombooking)
                      <tr>
                          <td><a target="_blank" href="{{route('user.room.show', $roombooking->room_id)}}">{{strlen($roombooking->room->name) > 24 ? substr($roombooking->room->name, 0, 24) . '...' : $roombooking->room->name}}</a></td>
                          <td><a target="_blank" href="{{route('user.hotel.show', $roombooking->room->hotel_id)}}">{{strlen($roombooking->room->hotel->name) > 24 ? substr($roombooking->room->hotel->name, 0, 24) . '...' : $roombooking->room->hotel->name}}</a></td>
                          <td>{{$roombooking->payment*$roombooking->duration}} {{$gs->base_curr_text}}</td>
                          <td data-label="Balance">{{date('jS F, Y' ,strtotime($roombooking->created_at))}}</td>
                          <td data-label="Balance">{{date('jS F, Y' ,strtotime($roombooking->checkin_date))}}</td>
                          <td data-label="Balance">{{$roombooking->duration}} days</td>
                          <td>
                            <button class="btn btn-{{empty($roombooking->message)?'primary':'warning'}} btn-sm" type="button" data-toggle="modal" data-target="#roommodal{{$roombooking->id}}">
                              <i class="fa fa-envelope"></i> {{empty($roombooking->message)?'Message':'Change Message'}}
                            </button>
                          </td>
                      </tr>

                      <!-- Modal -->
                      <div class="modal fade" id="roommodal{{$roombooking->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <form class="" action="{{route('user.room.message')}}" method="post">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Rejection Request</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">

                                {{csrf_field()}}
                                <input type="hidden" name="room_id" value="{{$roombooking->room_id}}">
                                <div class="form-group">
                                  <label for="">Reason <span class="required">**</span></label>
                                  <textarea class="form-control" name="reason" rows="5" required>{{empty($roombooking->message)?'':$roombooking->message}}</textarea>
                                </div>

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">{{empty($roombooking->message)?'Send Request':'Update Request'}}</button>
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
    $('#room-table').DataTable();
} );
</script>
@endpush
