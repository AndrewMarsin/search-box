<?php
//
// $Id$
//

require ( "sphinxapi.php" );


$sphinx = new SphinxClient();
$words = "как";
$sphinx->SetServer('127.0.0.1', 9312); 
//$sphinx->SetServer('SPHINX_HOST', 'SPHINX_PORT');
//$sphinx->SetMatchMode(SPH_MATCH_EXTENDED2);
//$sphinx->SetMatchMode(SPH_MATCH_ANY);
$sphinx->SetSortMode(SPH_SORT_RELEVANCE);
$sphinx->SetFieldWeights(array(
    'page_name' => 30,
    'body' => 10,
));
$sphinx->setLimits(0, 20, 500);
//$docs = $sphinx->query($words, '*');
//print_r($docs);
//$docs = array($docs);

$result = $sphinx->query($words, 'results1');

    echo "ARRAY!!!-----------------";
 foreach ($result["matches"] as $key => $value)
{
    $result = $value["attrs"];
     $result['body'] = strip_tags($result['body'], '<p><br>');
}

$docs = array($result["body"]);

// $docs = array
// (
//  	"this is my test text to be highlighted, and for the sake of the testing we need to pump its length somewhat",
//  	"тренировке энергичным и полным сил. Вы заканчиваете тренировку с чувством самоудовлетворения и точно знаете, что выложились на 100%.
// В другие дни вы истощены и прилагаете больше усилий, чтобы выполнить тот же объем. Вы пытаетесь побороть усталость, но выполняя привычные движения, вы недовольны тем как реагирует ваше тело",
// 	  "another test text to be highlighted, below limit",
// 	  "test number three, without phrase match",
// 	  "final test, not only without phrase match, but also above limit and with swapped phrase text test as well",
// );
//var_dump($docs);
$index = "results1";
$opts = array
(
	"before_match"		=> '<b style="color:red">',
	"after_match"		=> "</b>",
	"chunk_separator"	=> " ... ",
	"limit"				=> 160,
	"around"			=> 5,
);

foreach ( array(0,1) as $exact )
{
	$opts["exact_phrase"] = $exact;
	//print "exact_phrase=$exact\n";
//echo $exact;
	//$cl = new SphinxClient ();
	$res = $sphinx->BuildExcerpts ( $docs, $index, $words, $opts );
	//print_r($res);
	echo $res[0];
	// if ( !$res )
	// {
	// 	die ( "ERROR: " . $sphinx->GetLastError() . ".\n" );
	// } 
	//else
	// {
	// 	$n = 0;
	// 	foreach ( $res as $entry )
	// 	{
	// 		echo $entry . '<br>';
	// 		$n++;
	// 	print "n=$n, res=$entry\n";
	// 	}
	// 	echo "<br>";
	// 	print "\n";
	// }
}

//
// $Id$
//

?>