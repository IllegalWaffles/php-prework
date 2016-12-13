<?php

// Author: Kuba Gasiorowski
// Date of last edit: 12/12/2016

function debug($str){
	
	echo "DEBUG: " . $str;
	
}

$submitted = isset($_POST["submit"]);
$display = false;
$subtotalError = false;
$tipError = false;
$splitError = false;

if($submitted){
	
	$display = 			true; // Initially, set display to true
	$displaySplit = 	false;
	$subtotal = 		$_POST["subtotal"];	// Get subtotal
	$tipPercent = 		$_POST["percentage"]; // Get tip percent
	$customPercent =	$_POST["custom_percent"];
	$numSplit = 		$_POST["num_split"];
	$customTipFlag = 	false;	// Initially, set custom tip to false
	
	if($tipPercent == "none"){
			
			$tipPercent = 		$customPercent;
			$customTipFlag = 	true;
			
	}
	
	// Checks for the correct conditions - displays nothing otherwise
	$subtotalError = !(is_numeric($subtotal) && $subtotal > 0);
	$tipError = !(is_numeric($tipPercent) && $tipPercent > 0);
	$splitError = !($numSplit > 0);
	
	$display = is_numeric($subtotal) && $subtotal > 0 && is_numeric($tipPercent) && $tipPercent > 0 && $numSplit > 0;
	
}

echo "<html>";
echo "<head><link rel=\"stylesheet\" href=\"./style.css\"></head>";
echo "<body>";

	echo "<div id=\"main\">";

	echo "<h3>Tip Calculator</h3>";
	echo "<hr>";
	
	echo "<form method=\"post\" action=\"./site.php\">";
	
		//Don't reset the default value, if already submitted
	
		// Open subtotal div
		echo "<div";
		echo $subtotalError?" class=\"error\" ":"";
		echo ">";
	
		echo "Bill Subtotal: $<input type=\"text\" name=\"subtotal\" value=\"";
		echo $submitted?$subtotal:0;
		echo "\">";
	
		echo "</div>";
		//Close subtotal div
	
		// Open tip div
		echo "<div";
		echo $tipError?" class=\"error\" ":"";
		echo ">";
	
		echo "<br>";
		echo "Tip percentage:";
		echo "<br>";
		
		for($i=10; $i < 25; $i=$i+5){
			
			echo "<input type=\"radio\""; 
			
			//Select the correct radio button from before
			if(!$submitted && $i == 10)
				echo " checked ";
			
			if($submitted)
				echo $tipPercent==$i?" checked ":"";
			
			echo "name=\"percentage\" value=\"" . $i . "\">" . $i . "%";
		
		}
	 
		echo "<br>";
		
		echo "<input type=\"radio\"";
		if($submitted)
			echo $customTipFlag?" checked ":"";
		echo "name=\"percentage\" value=\"none\">";
		
		
		echo "<input type=\"text\" name=\"custom_percent\" value=\"";
		echo $submitted?$customPercent:0;
		echo "\">%";
		
		echo "</div>";	
		// Close tip div
		
		echo "<br>";
		
		//Open split div
		echo "<div";
		echo $splitError?" class=\"error\" ":"";
		echo ">";
		
		echo "Split: <input type =\"number\" name=\"num_split\" value=\"";
		echo $submitted?$numSplit:1;
		echo "\"> person(s)";
		
		echo "</div>";
		
		echo "<br>";
		
		//Open submit div
		echo "<div id=\"submit\">";
		echo "<input type=\"submit\" name=\"submit\" value=\"Submit\">";
		echo "</div>";
		echo "<hr>";
	
	echo "</form>";
	
	if($display){
	
		$finalTip = round($subtotal * ($tipPercent/100.0),2);
		$finalTotal = round($finalTip + $subtotal,2);
	
		//Start div for output
		echo "<div id=\"output\">";
	
		echo "Tip: $" . $finalTip;
		echo "<br>";
		echo "Total: $" . $finalTotal;
	
		$displaySplit = $numSplit > 1;
		if($displaySplit)
		{
			
			echo "<hr>";
			echo "Tip each: $" . round($finalTip/$numSplit,2);
			echo "<br>";
			echo "Total each: $" . round($finalTotal/$numSplit,2);
			
		}
	
		echo "</div>";
	
	}
	
echo "</body>";
echo "</html>";
?>