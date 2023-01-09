<?php
/**
 * Created by PhpStorm.
 * User: kovalevtv
 * Date: 12.08.18
 * Time: 13:29
 */

require dirname(__DIR__) . '/vendor/autoload.php';

$data = require __DIR__ . '/.data.php';

?>
<!DOCTYPE html>
<html>
<head>
	<title>test-page-main</title>
	<link href="<?=\FrontendGulp\Api\FrontendGulp::getInst()->urlCss('index')?>" type="text/css" rel="stylesheet">
</head>
<body>

<?=\FrontendGulp\Api\FrontendGulp::getInst()->render('common/b-last-news',['newsList'=>$data['NEWS_LIST']])?>


<script src="<?=\FrontendGulp\Api\FrontendGulp::getInst()->urlJs('index')?>" type="text/javascript" async></script>
</body>
</html>
