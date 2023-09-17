<?php
namespace App\Http\Services;
Class GatewaySms {

    public function SendVerifyCode($user_secret , $mob)
        {


  //  $user_name= "TEST";
    $userSender= "sender";
    $apiKey='d416d94cddf986c32ce6655df4d15ca0';
   
    $msg= " كود التحقق  الخاص :" .$user_secret;
    $fields = json_encode([
        // "userName"      => $user_name,
        "numbers"      => $mob,
        "userSender"   => $userSender,
        "apiKey"       => $apiKey,
        "msg"          => $msg
    ]);

    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://tweetsms.ps/api.php/maan/chk_user',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => 'api_key=d416d94cddf986c32ce6655df4d15ca0',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded'
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    // echo $response;
    


    

    // $response = curl_exec($ch);
    // $info = curl_getinfo($ch);
    // curl_close($ch);

    // $response = json_decode($response); 

    //         if ( $info["http_code"] == 200 )
    //          { 
    //           //  return mainResponse(true, 'Verification Code Sent Successfully', null, 200, 'data');
    //         return response([
    //             'message'=> 'Verification Code Sent Successfully',
    //             'status'=>200,
    //         ]);
    //           } 
    // else {
    //     $message =  $error = __('errors.success');
      
    //      return response()->json([
    //         'status' => false, 'code' => 203, 'message' => 'Verification Code Not Sent', null
    //     ]);
    //  }
}
    
}