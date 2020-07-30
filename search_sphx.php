<?php header('Content-Type: text/html; charset=utf-8');

$html = '<li class="res"><a target="_blank" href="urlString">';
$html .= '<img style="max-width: 270px;float:left;padding-right:10px;" src="img_page">';
$html .= '<h2>title_name</h2>';
$html .= '<h3>body_stuff</h3></a></li>';

$nores = '<div class="sorry" >Извините! Результатов не найдено...<img class="smile" src="/search_box/svg/sad.svg"><br><h5 style="margin: 10px;">(Попробуйте изменить запрос!)</h5></div>';
$search_string = $_POST['query'];
//$search_string = 'rfr';
function switchTextToRussian ($text){
$str_search = array(
"q","w","e","r","t","y","u","i","o","p","[","]",
"a","s","d","f","g","h","j","k","l",";","'",
"z","x","c","v","b","n","m",",",".",

"Q","W","E","R","T","Y","U","I","O","P","[","]",
"A","S","D","F","G","H","J","K","L",";","'",
"Z","X","C","V","B","N","M",",","."
);

$str_replace = array(
"й","ц","у","к","е","н","г","ш","щ","з","х","ъ",
"ф","ы","в","а","п","р","о","л","д","ж","э",
"я","ч","с","м","и","т","ь","б","ю",

"Й","Ц","У","К","Е","Н","Г","Ш","Щ","З","Х","Ъ",
"Ф","Ы","В","А","П","Р","О","Л","Д","Ж","Э",
"Я","Ч","С","М","И","Т","Ь","Б","Ю" 
);
return str_replace($str_search, $str_replace, $text); }
$search_string = switchTextToRussian ($search_string);
echo '<div id ="div_res">';
echo $search_string;
echo '</div>';

if ($search_string !== ' ') {

require_once 'sphinx/api/sphinxapi.php';    
$sphinx = new SphinxClient();

$sphinx->SetServer('127.0.0.1', 9312); 

//$sphinx->SetMatchMode(SPH_MATCH_EXTENDED2);
//$sphinx->SetMatchMode(SPH_MATCH_ANY);
$sphinx->SetSortMode(SPH_SORT_RELEVANCE);
$sphinx->SetFieldWeights(array(
    'page_name' => 30,
    'body' => 10,
));
$sphinx->setLimits(0, 20, 500);
$result = $sphinx->query($search_string, 'results1'); 


 if (isset($result["matches"])) {
 foreach ($result["matches"] as $key => $value)
{
    $result = $value["attrs"];

 $pat = '#<script(.*?)>(.*?)</script>#is';
 $rep = null;
 $result = preg_replace($pat, $rep, $result);

 $pat = '#<img(.*?)>#is';
 $rep = " ";
 $result = preg_replace($pat, $rep, $result);

$result['body'] = strip_tags($result['body']);

$words = $search_string;
$docs = array($result["body"], $result['page_name'], $result['img'],
$result['url'], $result['id_cat']);

$index = "results1";
$opts = array
(
    "before_match"      => '<b style="color:red;background-color:yellow">',
    "after_match"       => "</b>",
    "chunk_separator"   => " ..... ",
    "limit"             => 660,
    "around"            => 11,
);

foreach ( array(0,1) as $exact )
{
    $opts["exact_phrase"] = $exact;

    $res = $sphinx->BuildExcerpts ( $docs, $index, $words, $opts );
$disp_body = $res[0];
$disp_page_name = $res[1];
$disp_img = $res[2];
$id_cat = $res[4];

  switch ($id_cat) {
            case 1 : $id_cat = '/food_recover/';
                break;
            case 2 : $id_cat = '/legsart/';
                break;
            case 3 : $id_cat = '/hands/';
                break;
            case 4 : $id_cat = '/chest_back/';
                break;
            case 5 : $id_cat = '/others/';
                break;
        } 

$display_url = $id_cat.urlencode($res[3]);
      $output = str_replace('urlString', $display_url, $html);
     $output = str_replace('img_page', $disp_img, $output);
   $output = str_replace('title_name', $disp_page_name, $output);
   $output = str_replace('body_stuff', $disp_body, $output);
echo $output;
break;
}
  }
    }
       //}
 else { 
    echo($nores); 
}
   }  



