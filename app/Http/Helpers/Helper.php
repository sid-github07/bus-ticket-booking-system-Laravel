<?php
use App\GeneralSetting as GS;
use App\Ad;


if (! function_exists('send_email')) {

    function send_email( $to, $name, $subject, $message)
    {
        $settings = GS::first();
        $template = $settings->email_template;
        $from = $settings->email_sent_from;
    		if($settings->email_notification == 1)
    		{

  			$headers = "From: $settings->website_title <$from> \r\n";
  			$headers .= "Reply-To: $settings->website_title <$from> \r\n";
  			$headers .= "MIME-Version: 1.0\r\n";
  			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

  			$mm = str_replace("{{name}}",$name,$template);
  			$message = str_replace("{{message}}",$message,$mm);

  			mail($to, $subject, $message, $headers);

    		}

    }
}

if (! function_exists('send_sms'))
{

    function send_sms( $to, $message)
    {
        $settings = GS::first();
		    if($settings->sms_notification == 1)
		{

			$sendtext = urlencode("$message");
		    $appi = $settings->sms_api;
			$appi = str_replace("{{number}}",$to,$appi);
			$appi = str_replace("{{message}}",$sendtext,$appi);
			$result = file_get_contents($appi);
		}

    }
}

if(!function_exists('show_ad')) {
  function show_ad($size) {
      $ad = Ad::where('size', $size)->inRandomOrder()->first();
      if (!empty($ad)) {

          if($size == 2){
              $maxwd = '728px';
          }else{
          $maxwd = '300px';
          }

        if ($ad->type == 1) {
          return '<a target="_blank" href="'.$ad->url.'" onclick="increaseAdView('.$ad->id.')"><img src="'.url('/').'/assets/user/ad_images/'.$ad->image.'" alt="Ad" style="width:100%; max-width:'.$maxwd.';"/></a>';
        }
        if($ad->type == 2) {
            return $ad->script;
        }
      } else {
        return '';
      }

  }
}
