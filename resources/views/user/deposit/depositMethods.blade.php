@extends('user.layout.master')

@section('title', 'Deposit Methods')

@push('styles')
<style media="screen">
  .gateways-container {
    padding: 150px 0px 0px 0px;
  }
  .list-group-item {
    font-size: 13px;
  }
</style>
@endpush

@section('content')
  <div class="gateways-container">
    <div class="container">
        <h2 style="margin-bottom:30px;" class="text-center">Select Payment Gateway</h2>
        @foreach ($gateways as $gateway)
          @if ($loop->iteration % 4 == 1)
          <div class="row"> {{-- .row start --}}
          @endif
          <div class="col-md-3">
            <div class="card">
              <div class="" style="padding:5px;">
                <img class="card-img-top" src="{{asset('assets/gateway/'.$gateway->id. '.jpg')}}" alt="Card image cap">
              </div>
              <div class="card-body">
                <h5 class="card-title">{{$gateway->name}}</h5>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>LIMIT: </strong>{{$gateway->minamo}} - {{$gateway->maxamo}} {{$gs->base_curr_text}}</li>
                <li class="list-group-item"><strong>Charge: </strong> {{$gateway->fixed_charge}} {{$gs->base_curr_text}} + {{$gateway->percent_charge}}  %</li>
              </ul>
              <div class="card-body">
                <button class="btn btn-block btn-primary" type="button" name="button" data-toggle="modal" data-target="#depositModal{{$gateway->id}}">Deposit Now</button>
              </div>
            </div>
          </div>
          <!-- Deposit Amount Modal -->
          <div class="modal fade" id="depositModal{{$gateway->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <form class="modal-content" method="post" action="{{route('users.depositDataInsert')}}" enctype="multipart/form-data">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Deposit  via {{$gateway->name}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    @if ($gateway->id > 899)
                      <strong style="color:black;">Payment Details</strong> <small>(Send Here)</small><br>
                      <div class="">
                        {!! nl2br($gateway->val3) !!}
                      </div>
                    @endif
                  {{-- <form method="post" action="{{route('user.deposit.preview')}}"> --}}
                    {{csrf_field()}}
                    <input type="hidden" name="gateway" value="{{$gateway->id}}">
                    <div class="form-group">
                      <label for="exampleInputEmail1" style="color:black;"><strong>Amount</strong></label>
                      {{-- <input name="amount" type="text" class="form-control" placeholder="Enter Amount" required> --}}
                      <div class="input-group mb-3">
                        <input name="amount" type="text" class="form-control" placeholder="Enter Amount" required>
                        <div class="input-group-append">
                          <span class="input-group-text" id="basic-addon2">{{$gs->base_curr_text}}</span>
                        </div>
                      </div>
                    </div>

                    @if ($gateway->id > 899)
                      <div class="fileinput fileinput-new" data-provides="fileinput">
                          <div class="fileinput-new thumbnail">
                              <img src="" alt="" />
                          </div>
                          <div class="fileinput-preview fileinput-exists thumbnail" style="width: 250px;"> </div>

                          <div>
                              <span class="btn btn-success btn-file">
                                  <span class="fileinput-new"> Receipt Image </span>
                                  <span class="fileinput-exists"> Change </span>
                                  <input type="file" name="receipt">
                              </span>
                              <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> Remove </a>
                          </div>
                      </div>
                    @endif
                  {{-- </form> --}}
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Preview</button>
                </div>
              </form>
            </div>
          </div>
          @if ($loop->iteration % 4 == 0)
          </div> {{-- .row end --}}
          <br>
          @endif

        @endforeach
    </div>
  </div>
  <br><br>
@endsection
