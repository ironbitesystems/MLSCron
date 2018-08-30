<?php
include('includes/config.php');
require_once('includes/class/database.class.php');

# Create new Databause class
if (DB_CONNECT === true)
	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE, DB_TBLPRE);
else
	echo "Couldn't establish database connection<br>\n";

require_once('includes/class/phrets.class.php');

// start rets connection
$rets = new phRETS;

echo "+ Connecting to {$rets_login_url} as {$rets_username}<br>\n";
$connect = $rets->Connect($rets_login_url, $rets_username, $rets_password);

// check for errors
if ($connect) {
        echo "  + Connected<br>\n";
}
else {
        echo "  + Not connected:<br>\n";
        print_r($rets->Error());
        exit;
}

function create_table_sql_from_metadata($table_name, $rets_metadata, $key_field, $field_prefix = "") {

        $sql_query = "CREATE TABLE {$table_name} (\n";

        foreach ($rets_metadata as $field) {

                $field['SystemName'] = "`{$field_prefix}{$field['SystemName']}`";

                $cleaned_comment = addslashes($field['LongName']);

                $sql_make = "{$field['SystemName']} ";

                if ($field['Interpretation'] == "LookupMulti") {
                        $sql_make .= "TEXT";
                }
                elseif ($field['Interpretation'] == "Lookup") {
                        $sql_make .= "VARCHAR(50)";
                }
                elseif ($field['DataType'] == "Int" || $field['DataType'] == "Small" || $field['DataType'] == "Tiny") {
                        $sql_make .= "INT({$field['MaximumLength']})";
                }
                elseif ($field['DataType'] == "Long") {
                        $sql_make .= "BIGINT({$field['MaximumLength']})";
                }
                elseif ($field['DataType'] == "DateTime") {
                        $sql_make .= "DATETIME default '0000-00-00 00:00:00' not null";
                }
                elseif ($field['DataType'] == "Character" && $field['MaximumLength'] <= 255) {
                        $sql_make .= "VARCHAR({$field['MaximumLength']})";
                }
                elseif ($field['DataType'] == "Character" && $field['MaximumLength'] > 255) {
                        $sql_make .= "TEXT";
                }
                elseif ($field['DataType'] == "Decimal") {
                        $pre_point = ($field['MaximumLength'] - $field['Precision']);
                        $post_point = !empty($field['Precision']) ? $field['Precision'] : 0;
                        $sql_make .= "DECIMAL({$field['MaximumLength']},{$post_point})";
                }
                elseif ($field['DataType'] == "Boolean") {
                        $sql_make .= "CHAR(1)";
                }
                elseif ($field['DataType'] == "Date") {
                        $sql_make .= "DATE default '0000-00-00' not null";
                }
                elseif ($field['DataType'] == "Time") {
                        $sql_make .= "TIME default '00:00:00' not null";
                }
                else {
                        $sql_make .= "VARCHAR(255)";
                }

                $sql_make .= " COMMENT '{$cleaned_comment}'";
                $sql_make .= ",\n";

                $sql_query .= $sql_make;
        }

        $sql_query .= "PRIMARY KEY(`{$field_prefix}{$key_field}`) )";

        return $sql_query;

}

// gets resource information.  need this for the KeyField
$rets_resource_info = $rets->GetMetadataInfo();

$resource = "Property";
$class = "Resi";
// or set through a loop

// pull field format information for this class
$rets_metadata = $rets->GetMetadata($resource, $class);

echo '<pre>';
print_r($rets_metadata);
echo '</pre>';

$table_name = "rets_".strtolower($resource)."_".strtolower($class);
// i.e. rets_property_res

$sql = create_table_sql_from_metadata($table_name, $rets_metadata, $rets_resource_info[$resource]['KeyField']);
$db->query($sql);

echo "+ Disconnecting<br>\n";
$rets->Disconnect();
?>