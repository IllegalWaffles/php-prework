<?php

$submitted = isset($_POST["submit"]);
$display = false;

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
	$display = is_numeric($subtotal) && $subtotal > 0 && is_numeric($tipPercent) && $tipPercent > 0 && $numSplit > 0;
	$displaySplit = $numSplit > 1;
	
}

echo "<html>";
echo "<head></head>";
echo "<body>";

	echo "<h3>Tip Calculator</h3>";
	
	echo "<form method=\"post\" action=\"./site.php\">";
	
		//Don't reset the default value, if already submitted
	
		echo "Bill Subtotal: $<input type=\"text\" name=\"subtotal\" value=\"";
		echo $submitted?$subtotal:0;
		echo "\">";
	
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
		
		echo "<br><br>";
		
		echo "Split: <input type =\"text\" name=\"num_split\" value=\"";
		echo $submitted?$numSplit:0;
		echo "\"> person(s)";
		
		echo "<br><br>";
		echo "<input type=\"submit\" name=\"submit\" value=\"Submit\">";
	
	echo "</form>";
	
	if($display){
	
		$finalTip = round($subtotal * ($tipPercent/100.0),2);
		$finalTotal = round($finalTip + $subtotal,2);
	
		echo "Tip: $" . $finalTip;
		echo "<br>";
		echo "Total: $" . $finalTotal;
	
		if($displaySplit)
		{
			
			echo "<br>";
			echo "Tip each: $" . round($finalTip/$numSplit,2);
			echo "<br>";
			echo "Total each: $" . round($finalTotal/$numSplit,2);
			
		}
	
	}
	
echo "</body>";
echo "</html>";
?>