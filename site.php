<?php

// Author: Kuba Gasiorowski
// Date of last edit: 12/12/2016

	// Functions
	function debug($str){
	
		echo "DEBUG: " . $str;
	
	}

	//Global vars we need
	$submitted = 		isset($_POST["submit"]);
	$display = 			false;
	$subtotalError = 	false;
	$tipError = 		false;
	$splitError = 		false;
	$customTipFlag = 	false;
	
	// Do some logic, if the form has already been submitted once
	if($submitted){
	
		$display = 			true; // Initially, set display to true
		$customTipFlag = 	false;	// Initially, set custom tip to false
		$subtotal = 		$_POST["subtotal"];	// Get subtotal
		$tipPercent = 		$_POST["percentage"]; // Get tip percent
		$customPercent =	$_POST["custom_percent"]; // Get curstom percent value (may not be needed)
		$numSplit = 		$_POST["num_split"]; // Get number to split for
		
	
		// If user chose custom tip
		if($tipPercent == "none"){
			
			$tipPercent = 		$customPercent; // Save custom percent
			$customTipFlag = 	true; // Remember that custom tip was chosen
			
		}
	
		// Checks for the correct conditions - displays nothing otherwise
		$subtotalError = !is_numeric($subtotal) || $subtotal <= 0;
		$tipError = !is_numeric($tipPercent) || $tipPercent <= 0;
		$splitError = ($numSplit <= 0);
	
		// If there was any error, do not display
		$display = !($subtotalError || $tipError || $splitError);
	
	}

?>

<html>
<head><link rel="stylesheet" href="./style.css"></head>
<body>

	<div id="main">

	<h3>Tip Calculator</h3>
	<hr>
	
	<form method="post" action="./site.php">
	
		<!-- Don't reset the default value, if already submitted -->
	
		<!-- Open subtotal div -->
		<div <?php echo $subtotalError?" class=\"error\"" : "";?>>

		Bill Subtotal: $<input type="text" name="subtotal" value="<?php echo $submitted?$subtotal:0; ?>">
	
		<!-- Close subtotal div -->
		</div>
		
		<!-- Open tip div -->
		<div <?php echo $tipError?"class=\"error\"" : ""; ?>>
		
		<br>
		Tip percentage:
		<br>

		<?php	

		// Display radio input buttons
		for($i=10; $i < 25; $i=$i+5){
			
			echo "<input type=\"radio\""; 
			
			//Select the correct radio button from before
			if(!$submitted && $i == 10)
				echo " checked ";
			
			else if($submitted && $tipPercent==$i)
				echo " checked ";
			
			else 
				echo " ";
			
			echo "name=\"percentage\" value=\"" . $i . "\">" . $i . "%";
		
		}

		?>

		<br>
		
		<input type="radio"<?php echo ($customTipFlag && $submitted)?" checked " : " "; ?>name="percentage" value="none">
		<input type="text" name="custom_percent" value="<?php echo $submitted?$customPercent:0;?>">%
		<!-- Close tip div -->
		</div>	
		
		<br>
		
		<!-- Open split div -->
		<div <?php echo $splitError?"class=\"error\"" : ""; ?>>
		Split: <input type ="number" name="num_split" value="<?php echo $submitted?$numSplit:1; ?>"> person(s)
		
		<!-- Close split div -->
		</div>

		<br>
		<!-- Open submit div -->
		<div id="submit">
		<input type="submit" name="submit" value="Submit">
		</div>
		<hr>
	
	</form>
	
<?php
	
	if($display){
	
		$finalTip = round($subtotal * ($tipPercent/100.0),2);
		$finalTotal = round($finalTip + $subtotal,2);
	
		//Start div for output
		?><div id="output"><?php
	
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

?>
	
</body>
</html>
