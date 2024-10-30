<?php

?>

<h3>Recent Errors</h3>

<table class="widefat" cellspacing="0">
<tr>
	<th><b>Date &amp; Time</b></th>
	<th><b>Message</b></th>
</tr>
<?php

$logData = get_transient(ChaletAgentAPI::LOG_KEY);

if (false !== $logData && count($logData))
{
	foreach (array_reverse($logData) as $error)
	{
		echo "<tr>";
		echo "<td width=\"150\">" . date("Y-m-d H:i:s", $error['timestamp']) . "</td>";
		echo "<td>{$error['message']}</td>";
		echo "</tr>";
	}
}
else
{
	echo "<tr><td colspan=\"2\"><em>No errors reported</em></td></tr>";
}

?>

</table>
