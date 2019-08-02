<div class="ammenties-1">
  <div class="row">
    @foreach ($hotel->amenities as $amenity)
      <div class="col-md-4 col-sm-6">
        <p><i class="fa fa-{{$amenity->code}}"></i>{{$amenity->name}}</p>
      </div>
    @endforeach
  </div>

</div>
