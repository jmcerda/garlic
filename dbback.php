<html><body>
<pre>
<?php
// Open database

echo "opening database\n\n";

$dbhost = 'mysql51-012.wc1';
$dbuser = '659502_ggf';
$dbpass = 'Gilroy2012';
$dbname = '659502_ggf';


// Create connection

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysql_select_db($dbname);

function dump() {
	global $dbhost,$dbuser,$dbpass,$dbname;
	echo "dumping tables\n\n";
    $backupFile = $dbname . date("Y-m-d-H-i-s") . '.gz';
    $command = "mysqldump --opt -h $dbhost -u $dbuser -p$dbpass $dbname | gzip > $backupFile";
    echo "$command\n\n";
    system($command);
    echo "tables dumped to $backupFile\n\n";

}

function backup() {
    $tableName  = 'mypet';
    $backupFile = 'backup/mypet.sql';
    $query      = "SELECT * INTO OUTFILE '$backupFile' FROM $tableName";
    $result = mysql_query($query);	
}

function restore() {
    $tableName  = 'mypet';
    $backupFile = 'mypet.sql';
    $query      = "LOAD DATA INFILE 'backupFile' INTO TABLE $tableName";
    $result = mysql_query($query);
}

dump();

// Close it

mysql_close($conn);

echo "database closed. All done. \n\n";
?>
</pre>
</body>
</html>
