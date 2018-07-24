<!-------------------------------------------->
<!-- THIS FILE/FUNCTION HAS BEEN DEPRECATED -->
<!-- Please reference shared/query_UDFs.php -->
<!-------------------------------------------->

<style type="text/css">
table.dumpQuery{
 	border-collapse: collapse;
}
table.dumpQuery th, table.dumpQuery td{
	padding: 2px 5px;
	border: 2px solid #555;
}
table.dumpQuery th{
	background-color:#222;
	color:#DDD;
}
table.dumpQuery td{
	border: 1px solid black;
	padding: 2px 4px;
}
</style>

<?php
	function dumpQuery($queryResult)
	{
		// Get field information for all columns
		$fieldInfo = $queryResult->fetch_fields();

		echo "<table class='dumpQuery'>";
		// Output column names
		echo "<tr>";
		
		foreach ($fieldInfo as $col){
			echo "<th>" . $col->name . "</td>";
		}
		echo"</tr>";

		// Output values stored in tables
		while ($row = $queryResult->fetch_assoc()){
			echo "<tr>";
			foreach ($fieldInfo as $col){
				echo "<td>" . $row[$col->name] . "</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
		echo "<br />";
	}
?>