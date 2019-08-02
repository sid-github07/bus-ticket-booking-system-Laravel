<!--Bootstrap JS-->
<script src="{{asset('assets/user/js/bootstrap.min.js')}}"></script>
<!--Counter JS-->
<script src="{{asset('assets/user/js/plugins/waypoints.js')}}"></script>
<script src="{{asset('assets/user/js/plugins/jquery.counterup.min.js')}}"></script>
<!--Owl Carousel JS-->
<script src="{{asset('assets/user/js/plugins/owl.carousel.min.js')}}"></script>
<!--Venobox JS-->
<script src="{{asset('assets/user/js/plugins/venobox.min.js')}}"></script>
<!--Slick Slider JS-->
<script src="{{asset('assets/user/js/plugins/slick.min.js')}}"></script>
{{-- Sweet Alert JS --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
{{-- File input --}}
<script src="{{ asset('assets/plugins/bootstrap-fileinput.js') }}" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" type="text/javascript"></script>
<script src="{{asset('assets/plugins/jquery-timepicker/jquery.timepicker.min.js')}}"></script>
<!--Main-->
<script src="{{asset('assets/user/js/custom.js')}}"></script>

@if (session('success'))
<script type="text/javascript">
        $(document).ready(function(){
            swal("Success!", "{{ session('success') }}", "success");
        });
</script>
@endif

@if (session('alert'))
<script type="text/javascript">
        $(document).ready(function(){
            swal("Sorry!", "{{ session('alert') }}", "error");
        });
</script>
@endif

{{-- Increase Ad Views... --}}
<script>
   function increaseAdView(adID) {
      var fd = new FormData();
      fd.append('adID', adID);
      $.ajaxSetup({
          headers: {
              'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
          }
      });
      $.ajax({
         url: '{{route('ad.increaseAdView')}}',
         type: 'POST',
         data: fd,
         contentType: false,
         processData: false,
         success: function(data) {
            // console.log(data);
         }
      });
   }
</script>

@stack('scripts')
