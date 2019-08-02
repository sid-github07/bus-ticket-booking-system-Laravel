<div class="comments">
  <div class="row">
    <div class="col-md-12 text-center">
      <h2 class="mt-2" style="color:#f0932b">{{round(\App\RoomReview::where('room_id', $room->id)->avg('rating'), 2)}}/5.0</h2>
      Based on {{\App\RoomReview::where('room_id', $room->id)->count()}} reviews
    </div>
  </div>
  @foreach ($room->roomreviews()->orderBy('id', 'DESC')->get() as $roomreview)
    <div class="comment-wrap">
      <div class="photo">
        @if (empty($roomreview->user->pro_pic))
          <div class="avatar" style="background-image: url('{{asset('assets/user/img/pro-pic/nopic.png')}}')"></div>
        @else
          <div class="avatar" style="background-image: url('{{asset('assets/user/img/pro-pic/'.$roomreview->user->pro_pic)}}')"></div>
        @endif
      </div>
       <div class="comment-block">
          <p class="comment-text">
            {{$roomreview->comment}}
          </p>
          <div class="bottom-comment">
             <div class="comment-date">{{date('M d, Y @ g:i A', strtotime($roomreview->created_at))}}</div>
             <ul class="comment-actions">
                <div id="rateYo{{$roomreview->id}}"></div>
             </ul>
          </div>
       </div>
    </div>
    <script>
    $(document).ready(function() {
      $("#rateYo{{$roomreview->id}}").rateYo({
        rating: {{$roomreview->rating}},
        readOnly: true,
        starWidth: "16px"
      });
    });
    </script>
  @endforeach
</div>
