<?php
 $LINEData = file_get_contents('php://input');
 $jsonData = json_decode($LINEData,true);
 $replyToken = $jsonData["events"][0]["replyToken"];
 $text = $jsonData["events"][0]["message"]["text"];

 function sendMessage($replyJson, $token){
         $ch = curl_init($token["URL"]);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLINFO_HEADER_OUT, true);
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
             'Content-Type: application/json',
             'Authorization: Bearer ' . $token["AccessToken"])
             );
         curl_setopt($ch, CURLOPT_POSTFIELDS, $replyJson);
         $result = curl_exec($ch);
         curl_close($ch);
   return $result;
 }

 if ($text == "s"){
     $message = '{
     "type" : "sticker",
     "packageId" : 11537,
     "stickerId" : 52002744
     }';
     $replymessage = json_decode($message);
 }
 else if ($text == "image"){
   $message = '{
     "type": "image",
     "originalContentUrl": "https://linefriends.com/img/bangolufsen/img_og.jpg",
     "previewImageUrl": "https://linefriends.com/img/bangolufsen/img_og.jpg"
     }';
     $replymessage = json_decode($message);
 }
 else if ($text == "l"){
   $message = '{
     "type": "location",
     "title": "my location",
     "address": "〒150-0002 東京都渋谷区渋谷２丁目２１−１",
     "latitude": 35.65910807942215,
     "longitude": 139.70372892916203
     }';
     $replymessage = json_decode($message);
 }
 else if ($text == "a"){
   $message = '{
     "type" : "audio",
     "originalContentUrl": "https://mokmoon.com/audios/line.mp3",
     "duration" : 1000
     }';
     $replymessage = json_decode($message);
 }
 else if ($text == "v"){
   $message = '{
     "type" : "video",
     "originalContentUrl" : "https://mokmoon.com/videos/Brown.mp4",
     "previewImageUrl" : "https://linefriends.com/img/bangolufsen/img_og.jpg"
     }';
     $replymessage = json_decode($message);
 }
 else if ($text == "q"){
   $message = '{
     "type": "text",
     "text": "Hello Quick Reply!",
     "quickReply": {
      "items": [
       {
        "type": "action",
        "action": {
         "type":"location",
         "label":"Location"
        }
       }
      ]
     } 
     }';
     $replymessage = json_decode($message);
 }
 else{
   $message = '{
       "type" : "text",
       "text" : "ไม่มีข้อมูลที่ต้องการ"
       }';
       $replymessage = json_decode($message);
 }

 $lineData['URL'] = "https://api.line.me/v2/bot/message/reply";
 $lineData['AccessToken'] = "uk/L6utfDDVmjmyUPvpMNcPSZGlxpoISOTZkXKl/vJwa96i/LagRdgSJm/gF/zHr9CLze1cTVbfDfr0EY9o/m+IXwYYJHEnyXBJQJSYhSBmnYFT7uadgTD0aipJPbcHNa/gRNklx75aF0G1sVZQx1wdB04t89/1O/w1cDnyilFU=";
 $replyJson["replyToken"] = $replyToken;
 $replyJson["messages"][0] = $replymessage;

 $encodeJson = json_encode($replyJson);

 $results = sendMessage($encodeJson,$lineData);
 echo $results;
 http_response_code(200);
?>