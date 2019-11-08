<!--
	MessageBoard.php
	Kat
	11-4-19
	
-->

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Message Board Data</title>
	<link href="https://fonts.googleapis.com/css?family=ZCOOL+QingKe+HuangYou&display=swap" rel="stylesheet">
</head>
<body style="background-image:url('matrix.jpg')">
	<h1 style="text-align:center; font-family:'ZCOOL QingKe HuangYou'; color:white; text-shadow:black, 2, 2, 2; font-size:3em">Message Board</h1>
	<?php
	
		if (isset($_GET['action'])) {
			if((file_exists("MessageBoard/messages.txt")) && (filesize("MessageBoard/messages.txt") != 0)) {
				$MessageArray = file("MessageBoard/messages.txt");
				switch ($_GET['action']) {
					case 'Delete First':
						array_shift($MessageArray);
						break;
					case 'Delete Last':
						array_pop($MessageArray);
						break;
					case 'Delete Message':
						if(isset($_GET['message'])) {
							array_splice($MessageArray, $_GET['message'], 1);
						break;
						}
					case 'Remove Duplicates':
						$MessageArray = array_unique($MessageArray);
						$MessageArray = array_values($MessageArray);
						break;
					case 'Sort Ascending':
						sort($MessageArray);
						break;
					case 'Sort Descending':
						rsort($MessageArray);
						break;
				}
				if (count($MessageArray) > 0) {
					$NewMessages = implode($MessageArray);
					$MessageStore = fopen("MessageBoard/messages.txt", "wb");
					if ($MessageStore === false) {
						echo "There was an error updating the message file.\n";
					}
					else {
						fwrite($MessageStore, $NewMessages);
						fclose($MessageStore);
					}
				}
				else 
					unlink("MessageBoard/messages.txt");
			}
		}
		
		//Check if the messages file exists or is empty first
		if((!file_exists("MessageBoard/messages.txt")) || filesize("MessageBoard/messages.txt" === 0)) {
			echo "<p style='color:white'>There are no messages posted.</p>\n";
		}
		else {
			$MessageArray = file("MessageBoard/messages.txt");
			echo "<table style=\"background-color:white\" border=\"1\" width=\"100%\">\n";
			$count = count($MessageArray);
			
			foreach ($MessageArray as $Message) {
				$CurrMsg = explode("~", $Message);
				$KeyMessageArray[] = $CurrMsg;
			}
			
			for ($i = 0; $i < $count; ++$i) {
				echo "<tr>\n";
				echo "<td width=\"5%\" style=\"text-align:center; color:darkgreen; font-weight:bold\">" . ($i + 1) . "</td>\n"; 
				echo "<td width=\"60%\"><span style=\"font-weight:bold; color:darkgreen\">Subject: </span>" . htmlentities($KeyMessageArray[$i][0]) . "<br/>\n";
				echo "<span style=\"margin-left:10em; font-weight:bold; color:darkgreen\">Name:</span> " . htmlentities($KeyMessageArray[$i][1]) . "<br/>\n";
				echo "<span style=\"margin-left:2em; text-decoration:underline; color:darkgreen; font-weight:bold\">Message</span><br/>\n" . htmlentities($KeyMessageArray[$i][2]) . "</td>\n";
				echo "<td width=\"10%\" style=\"text-align:center; color:darkgreen\">" . "<a href='MessageBoard.php?action=Delete%20Message&message=$i'>" . 
				"Delete This Message</a></td>\n";
				echo "</tr>\n";
			}
			echo "</table>\n";
		}
	?>
	<p>
	<a href="PostMessage.php" style="color:white">Post New Message</a><br/>
	<a href="MessageBoard.php?action=Sort%20Ascending" style="color:white">Sort Subjects A-Z</a><br/>
	<a href="MessageBoard.php?action=Sort%20Descending" style="color:white">Sort Subjects Z-A</a><br/>
	<a href="MessageBoard.php?action=Delete%20First" style="color:white">Delete First Message</a><br/>
	<a href="MessageBoard.php?action=Delete%20Last" style="color:white">Delete Last Message</a><br/>
	<a href="MessageBoard.php?action=Remove%20Duplicates" style="color:white">Remove Duplicate Messages</a>
	</p>
	
	

</body>
</html>
















