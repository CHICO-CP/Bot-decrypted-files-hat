<?php
/* 
Grupo : @Decrypt_Files
Desarrollador : @CHICO_CP
*/
error_reporting(0);
$API_KEY ="6551770885:AAEGkl4bn8wy2SgNdIb-QrOqB4JlJXAQVKE";
define("API_KEY","$API_KEY");
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}

/* 
Grupo : @Decrypt_Files
Desarrollador : @CHICO_CP

*/
function aes_ecb_decrypt($data, $key) {
$data = base64_decode("$data");
    $cipher = "aes-128-ecb";
    $decrypted = openssl_decrypt($data, $cipher, $key, OPENSSL_RAW_DATA);
    return $decrypted;
}
function aes_ecb_en($data, $key) {
    $cipher = "aes-128-ecb";
    $decrypted = openssl_encrypt($data, $cipher, $key, OPENSSL_RAW_DATA);
    return $decrypted;
}
function getFile($file_id){
	return json_decode(file_get_contents('https://api.telegram.org/bot'.API_KEY.'/getFile?file_id='.$file_id));
}
$update = json_decode(file_get_contents('php://input'));
if(isset($update->message)){
    $message = $update->message; 
    $chat_id = $message->chat->id;
    $text = $message->text;
    $message_id = $message->message_id;
    $from_id = $message->from->id;
    $caption = $message->caption;
}
/* 
Grupo : @Decrypt_Files
Desarrollador : @CHICO_CP
*/
if(isset($update->message->document)){
	$file_name=$update->message->document->file_name;

	if(strstr($file_name,'.hat')){
		$file_id=$update->message->document->file_id;
		$get_file=getFile($file_id)->result;
		$file_path=$get_file->file_path;   
		$r = rand (1111,9999);
		file_put_contents("$r.hat",file_get_contents('https://api.telegram.org/file/bot'.API_KEY.'/'.$file_path));
        $file = file_get_contents("$r.hat");
        $key = base64_decode("zbNkuNCGSLivpEuep3BcNA==");
$data = json_decode(aes_ecb_decrypt("$file","$key"),true);
if($caption==""){
$cap="NuLL";
}else{
$cap=$caption;
}
$data['descriptionv5'] = "$cap";
$data['protextras']['password'] = false;
$data['protextras']['expiry'] = false;
$data['protextras']['id_lock'] = false;
$data['protextras']['block_root'] = false;
$data['protextras']['anti_sniff'] = false;
$data = json_encode($data);
$code= base64_encode(aes_ecb_en("$data","$key"));
file_put_contents("$r.hat","$code");
$cp = "
├ • Developer : bit.ly/jhkhw
├ • ┅┅━━━━ 𖣫 ━━━━┅┅ •
├ • 🔑 Expiry Time  :  Disabled
├ • 🔑 ID_Lock :  Disabled
├ • 🔑 Password :  Disabled
├ • 🔑 Block_Root :  Disabled
├ • ┅┅━━━━ 𖣫 ━━━━┅┅ •
├ • 🔑 Description : $cap
├ • ┅┅━━━━ 𖣫 ━━━━┅┅ •
├ • BoT ID : @decryptfilescpBot
";
    bot('sendDocument',[
    'chat_id'=>$chat_id,
    'document'=>new CURLFile("$r.hat"),
    'caption'=>$cp,
    ]);
	}
	unlink ("$r.hat");
}
/* 
Grupo : @Decrypt_Files
Desarrollador : @CHICO_CP
*/
if($text == '/start'){
bot('sendmessage', [
'chat_id' => $chat_id,
'text' =>"
<strong>
<u> 𝐁𝐢𝐞𝐧𝐯𝐞𝐧𝐢𝐝𝐨, 𝐞𝐬𝐭𝐞 𝐛𝐨𝐭 𝐞𝐬𝐭𝐚 𝐡𝐞𝐜𝐡𝐨 𝐜𝐨𝐧 𝐟𝐢𝐧𝐞𝐬 𝐝𝐞 𝐚𝐲𝐮𝐝𝐚𝐫 𝐚 𝐥𝐚𝐬 𝐩𝐞𝐫𝐬𝐨𝐧𝐚𝐬 𝐚 𝐝𝐞𝐬𝐜𝐢𝐟𝐫𝐚𝐫 𝐬𝐮𝐬 𝐚𝐫𝐜𝐡𝐢𝐯𝐨𝐬 👑</u>

👑 𝐃𝐞𝐬𝐜𝐢𝐟𝐫𝐚 𝐚𝐫𝐜𝐡𝐢𝐯𝐨𝐬 𝐇𝐚𝐭 𝐚𝐥 𝐢𝐧𝐬𝐭𝐚𝐧𝐭𝐞.

📨 𝐄𝐧𝐯𝐢𝐚 𝐭𝐮𝐬 𝐚𝐫𝐜𝐡𝐢𝐯𝐨𝐬 𝐲 𝐫𝐞𝐜𝐢𝐛𝐞 𝐜𝐨𝐧𝐟𝐢𝐠𝐮𝐫𝐚𝐜𝐢𝐨𝐧𝐞𝐬 𝐝𝐞𝐭𝐚𝐥𝐥𝐚𝐝𝐚𝐬.

🔐 𝐓𝐮 𝐬𝐨𝐥𝐮𝐜𝐢𝐨𝐧 𝐞𝐟𝐢𝐜𝐢𝐞𝐧𝐭𝐞 𝐩𝐚𝐫𝐚 𝐝𝐞𝐬𝐞𝐧𝐜𝐫𝐲𝐩𝐭𝐚𝐫 𝐚𝐫𝐜𝐡𝐢𝐯𝐨𝐬.


👨‍💻 𝐃𝐞𝐬𝐚𝐫𝐫𝐨𝐥𝐥𝐚𝐝𝐨 𝐩𝐨𝐫 @CHICO_CP

🌐 𝐔𝐧𝐞𝐭𝐞 𝐚 𝐦𝐢 𝐜𝐨𝐦𝐮𝐧𝐢𝐝𝐚𝐝: t.me/file_decryptors</strong>

",
'parse_mode'=>"html",
]);
}

/* 
Grupo : @Decrypt_Files
Desarrollador : @CHICO_CP
*/