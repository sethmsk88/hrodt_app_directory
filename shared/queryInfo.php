<!-------------------------------------------->
<!-- THIS FILE/FUNCTION HAS BEEN DEPRECATED -->
<!-- Please reference shared/query_UDFs.php -->
<!-------------------------------------------->

<style type="text/css">
table.queryInfo{
 	border-collapse: collapse;
}
table.queryInfo th, table.queryInfo td{
	padding: 2px 5px;
	border: 2px solid #555;
}
table.queryInfo th{
	background-color:#222;
	color:#DDD;
}
table.queryInfo td{
	border: 1px solid black;
	padding: 2px 4px;
}
</style>

<?php

	/*********************/
	/* Output table info */
	/*********************/
	function queryInfo($queryResult)
	{
		// Get field info for all columns
		$fieldInfo = $queryResult->fetch_fields();

		echo "<table class='queryInfo'>";
			echo "<tr>";
				echo "<th colspan='3'>" . $fieldInfo[0]->table . "</th>";
			echo "</tr>";
		
			echo "<tr>";
				echo "<td class='bold'>Column</td>";
				echo "<td class='bold'>Type</td>";
				echo "<td class='bold'>Max Length</td>";
			echo "<tr>";
		foreach ($fieldInfo as $val){
			echo "<tr>";
				echo "<td>" . $val->name . "</td>";
				echo "<td>" . $val->max_length . "</td>";
				echo "<td>" . $val->type . "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
?>