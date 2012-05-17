<?php 
 /**
  * Charts.class.php
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/

/**
 * Charts class for producing graphs of results
 * @package auto-scaler
 */
class Charts{ 
	/** 
	 * Draw a graph of the trigger results and output to the file (as JPEG)
	 * @param object $trigger Trigger class object
	 * @param string $outputFilename Filename to store the JPEG file
	 * @access public
	 * @static
	 **/
	public static function TriggerGraph ($trigger,$outputFilename) {
		require_once ('../src/jpgraph/src/jpgraph.php');
		require_once ('../src/jpgraph/src/jpgraph_line.php');
	
		$results=array();
		$records=$trigger->GetResults();
		foreach($records as $r)
			$results[] = $r['result'];
		$data1y=$results;
		$data2y=array_fill(0,count($results),$trigger->lower);
		$data3y=array_fill(0,count($results),$trigger->upper);
		$data4y=array_fill(0,count($results),$trigger->GetAverageResult());


		// Create the graph. These two calls are always required
		$graph = new Graph(700,400,'auto');
		$graph->SetScale("textlin");

		$theme_class=new UniversalTheme;
		$graph->SetTheme($theme_class);
		$graph->yaxis->scale->SetGrace(10,10);
		$graph->ygrid->SetFill(false);
		$graph->xaxis->HideLabels();

		// Create the plots
		$b1plot = new LinePlot($data1y);
		$b1plot->SetLegend ( "Cluster results" ) ;
		$b2plot = new LinePlot($data2y);
		$b2plot->SetLegend ( "Lower threshold" ) ;
		$b3plot = new LinePlot($data3y);
		$b3plot->SetLegend ( "Upper threshold" ) ;
		$b4plot = new LinePlot($data4y);
		$b4plot->SetLegend ( "Average result (".$trigger->GetAverageResult().")" );
		
		// ...and add it to the graPH
		$graph->Add($b1plot);
		$graph->Add($b2plot);
		$graph->Add($b3plot);
		$graph->Add($b4plot);

		$graph->title->Set("'".$trigger->triggerName."' SNMP Results from ".$records[0]['date']." to ".$records[count($records)-1]['date']);

		// Display the graph
		$graph->StrokeStore($outputFilename);
	}
}
?>