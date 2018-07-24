<!--
	This file contains User-defined PHP functions that are
	related to queries.
-->

<style type="text/css">

	/******************************************************/
	/* These styles are related to the dumpQuery function */
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
	/******************************************************/

	/******************************************************/
	/* These styles are related to the queryInfo function */
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
	/******************************************************/
</style>

<?php
	
	/******
		Function: getQryResults
		Created by: Seth Kerr
		Date Created: 4/3/2015
		Parameter(s): mysqli_result $queryResult
		Returns: Array of associative or numeric arrays holding result rows
		Description: Move result set iterator to start, and return array containing
			each row of the query as arrays.
		Updates:
	******/
	function getQryResults($queryResult)
	{
		$queryResult->data_seek(0); // Move result set iterator to start
		$res = $queryResult->fetch_all();
		$queryResult->data_seek(0); // Be kind, rewind

		return $res;
	}



	/******
		Function: getQryColNames
		Created by: Seth Kerr
		Date Created: 4/3/2015
		Parameter(s): mysqli_result $queryResult
		Returns: Array of objects representing the fields in a result set
		Description: Move result set iterator to start, and return array containing
			the column names of the query.
		Updates:
	******/
	function getQryColNames($queryResult)
	{
		$queryResult->data_seek(0); // Move result set iterator to start
		$res = $queryResult->fetch_fields();
		$queryResult->data_seek(0); // Be kind, rewind
		
		return $res;
	}



	/******
		Function: dumpQueryInfo
		Created by: Seth Kerr
		Date Created: 4/3/2015
		Parameter(s): mysqli_result $queryResult
		Returns: void
		Description: Output all column names of a query in a table format.
			Also output other information related to each column.
		Updates:
	******/
	function dumpQueryInfo($queryResult)
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



	/******
		Function: dumpQuery
		Created by: Seth Kerr
		Date Created: 4/3/2015
		Parameter(s): mysqli_result $queryResult
		Returns: void
		Description: Output all rows of a query in a table format with
			column names as headers.
		Updates:
	******/
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

		$queryResult->data_seek(0); // Move result set iterator back to start
	}

	/**
	 * Return an array containing the values from one specified column
	 * of a query result object.
	 *
	 * @param qryResult  Result object of a query
	 * @param colName    Name of the column whose values you would like
	 * @return col_array  Array containing the values from the colName
	 *		column of the qryResult query object
	 */
	function getColArrayFromQuery($qryResult, $colName) {
		$col_array = array();

		while ($row = $qryResult->fetch_assoc()) {
			array_push($col_array, $row[$colName]);
		}
		$qryResult->data_seek(0); // Move result set iterator back to start
		
		return $col_array;
	}


	/**
	 * Return an array containing key-value pairs from two specified
	 * columns of a query result object.
	 * 
	 * @param qryResult  Result object of a query
	 * @param keyColName Name of the column to use as the key
	 * @param valColName Name of the column to use as the val
	 * @return keyVal_array Array containing the key-value pairs from the
	 *		keyColName column and the valColName column of the
	 *		qryresult query object
	 */
	function getKeyValArrayFromQuery($qryResult, $keyColName, $valColName) {
		$keyVal_array = array();

		while ($row = $qryResult->fetch_assoc()) {
			$key = $row[$keyColName];
			$val = $row[$valColName];
			$keyVal_array[$key] = $val;
		}
		$qryResult->data_seek(0); // Move result set iterator back to start

		return $keyVal_array;
	}


	/**
	 * Return a 2-dim array containing key-value pairs from two specified
	 * columns of a query result object, where the value is an array
	 * containing two values
	 * 
	 * @param qryResult  Result object of a query
	 * @param keyColName Name of the column to use as the key
	 * @param valColName Name of the column to use as the val
	 * @return keyVal_array Array containing the key-value pairs from the
	 *		keyColName column and the valColName column of the
	 *		qryresult query object
	 */
	function getKeyVal2DArrayFromQuery($qryResult, $keyColName, $val1ColName, $val2ColName) {
		$keyVal_2Darray = array();

		while ($row = $qryResult->fetch_assoc()) {
			$key = $row[$keyColName];
			$val = array($row[$val1ColName], $row[$val2ColName]);
			$keyVal_2Darray[$key] = $val;
		}
		$qryResult->data_seek(0); // Move result set iterator back to start

		return $keyVal_2Darray;
	}











	/* Function Header Template */
	/******
		Function:
		Created by: Seth Kerr
		Date Created:
		Parameter(s):
		Returns:
		Description:
		Updates:
	******/

?>