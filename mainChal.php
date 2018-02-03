<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Follower count number</title>
    </head>
    <body>
<?php  

/* 
* Requires the "Twitter API" wrapper by James Mallison 
* to be found at https://github.com/J7mbo/twitter-api-php
*
* The way how to get a follower count was posted by Amal Murali
* on http://stackoverflow.com/questions/17409227/follower-count-number-in-twitter
*/

	require_once('TwitterAPIExchange.php');              // adjust server path accordingly
	set_time_limit(30000) ;
	ini_set('memory_limit', '-1');

	// GET YOUR TOKENS AND KEYS at https://dev.twitter.com/apps/
	$settings = array(
	'oauth_access_token' => "	959809956294877185-BJtPF8B4tyF0fg7PJmpKMMq7vnkRvzP",               // enter your data here
	'oauth_access_token_secret' => "cuO8kkJ5wGNtoXjY3eXPX8CP12uyZRyiTg4wSSwwehoe6",        // enter your data here
	'consumer_key' => "luB0M3D6k1SvUfXXrlMbJJe1U",                 // enter your data here
	'consumer_secret' => "FioKjYPmzIU3gJl5iaqfsicbfM2jTmInsdKKHRiB8EqiRFZ3Yq"               // enter your data here
	);
	$line = 1; 
	$fic = fopen("vnps.csv", "a+");
	$array = array(); 
	while($tab=fgetcsv($fic,1024,';')) // Takes approximatively 20minutes
		{
			$champs = count($tab);
			$line ++;
			for($i=0; $i<$champs; $i ++)
				{
					$tw_username = substr($tab[$i], 1); // Initialise the User (From the readed file)
					$data = file_get_contents('https://cdn.syndication.twimg.com/widgets/followbutton/info.json?screen_names='.$tw_username); 
					$parsed =  json_decode($data,true);
					$tw_followers =  $parsed[0]['followers_count']; // Get the number of followers
					$array[substr($tab[$i], 1)]= $tw_followers; // Associate the User with the number of followers
					echo substr($tab[$i], 1).' has '. $tw_followers. ' <br />';
					flush();
					ob_flush();						
				}
		}
		arsort($array); // Sorting the array
		foreach($array as $key => $value) // Printing the array sorted
		{
			echo '[' . $key . '] : ' . $value . ' <br />';
			flush();
			ob_flush();	
		}
?>
    </body>
</html>