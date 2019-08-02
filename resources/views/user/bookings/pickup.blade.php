@extends('user.layout.master')
@section('title', 'Pickup Car Bookings')
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
              <h2 class="caption no-margin" style="margin-bottom:30px;">Pickup Car Bookings</h2>
            </div>
            <div class="card-body">
              <table id="room-table" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                      <tr>
                         <th>Car Title</th>
                         <th>Pickup Location</th>
                         <th>Dropoff Location</th>
                         <th scope="col">Payment</th>
                         <th scope="col">Booking Date</th>
                         <th scope="col">Pickup Date</th>
                         <th scope="col">Pickup Time</th>
                         <th>Rejection Request</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($pickupbookings as $pickupcarbooking)
                      <tr>
                         <td><a target="_blank" href="{{route('user.pickup.show', $pickupcarbooking->pickup_car_id)}}">{{strlen($pickupcarbooking->pickup_car->title) > 24 ? substr($pickupcarbooking->pickup_car->title, 0, 24) . '...' : $pickupcarbooking->pickup_car->title}}</a></td>
                         <td data-label="Mobile">{{$pickupcarbooking->pickup_car->pickup_location}}</td>
                         <td data-label="Mobile">{{$pickupcarbooking->location}}</td>
                         <td data-label="Mobile">{{$pickupcarbooking->price}} {{$gs->base_curr_text}}</td>
                         <td data-label="Balance">{{date('jS F, Y' ,strtotime($pickupcarbooking->created_at))}}</td>
                         <td data-label="Balance">{{date('jS F, Y' ,strtotime($pickupcarbooking->pickup_date))}}</td>
                         <td data-label="Balance" style="text-transform:uppercase;">{{$pickupcarbooking->pickup_time}}</td>
                         <td>
                           <button class="btn btn-{{empty($pickupcarbooking->message)?'primary':'warning'}} btn-sm" type="button" data-toggle="modal" data-target="#pickupmodal{{$pickupcarbooking->id}}">
                             <i class="fa fa-envelope"></i> {{empty($pickupcarbooking->message)?'Message':'Change Message'}}
                           </button>
                         </td>
                      </tr>

                      <!-- Modal -->
                      <div class="modal fade" id="pickupmodal{{$pickupcarbooking->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <form class="" action="{{route('user.pickup.message')}}" method="post">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Rejection Request</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">

                                {{csrf_field()}}
                                <input type="hidden" name="pickup_car_id" value="{{$pickupcarbooking->pickup_car_id}}">
                                <div class="form-group">
                                  <label for="">Reason <span class="required">**</span></label>
                                  <textarea class="form-control" name="reason" rows="5" required>{{empty($pickupcarbooking->message)?'':$pickupcarbooking->message}}</textarea>
                                </div>

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">{{empty($pickupcarbooking->message)?'Send Request':'Update Request'}}</button>
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
