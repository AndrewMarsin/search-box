<?php include '../db.php';

$html = '<li class="res"><a target="_blank" href="urlString">';
$html .= '<img style="max-width:120px;float:right;margin-right:10px;background-color:#171717;" src="img_page">';
$html .= '<h2 style="margin:5px">title_name</h2>';
$html .= '<h3>...body_stuff...</h3></a></li>';

$nores = '<div style="margin: 1em;
    text-align: center;
    font-size: 1rem;" class="no_res">Извините! Результатов не найдено...<br><h5 style="margin: 10px;">(Попробуйте изменить запрос!)</h5></div>';

$search_string = $_POST['query'];

if (mb_strlen($search_string)  >= 3 && $search_string !== ' ') {
  $query = ('SELECT * FROM views WHERE page_name LIKE "%'.$search_string.'%" OR body LIKE "%'.$search_string.'%" LIMIT 4');

$result = $pdo->query($query);

 while($results = $result->fetch())
    {$result_array[] = $results;}
 if (isset($result_array)){
       foreach ($result_array as $result) {
 
$pat = '#<script(.*?)>(.*?)</script>#is';
$rep = null;
$result = preg_replace($pat, $rep, $result);

$pat = '#<img(.*?)>#is';
$rep = " ";
$result = preg_replace($pat, $rep, $result);

$result['body'] = strip_tags($result['body'], '<br>');

$pattern = "/((?:^|>)[^<]*)(".$search_string.")/iu"; //регулярное выражение
   $replace = '$1<b class="yell" style="color:#FF0000; background:#FFFF00;">$2</b>'; // шаблон замены строки
   $disp_page_name = preg_replace($pattern, $replace,  $result['page_name']); // замена
//--------------------------------БОДИ---------------------------
 $result['body'] = mb_substr($result['body'], mb_stripos($result['body'], $search_string), 100);  
$pattern = "/((?:^|>)[^<]*)(".$search_string.")/iu"; //регулярное выражение
   $replace = '$1<b style="color:#FF0000; background:#FFFF00;">$2</b>';
 $disp_body = preg_replace($pattern,  $replace, $result['body']); 
    
  switch ($result['id_cat']) {
            case 1 : $result['id_cat'] = '/food_recover/';
                break;
            case 2 : $result['id_cat'] = '/legsart/';
                break;
            case 3: $result['id_cat'] = '/hands/';
                break;
            case 4 : $result['id_cat'] = '/chest_back/';
                break;
            case 5 : $result['id_cat'] = '/others/';
                break;
        } 

$display_url = $result['id_cat'].urldecode($result['url']);
 	$output = str_replace('urlString', $display_url, $html);
 	 $output = str_replace('img_page', $result['thumbs'], $output);
   $output = str_replace('title_name', $disp_page_name, $output);
   $output = str_replace('body_stuff', $disp_body, $output);
echo $output;
}}
	else {;
	echo($nores);
	}}
