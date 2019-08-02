<div class="row">
  <div class="col-sm-12">
    <h2 class="base-txt my-2">Give a review</h2>
    <form class="" action="{{route('user.room.review')}}" method="post">
      {{csrf_field()}}
      <input type="hidden" name="room_id" value="{{$room->id}}">
      <div class="form-group">
        <label for="">Rating out of 5</label>
        <input type="text" class="form-control form-control" name="rating" value="" autocomplete="off">
        <small>Minimum 1 & Maximum 5</small>
        @if ($errors->has('rating'))
          <p class="em no-margin">{{$errors->first('rating')}}</p>
        @endif
      </div>
      <div class="form-group">
        <label for="">Comment</label>
        <textarea name="comment" class="form-control" rows="5" cols="120"></textarea>
        @if ($errors->has('comment'))
          <p class="em no-margin">{{$errors->first('comment')}}</p>
        @endif
      </div>
      <div class="form-group text-center">
        <button type="submit" class="book-now">Submit</button>
      </div>
    </form>
  </div>
</div>
