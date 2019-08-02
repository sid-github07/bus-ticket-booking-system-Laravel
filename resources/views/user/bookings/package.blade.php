@extends('user.layout.master')
@section('title', 'Package Bookings')
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
              <h2 class="caption no-margin" style="margin-bottom:30px;">Package Bookings</h2>
            </div>
            <div class="card-body">
              <table id="package-table" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                      <tr>
                          <th>Package Title</th>
                          <th>Persons</th>
                          <th>Booking Date</th>
                          <th>Checkin Date</th>
                          <th>Total Price</th>
                          <th>Rejection Request</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($buypackages as $buypackage)
                      <tr>
                          <td><a target="_blank" href="{{route('user.package.show', $buypackage->package_id)}}">{{strlen($buypackage->package->name) > 24 ? substr($buypackage->package->name, 0, 24) . '...' : $buypackage->package->name}}</a></td>
                          <td>{{$buypackage->persons}}</td>
                          <td>{{date('jS F, Y' ,strtotime($buypackage->created_at))}}</td>
                          <td>{{date('jS F, Y' ,strtotime($buypackage->checkin_date))}}</td>
                          <td>{{$buypackage->persons*$buypackage->package->price}} {{$gs->base_curr_text}}</td>
                          <td>
                            <button class="btn btn-{{empty($buypackage->message)?'primary':'warning'}} btn-sm" type="button" data-toggle="modal" data-target="#packagemodal{{$buypackage->id}}">
                              <i class="fa fa-envelope"></i> {{empty($buypackage->message)?'Message':'Change Message'}}
                            </button>
                          </td>
                      </tr>

                      <!-- Modal -->
                      <div class="modal fade" id="packagemodal{{$buypackage->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <form class="" action="{{route('user.package.message')}}" method="post">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Rejection Request</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">

                                {{csrf_field()}}
                                <input type="hidden" name="package_id" value="{{$buypackage->package_id}}">
                                <div class="form-group">
                                  <label for="">Reason <span class="required">**</span></label>
                                  <textarea class="form-control" name="reason" rows="5" required>{{empty($buypackage->message)?'':$buypackage->message}}</textarea>
                                </div>

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">{{empty($buypackage->message)?'Send Request':'Update Requset'}}</button>
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
    $('#package-table').DataTable();
} );
</script>
@endpush
