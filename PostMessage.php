<!--
	PostMessage.php
	Kat
	11-4-19
	
-->

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Message Board Exercise</title>
	<link href="https://fonts.googleapis.com/css?family=ZCOOL+QingKe+HuangYou&display=swap" rel="stylesheet">
</head>
<body style="background-image:url('matrix.jpg')">
	<?php
		if(isset($_POST['submit'])) {
			$Subject = stripslashes($_POST['subject']);
			$Name = stripslashes($_POST['name']);
			$Message = stripslashes($_POST['message']);
			//replace any ~ characters with with - characters
			$Subject = str_replace("~", "_", $Subject);
			$Name = str_replace("~", "_", $Name);
			$Message = str_replace("~", "_", $Message);
			
			$ExistingSubjects = array();
			
			if(file_exists("MessageBoard/messages.txt") && filesize("MessageBoard/messages.txt") > 0) {
				$MessageArray = file("MessageBoard/messages.txt");
				$count = count($MessageArray);
				for($i = 0; $i < $count; ++$i) {
				$CurrMsg = explode("~", $MessageArray[$i]);
				$ExistingSubjects[] = $CurrMsg[0];
				}
			}
			
			if(in_array($Subject, $ExistingSubjects)) {
				echo "<p style='color:white'>The subject you entered already exists!<br/>\n";
				echo "Please enter a new subject and try again.<br/>\n";
				echo "Your message was not saved.</p>";
				$Subject = "";
			}
			else {
				$MessageRecord = "$Subject~$Name~$Message\n";
				$MessageFile = fopen("MessageBoard/messages.txt", "ab");
				if($MessageFile ===  FALSE)
					echo "There was an error in saving your message!\n";
				else {
					fwrite($MessageFile, $MessageRecord);
					fclose($MessageFile);
					echo "<p style='color:white'>Your message has been saved.</p>\n";
					$Subject = "";
					$Message = "";
				}
			}
		}
		else {
			$Subject = "";
			$Name = "";
			$Message = "";
		}
	?>
	
	<h1 style="text-align:center; font-family:'ZCOOL QingKe HuangYou';color:white; font-size:5em">Post New Message</h1>
	<hr/>
	<form action="PostMessage.php" method="POST">
		<p><span style="font-weight:bold; font-family:'ZCOOL QingKe HuangYou';color:white; font-size:3em">Subject:</span>
			<input type="text" name="subject" value="<?php echo $Subject; ?>"/></p>
		<p><span style="font-weight:bold; font-family:'ZCOOL QingKe HuangYou';color:white; font-size:3em">Name:</span>
			<input type="text" name="name" value="<?php echo $Name; ?>"/></p>
		<textarea name="message" rows="6" cols="80"><?php echo $Message; ?></textarea><br/>
		<input type="submit" name="submit"value="Post Message">
		<input type="reset" name="reset" value="Reset Form">
		</form>
		<hr/>
		<p>
		<a href="MessageBoard.php" style="color:white">View Messages</a>
		</p>
	

</body>
</html>















