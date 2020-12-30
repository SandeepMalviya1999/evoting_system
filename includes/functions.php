<?php

function fetchData($table, $conidtion)
{
	global $db;
	$table = trim($table);
	$conidtion = trim($conidtion);
	if(strlen($table) == 0)
	{
		return false;
	}
	$sql = "SELECT * FROM $table $conidtion";
	$result_set = $db->query($sql);
	if($result_set->rowCount())
	{
		return $result_set->fetchAll(PDO::FETCH_ASSOC);
	}
	return false;
}

function executeDeleteQuery($table, $condition)
{
	global $db;
	$table = trim($table);
	$condition = trim($condition);
	if(strlen($table) == 0 || strlen($condition) == 0)
	{
		return false;
	}
	$sql = "DELETE FROM $table $condition";
	$stmt = $db->prepare($sql);
	if($stmt->execute())
	{
		if($stmt->rowCount() == 1)
		{
			return true;
		}
		else
		{
			return $stmt->ErrorInfo();
		}
	}
	return false;
}

function executeInsertQuery($sql)
{
	global $db;
	$sql = trim($sql);
	if(strlen($sql) == 0)
	{
		return $sql;
	}
	$stmt = $db->prepare($sql);
	if($stmt->execute())
	{
		return true;
	}
	return false;
}

function executeUpdateQuery($sql)
{
	global $db;
	$sql = trim($sql);
	if(strlen($sql) == 0)
	{
		return $sql;
	}
	try
	{
		$stmt = $db->prepare($sql);
		if($stmt->execute())
		{
			return true;
		}

	}
	catch (PDOException $e) {
		echo "DataBase Error: The user could not be added.<br>".$e->getMessage();
		return false;
	  } catch (Exception $e) {
		echo "General Error: The user could not be added.<br>".$e->getMessage();
		return false;
	  }	
}

function getRowCount($table, $condition)
{
	global $db;
	$table = trim($table);
	$conidtion = trim($condition);
	if(strlen($table) == 0)
	{
		return false;
	}
	$sql = "SELECT COUNT(1) FROM $table $condition";
	$result = $db->query($sql);
	$count = $result->fetch()[0];
	$result->closeCursor();
	return $count;
}

?>