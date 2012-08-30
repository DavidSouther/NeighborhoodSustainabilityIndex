<?php defined('SYSPATH') or die('No direct script access.');

require Kohana::find_file('vendors', "pchart/class/pData.class");
require Kohana::find_file('vendors', "pchart/class/pDraw.class");
require Kohana::find_file('vendors', "pchart/class/pRadar.class");
require Kohana::find_file('vendors', "pchart/class/pImage.class");


class Controller_Radar extends Controller {

	public function action_index()
	{
		$zip = $this->request->param('id');

		$data = $this->load_zip($zip);

		/* Create and populate the pData object */
		$MyData = new pData();
		// $MyData->addPoints(array(8,4,6,4,2),"Score");
		$MyData->addPoints(array_slice($data, 1, 5), "Score");
		$MyData->setSerieDescription(
			"Score",
			"Application A"
		);
		$MyData->setPalette(
			"Score",
			array(
				"R"=>157,
				"G"=>196,
				"B"=>22
			)
		);
		 
		/* Define the absissa serie */
		$MyData->addPoints(
			array(
				"Natural\nGas",
				"Electricity",
				"Dirty\nWater",
				"Recycling",
				"Trees"
			),
			"Families"
		);
		$MyData->setAbscissa("Families");

		$this->draw($MyData, $data[6], $zip);
	}

	private function load_zip($zip)
	{
		$csv = fopen(Kohana::find_file("data", "scores", 'csv'), 'r');

		while(($data = fgetcsv($csv)) !== FALSE) {
			if($data[0] === $zip){
				$line = $data;
				break;
			}
		}

		fclose($csv);

		if(!$line) {
			echo "Couldn't find " . $zip;
			die();
		}

		return $this->munge($line);
	}

	private function munge($line)
	{
		$line[4] = rand(0, 5)/100;
		$line[5] = rand(0, 5)/100;

		for($i=1; $i<=5; $i++){
			$line[$i] = floor($line[$i] * 100);
		}

		$line[6] = $line[1] + $line[2] + $line[3] + $line[4] + $line[5];
		return $line;
	}

	private function draw($MyData, $total, $zip) {
		$this->response->headers('content-type', 'image/png');
		 
		/* Create the pChart object */
		$myPicture = new pImage(300,300,$MyData);
		$myPicture->drawGradientArea(0,0,300,300,DIRECTION_VERTICAL,array("StartR"=>200,"StartG"=>200,"StartB"=>200,"EndR"=>240,"EndG"=>240,"EndB"=>240,"Alpha"=>100));
		$myPicture->drawGradientArea(0,0,300,20,DIRECTION_HORIZONTAL,array("StartR"=>30,"StartG"=>30,"StartB"=>30,"EndR"=>100,"EndG"=>100,"EndB"=>100,"Alpha"=>100));
		$myPicture->drawLine(0,20,300,20,array("R"=>255,"G"=>255,"B"=>255));
		$RectangleSettings = array("R"=>180,"G"=>180,"B"=>180,"Alpha"=>100);
		 
		/* Add a border to the picture */
		$myPicture->drawRectangle(0,0,299,299,array("R"=>0,"G"=>0,"B"=>0));
		 
		/* Write the picture title */ 
		$myPicture->setFontProperties(
			array(
				"FontName" => Kohana::find_file('vendors', "pchart/fonts/Silkscreen", ".ttf"),
				"FontSize" => 6
			)
		);
		$myPicture->drawText(10, 13, "NSI for " . $zip . ": " . $total, array("R"=>255,"G"=>255,"B"=>255));

		$myPicture->setFontProperties(
			array(
				"FontName" => Kohana::find_file('vendors', "pchart/fonts/Forgotte", ".ttf"),
				"FontSize" => 6
			)
		);

		/* Enable shadow computing */ 
		$myPicture->setShadow(TRUE,array("X"=>2,"Y"=>2,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
		 
		/* Create the pRadar object */ 
		$SplitChart = new pRadar();
		 
		/* Draw a radar chart */ 
		$myPicture->setGraphArea(10,25,290,290);
		$Options = array("DrawPoly"=>TRUE,"WriteValues"=>TRUE,"ValueFontSize"=>8,"Layout"=>RADAR_LAYOUT_CIRCLE,"BackgroundGradient"=>array("StartR"=>255,"StartG"=>255,"StartB"=>255,"StartAlpha"=>100,"EndR"=>207,"EndG"=>227,"EndB"=>125,"EndAlpha"=>50));
		$SplitChart->drawRadar($myPicture, $MyData, $Options);

		/* Render the picture (choose the best way) */
		//$myPicture->autoOutput("pictures/example.radar.values.png");
		ob_start();
		imagepng($myPicture->Picture);
		$this->response->body(ob_get_contents());
		ob_end_clean();
	}
}
