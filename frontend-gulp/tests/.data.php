<?php
/**
 * Created by PhpStorm.
 * User: kovalevtv
 * Date: 12.08.18
 * Time: 13:34
 */
$data = [];


for($i =0;$i<10 ;$i++){
	$data['NEWS_LIST'][] = [
			'ID'=>$i,
			'NAME'=>'Название новости '.$i,
	];
}

return $data;