<?php
 $LINEData = file_get_contents('php://input');
 $jsonData = json_decode($LINEData,true);
 $replyToken = $jsonData["events"][0]["replyToken"];
 $text = $jsonData["events"][0]["message"]["text"];
 
 $servername = "localhost";
 $username = "mkictne1_testbot";
 $password = "testbot";
 $dbname = "mkictne1_testbot";
 $mysql = new mysqli($servername, $username, $password, $dbname);
 mysqli_set_charset($mysql, "utf8");
 
 if ($mysql->connect_error){
 $errorcode = $mysql->connect_error;
 print("MySQL(Connection)> ".$errorcode);
 }
 

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
 $text = "หมา";
 $getUser = $mysql->query("SELECT * FROM test WHERE question='".$text."'");
 $getuserNum = $getUser->num_rows;
// echo $getuserNum ;
 //echo "SELECT * FROM test WHERE question='".$text."'";
 //echo "<br>";
 if ($getuserNum == "0"){
     $message = '{
     "type" : "text",
     "text" : "ไม่มีข้อมูลที่ต้องการ""
     }';
     $replymessage = json_decode($message);
 }else{
  
   while($row = $getUser->fetch_assoc()){
     $question = $row['question'];
     $result = $row['result'];
   }
   $replymessage["type"] = "text";
   $replymessage["text"] = $question." ".$result;
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