@extends('user.layout.master')

@section('title', 'Deposit Preview')

@push('styles')
<style media="screen">
  .gimg {
    max-width:300px;
    max-height:300px;
    margin:0 auto;
  }
  @media screen and (max-width: 370px) {
    .gimg {
      width:100%;
      margin:0px;
    }
  }
</style>
@endpush

@section('content')
  <div class="row my-5">
  	<div class="col-md-12">
  		<div class="panel panel-inverse" style="padding:123px 0px;">
  			<div class="panel-heading">
  				<h3 class="panel-title text-center">{{$pt}}</h3>
  			</div>
  			<div class="panel-body">
          <div class="d-flex justify-content-center">
            <div  class="col-md-4 col-md-offset-4 text-center">
                <form  class="contact-form" method="POST" action="{{ route('deposit.confirm') }}">
                    {{csrf_field()}}
                    <input type="hidden" name="gateway" value="{{$data->gateway_id}}"/>
                    @if ($data->gateway_id > 899)
                      <input type="hidden" name="depositid" value="{{$data->id}}"/>
                      <input type="hidden" name="drid" value="{{$dr->id}}"/>
                    @endif
                    <div class="panel">
                        <div class="panel-body">
                            <ul class="list-group text-center">
                                <li class="list-group-item"><img src="{{asset('assets/gateway')}}/{{$data->gateway_id}}.jpg" class="gimg"/></li>
                                <li class="list-group-item">Amount: <strong>{{$data->amount}} </strong>{{$gs->base_curr_text}}</li>
                                <li class="list-group-item">Charge: <strong>{{$data->charge}} </strong>{{$gs->base_curr_text}}</li>
                                <li class="list-group-item">Payable: <strong>{{$data->charge + $data->amount}} </strong>{{$gs->base_curr_text}}</li>
                                <li class="list-group-item">In USD: <strong>${{$data->usd_amo}}</strong></li>
                            </ul>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary btn-block">
                                Pay Now
                            </button>
                        </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
      </div>
  </div>
@endsection
