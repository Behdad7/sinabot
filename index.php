 
<?php
/**
 * Telegram Bot example.
 * @author Gabriele Grillo <gabry.grillo@alice.it>
 */
include("Telegram.php");
// Set the bot TOKEN
$bot_id = "258123864:AAGf0QayDyTslQ1-V5d3hb49nD3y0C1b424";
// Instances the class
$telegram = new Telegram($bot_id);
/* If you need to manually take some parameters
*  $result = $telegram->getData();
*  $text = $result["message"] ["text"];
*  $chat_id = $result["message"] ["chat"]["id"];
*/
// Take text and chat_id from the message

$result = $telegram->getData();
$msgid = $result["message"]["message_id"];

$text = $telegram->Text();
$img = curl_file_create('test.png','image/png'); 

$file = $telegram->getFile($file_id);
$telegram->downloadFile($file["file_path"], "./my_downloaded_file_on_local_server.png");

$chat_id = $telegram->ChatID();
$callback_query = $telegram->Callback_Query();
$category=array("مشاوره حقوقی","مشاوره کمک آموزشی","کامپیوتر","آشپزی","پزشکی و سلامتی","دام پزشک","مکانیک","برق و الکنترونیک","تاسیسات ساختمانی","مشاوره خانواده","مشاوره دینی","کشاورزی و باغداری");
// Check if the text is a command
if( !is_null($chat_id)){/* !is_null($text) && */
	if ($text == "/start" || $text == "🖱 منوی اصلی") {
		if ($telegram->messageFromGroup()) {
			$reply = "Chat Group";
		} else {
			$reply = " لطفا اگر توانایی و تخصص دارید به عنوان 🕵 سیناگو میشوم(/rega) در اٍبن سینا ثبت نام کنید. در غیر این صورت  🙋 سوال دارم(/haveq) را انتخاب کنید. ";
		}
	        // Create option for the custom keyboard. Array of array string
	        $option = array( array("🙋 سوال دارم", "🕵 سیناگو میشوم"), array("💻 پنل کاربری", "💻 پنل سیناگو"), array("📕 راهنمای") );
	        // Get the keyboard
		$keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true, $selective=true);
		$content = array('chat_id' => $chat_id,'parse_mode'=>'HTML', 'reply_markup' => $keyb, 'text' => $reply);
		$telegram->sendMessage($content);
	}
	else if ($text == "🕵 سیناگو میشوم" || $text == "/rega") {
	     $reply = "<b>مدارک مورد نیاز</b> \n1.تصویر مدرک تحصیلی یا حوزوی مرتبط\n2.شماره شبا جهت واریز مبلغ کارکرد\n3.شماره تماس متصل به تلگرام\n4.پذیرش تعهد نامه کاری "; 
		// Build the reply array
	    $content = array('chat_id' => $chat_id,'parse_mode'=>'HTML', 'text' => $reply);
	   // $telegram->sendMessage($content);
		
		$option = array(array($telegram->buildInlineKeyboardButton($category[0], "","arg0","")),
				array($telegram->buildInlineKeyboardButton($category[1],"","arg1","")),
				array($telegram->buildInlineKeyboardButton($category[2],"","arg2","")),
				array($telegram->buildInlineKeyboardButton($category[3],"","arg3","")),
				array($telegram->buildInlineKeyboardButton($category[4],"","arg4","")),
				array($telegram->buildInlineKeyboardButton($category[5],"","arg5","")),
				array($telegram->buildInlineKeyboardButton($category[6],"","arg6","")),
				array($telegram->buildInlineKeyboardButton($category[7],"","arg7","")),
				array($telegram->buildInlineKeyboardButton($category[8],"","arg8","")),
				array($telegram->buildInlineKeyboardButton($category[9],"","arg9","")),
				array($telegram->buildInlineKeyboardButton($category[10],"","arg10","")),
				array($telegram->buildInlineKeyboardButton($category[11],"","arg11","")));
		$keyb = $telegram->buildInlineKeyBoard($option);
		$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "رسته ای که به توانایی شما نزدیکتر می باشد را انتخاب کنید");
		$telegram->sendMessage($content);

	}
	
	else if ($text == "/img") {
	    // Load a local file to upload. If is already on Telegram's Servers just pass the resource id
	    $img = curl_file_create('test.png','image/png'); 
	    $content = array('chat_id' => $chat_id, 'photo' => $img );
	    $telegram->sendPhoto($content);
	    //Download the file just sended
	    $file_id = $message["photo"][0]["file_id"];
	    $file = $telegram->getFile($file_id);
	    $telegram->downloadFile($file["file_path"], "./test_download.png");
	}
	
	else if ($text == "🙋 سوال دارم" || $text == "/haveq") {
	    /* Send the Catania's coordinate
	    $content = array('chat_id' => $chat_id, 'latitude' => "37.5", 'longitude' => "15.1" );
	    $telegram->sendLocation($content);*/
		
		$option = array(array($telegram->buildInlineKeyboardButton($category[0], "","aaw0","")),
		array($telegram->buildInlineKeyboardButton($category[1],"","aaw1","")),
		array($telegram->buildInlineKeyboardButton($category[2],"","aaw2","")),
		array($telegram->buildInlineKeyboardButton($category[3],"","aaw3","")),
		array($telegram->buildInlineKeyboardButton($category[4],"","aaw4","")),
		array($telegram->buildInlineKeyboardButton($category[5],"","aaw5","")),
		array($telegram->buildInlineKeyboardButton("بیشتر..","",$callback_data="more",""))  ); 
		$keyb = $telegram->buildInlineKeyBoard($option);
		$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => " رسته ای که به سوال شما نزدیکتر می باشد را انتخاب کنید");
		$telegram->sendMessage($content);
	}
	
	else if ($text == "💻 پنل کاربری" ) {

		$reply = "در صورت تمایل ❌ لغو ارتباط فعلی انتخاب کنید";
	
		// Create option for the custom keyboard. Array of array string
		$option = array( array("❌ لغو ارتباط فعلی" , "🖱 منوی اصلی"));
		// Get the keyboard
		$keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true, $selective=true);
		$content = array('chat_id' => $chat_id,'parse_mode'=>'HTML', 'reply_markup' => $keyb, 'text' => $reply);
		$telegram->sendMessage($content);
	}	
	
	else if ($text == "📕 راهنمای" || $text =="/help" ) {

		$option = array(array($telegram->buildInlineKeyboardButton("📕 راهنمای","https://telegram.me/ibnsinahelp","","")));
		$keyb = $telegram->buildInlineKeyBoard($option);
		
		$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "جهت مشاهده فهرست راهنمای(📕)");
		$telegram->sendMessage($content);

	}	
	
	else if ($text == "💻 پنل سیناگو" ) {
		
			$post = [
			'idUser' =>  $chat_id
			
			];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"http://ibnsina.srv.parperook.ir/sinagoo_panel.php");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
			// receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($ch);
			curl_close ($ch);
		
		if($server_output =="پنل سیناگو"){
			
			$option = array( array("❌ لغو ارتباط سیناگو" , "🖱 منوی اصلی"), array("🕒 تایمر" , "🔴 وضعیت آنلاین/آفلاین"), array("💵 امور مالی", "🍵 ارسال لینک دونات(پرداخت)"));
		// Get the keyboard
			$keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true, $selective=true);
			$content = array('chat_id' => $chat_id,'parse_mode'=>'HTML', 'reply_markup' => $keyb, 'text' => $server_output );
			$telegram->sendMessage($content);
	
		}
		else{
			$content = array('chat_id' => $chat_id, 'text' => $server_output );
			$telegram->sendMessage($content);
		}
	
	}
	else if ($text == "🔴 وضعیت آنلاین/آفلاین" || $text =="/online") {
		$post = [
				'idUser' => $chat_id

			];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"http://ibnsina.srv.parperook.ir/sina_online.php");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
			// receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
			$server_output = curl_exec ($ch);
			curl_close ($ch);
			
			$content = array('chat_id' => $chat_id, 'text' => $server_output );
			$telegram->sendMessage($content);
	}
	else if ($text == "🕒 تایمر" ) {
		$post = [
				'idUser' => $chat_id

			];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"http://ibnsina.srv.parperook.ir/sina_online_time.php");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
			// receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
			$server_output = curl_exec ($ch);
			curl_close ($ch);
			$content = array('chat_id' => $chat_id, 'text' => $server_output );
			$telegram->sendMessage($content);
	}
	else if ($text == "❌ لغو ارتباط فعلی" || $text == "❌ لغو ارتباط سیناگو" || $text == "/laghv") {
		$post = [
				'idUser' => $chat_id

			];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"http://ibnsina.srv.parperook.ir/laghv.php");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
			// receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
			$server_output = curl_exec ($ch);
			curl_close ($ch);
			
			$content = array('chat_id' => $chat_id, 'text' => "❌ ارتباط لغو شد" );
			$telegram->sendMessage($content);
	
	}
	else if ($text == "🍵 ارسال لینک دونات(پرداخت)" || $text == "/donate") {
		$post = [
				'idUser' => $chat_id

			];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://ibnsina.srv.parperook.ir/donate_lnk.php");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
		// receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec ($ch);
		curl_close ($ch);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://ibnsina.srv.parperook.ir/send_msg.php");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
		// receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_chat_id = curl_exec ($ch);
		curl_close ($ch);

		$option = array(array($telegram->buildInlineKeyboardButton("🍲 پرداخت(Donate)",$server_output,"","")));
		$keyb = $telegram->buildInlineKeyBoard($option);
		
		$content = array('chat_id' => $server_chat_id, 'reply_markup' => $keyb, 'text' => "ما رو به یک چای دعوت کنید.
		لطفاً بعد از پرداخت گزارش پرداخت را ذخیره و ارسال کنید.");
		$telegram->sendMessage($content);

	}
	
	else if ($text == "💵 امور مالی" || $text == "/mali") {

		$option = array( array("💻 پنل سیناگو" , "🖱 منوی اصلی"), array("💳 ثبت شبا حساب بانکی","📕 گزارش صندوق"  ));
		// Get the keyboard
		$keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true, $selective=true);
		$content = array('chat_id' => $chat_id,'parse_mode'=>'HTML', 'reply_markup' => $keyb, 'text' =>"منوی سیناگو" );
		$telegram->sendMessage($content);
	
	}
	
	else if ($text == "📕 گزارش صندوق" || $text == "/reportmali") {
		
				$post = [
			'idUser' => $chat_id

		];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://ibnsina.srv.parperook.ir/sandogh_report.php");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
		// receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec ($ch);
		curl_close ($ch);
				
		$content = array('chat_id' => $chat_id, 'text' => $server_output );
		$telegram->sendMessage($content);
		
	}
	
	else if ($text == "💳 ثبت شبا حساب بانکی" || $text == "/shabahesab") {
		
		$post = [
			'idUser' => $chat_id

		];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://ibnsina.srv.parperook.ir/shaba.php");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
		// receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec ($ch);
		curl_close ($ch);
		
		$shabareport= $server_output ;
		
		$content = array('chat_id' => $chat_id, 'text' => $shabareport );
		$telegram->sendMessage($content);
		
	}
	
	else if (preg_match("/^IR[0-9]{24}[\-]{1}/",$text)) {// دریافت شبای بانکی

		$post = [
			'idUser' => $chat_id,
			'shaba' => substr($text,0,26),
			'shabaname' => substr($text,27,strlen($text))
		];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://ibnsina.srv.parperook.ir/shaba.php");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
		// receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec ($ch);
		curl_close ($ch);

		$content = array('chat_id' => $chat_id, 'text' => $server_output );
		$telegram->sendMessage($content);
	}
		
	else {
		$post = [
			'idUser' => $chat_id

		];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://ibnsina.srv.parperook.ir/send_msg.php");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
		// receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$server_output = curl_exec ($ch);
		curl_close ($ch);
		
		if ($server_output=="notconecction"){
			
			$content = array('chat_id' => $chat_id, 'text' => "❌ ارتباط موجود نیست. لطفا 🙋 سوال دارم(/haveq) را انتخاب کنید"  );
			$telegram->sendMessage($content);
			
		}
		else{
			
 /*			$content = array('chat_id' => $server_output, 'text' => $msgid.$text .$server_output );
			$ismsg=	$telegram->sendMessage($content);
			
			
			
			$content = array('chat_id' => $server_output, 'photo' => $img );
			$telegram->sendPhoto($content); */
			$content = array('chat_id' => $server_output,'from_chat_id'=>$chat_id ,'message_id'=> $msgid );
			$telegram->forwardMessage($content);

			
		}

}	 
}
	
	
	
	
	
	
	
	
	
	if ($callback_query !== null && $callback_query != "") {
		
		if ($callback_query['data']=="more"){

			$option = array(array($telegram->buildInlineKeyboardButton($category[6], "","aaw0","")),
			array($telegram->buildInlineKeyboardButton($category[7],"","aaw7","")),
			array($telegram->buildInlineKeyboardButton($category[8],"","aaw8","")),
			array($telegram->buildInlineKeyboardButton($category[9],"","aaw9","")),
			array($telegram->buildInlineKeyboardButton($category[10],"","aaw10","")),
			array($telegram->buildInlineKeyboardButton($category[11],"","aaw11","")),
			array($telegram->buildInlineKeyboardButton("◀ برگشت ","","back",""))  );
			$keyb = $telegram->buildInlineKeyBoard($option);

			$testEdit = $telegram->editMessageReplyMarkup(array('chat_id' =>$telegram->Callback_ChatID(),'message_id'=> $callback_query["message"]["message_id"] , 'reply_markup' => $keyb));

		}
		if ($callback_query['data']=="back"){

			$option = array(array($telegram->buildInlineKeyboardButton($category[0], "","aaw0","")),
			array($telegram->buildInlineKeyboardButton($category[1],"","aaw1","")),
			array($telegram->buildInlineKeyboardButton($category[2],"","aaw2","")),
			array($telegram->buildInlineKeyboardButton($category[3],"","aaw3","")),
			array($telegram->buildInlineKeyboardButton($category[4],"","aaw4","")),
			array($telegram->buildInlineKeyboardButton($category[5],"","aaw5","")),
			array($telegram->buildInlineKeyboardButton("بیشتر..","",$callback_data="more",""))  ); 
			$keyb = $telegram->buildInlineKeyBoard($option);

			$testEdit = $telegram->editMessageReplyMarkup(array('chat_id' =>$telegram->Callback_ChatID(),'message_id'=> $callback_query["message"]["message_id"] , 'reply_markup' => $keyb));

		}
		
		if (strpos($callback_query['data'],"rg")){
		
			$post = [
				'idUser' =>  $telegram->Callback_ChatID(),
				'Cat' => substr( $callback_query['data'],3),
				'first_name' =>  $callback_query['from']['first_name'],
				'last_name' =>  $callback_query['from']['last_name'],
				'username' =>  $callback_query['from']['username']
				
			];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"http://ibnsina.srv.parperook.ir/addsina.php");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
			// receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($ch);
			curl_close ($ch);
			
			$content = array('chat_id' => $telegram->Callback_ChatID(), 'text' => $server_output );
			$telegram->sendMessage($content);

			}
		
		if (strpos($callback_query['data'],"aw") ){
			
			$post = [
				'idUser' =>  $telegram->Callback_ChatID(),
				'Cat' =>substr( $callback_query['data'],3),

			];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"http://ibnsina.srv.parperook.ir/get_sina.php");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
			// receive server response ...
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec ($ch);
			curl_close ($ch);

			$content = array('chat_id' => $telegram->Callback_ChatID(), 'text' => $server_output );
			$telegram->sendMessage($content);

		}

		//$content = array('callback_query_id' => $telegram->Callback_ID(), 'text' => $reply, 'show_alert' => true);
		//$telegram->answerCallbackQuery($content);   
	}

?>
