<?php
require( '../all.inc.php');
require( 'tick.php' ) ;
require( 'tock.php' ) ;
while (1==1){
	$tick_count = 0;
	$tock_ready=false;
	while(!$tock_ready){
		$t1 = time();
		Tick();
		$tick_count++;
		$t2 = time();
		if($t2-$t1>60){
			$tock_ready=true;
		} else if ($tick_count>=5)
			$tock_ready=true;
		else
			sleep(5);
	}
	Tock();
}


?>