<?PHP
/**
 * Export-Data-to-Excel-from-MySQL-DB-Table-PHP
 * Exporting data to Excel file from a MySQL database table by PHP
 *
 * Original PHP code by Chirp Internet: www.chirp.com.au
 * (This upgraded version by @_thinkholic)
 * Please acknowledge use of this code by including this header.
 *
 * PHP / MySQL
 *
 * @author	Chirp
 * @author	Ind (@_thinkholic)
 *
 * Credits- http://www.the-art-of-web.com/php/dataexport/
 * Github ahref- 
 *
 * Last updated: 25/08/2014
 
**/

# DB Configs
define ('DB_USER', 'root');
define ('DB_PASSWORD', '');
define ('DB_HOST', 'localhost');
define ('DB_NAME', '[YOUR_DATABSE_NAME]');

# Table name
$tbl_name = "[YOUR TABLE NAME]";

# File name for download
$file_name = "export_data_" . date('Ymdhis') . ".xls";

# ConnectDB
$connection = @mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
	or die('Could not connect to database');
mysql_select_db(DB_NAME)
	or die ('Could not select database');
	
# cleanDataFN
function cleanData(&$str)
{
	$str = preg_replace("/\t/", "\\t", $str);
	$str = preg_replace("/\r?\n/", "\\n", $str);
	if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

# Header information
header("Content-Disposition: attachment; filename=\"$file_name\"");
header("Content-Type: application/vnd.ms-excel");

$flag = false;

$result = mysql_query("SELECT * FROM $tbl_name") or die('Connection failed!');

while(false !== ($row = mysql_fetch_assoc($result))) {

	if(!$flag) 
	{
	  // display field/column names as first row
	  print implode("\t", array_keys($row) ) . "\r\n";
	  
	  $flag = true;
	
	}

	array_walk($row, 'cleanData');

	print implode("\t", array_values($row)) . "\r\n";

}

exit;

// EOF.