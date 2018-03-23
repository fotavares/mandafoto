<?php

include '../include/Telegram.php';
include '../include/TelegramErrorLogger.php';
include '../include/Util.php';

// Pagina que o cUrl executa para atualizar os canais
$posts[] = "";
$telegram = new Telegram("TOKEN");

$text = $telegram->Text();
$chatid = $telegram->ChatID();
$message_id = $telegram->MessageID();


if($text == "/foto")
{    
		$util = new Util;
		
		$url = 'https://imgur.com/r/aww/new.json'; 
		//pode ser feito com qualquer subreddit, inclusive mais de um juntando com +. Ex: aww+earthporn
		$json = $util->rest_helper($url);

		$resposta[] = array();
		foreach ($json->data as $k => $v) {
			if($v->mimetype == "image/jpeg")
			{
			  $dado["img"] = "http://i.imgur.com/".$v->hash.$v->ext;
			  $resposta[] = $dado;
			}
		}

		$idx=array_rand($resposta, 1);
		$data = $resposta[$idx]["img"];

		Util::logbot("manda","selecionado: ".$idx." - ".$data);	
		$content = ['chat_id' => $chatid, 'photo' => $data];
		$telegram->sendPhoto($content);
}
?>