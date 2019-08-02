<div class="ammenties-1">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        @foreach ($pickup->dropofflocs as $dropoff)
          <div class="col-md-12">
            <p><i class="fa fa-map-marker"></i>{{$dropoff->location}} ({{$gs->base_curr_symbol}} {{$dropoff->price}})
            </p>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
