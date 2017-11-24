<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30/10/17
 * Time: 3:08 PM
 */
namespace Core\Model\Adapters;

use Core\Constants as Constants;
use Core\Model\Adapters\Implement\CommonLibImplements as CommonLibImplements;
use Core\Response as Response;
use Core\CoreException as CoreException;


class LibMysqli implements CommonLibImplements {
    // holder for pdo adapter
    private static $adapter = null;
    // holder for default charset for pdo
    private static $charset = "utf8mb4";
    // holder for condition string
    private $conditionString = "";
    // holder for conditions array which will be used while executing the prepared statement
    private $conditionFiller = array();
    // holder for query string after query string is completely prepared
    public $queryString = "";
    // current table holder
    private static $table;
    // Prepared Result set holder
    private $resultset = null;
    // Prepared statement holder
    private $stmt = null;
    // Temporary holder of fetch all result for future manipulations and pulling record from specified positions
    private $allRecords = array();

    // Result set clone for working on data from the start at any point of time
    private $clonedResultSet = null;

    // Prepared statement clone for working on data from the start at any point of time
    private $clonedStatement = null;

    // Constant for order by , limit and group by statements
    private $oBLG = "";

    // Data types for binding values
    private $bindDatatypes = "";

    //  Request columns
    private $requestColumns = array();


    public function __construct($table){
        self::$table = "`".$table."`";
        $this -> resetAll();
    }
    // create a mysqli adapter
    public static function __createAdapter() {
        $constants = Constants::getConstants("USER");
        if (!self::$adapter) {
            $host = $constants['APP_CONFIG']['default']['DB']['HOST'];
            $db_name = $constants['APP_CONFIG']['default']['DB']['DB_NAME'];
            $user = $constants['APP_CONFIG']['default']['DB']['USER'];
            $pwd = $constants['APP_CONFIG']['default']['DB']['PWD'];
            self::$adapter = mysqli_connect($host, $user, $pwd, $db_name);
            mysqli_set_charset(self::$adapter, self::$charset);
        }
    }

    // Prepare query condition with AND / OR and = separator
    public function pcEquals(string $separator = "AND", array $columns): LibMysqli {
        if(!empty($columns)) {
            array_push($this -> conditionFiller, current($columns));
            if(!empty($columnNames = array_keys($columns))) {
                if($this ->conditionString) {
                    $this -> conditionString.=" $separator ".$columnNames[0]." = ?";
                } else {
                    $this -> conditionString = $columnNames[0]." = ?";
                }
            }
        }
        return $this;
    }

    // Prepare query condition with AND / OR and LIKE separator
    public function pcLike(string $separator = "AND", array $columns): LibMysqli {
        try {
            if(!empty($columns)) {
                array_push($this -> conditionFiller, current($columns));
                if(!empty($columnNames = array_keys($columns))) {
                    if($this ->conditionString) {
                        $this -> conditionString.=" $separator ".$columnNames[0]." LIKE ?";
                    } else {
                        $this -> conditionString = $columnNames[0]." LIKE ?";
                    }
                }
            }
        } catch(\Throwable $t) {
            echo PHP_EOL.$t -> getMessage().PHP_EOL;
        }
        return $this;
    }

    // Prepare query condition with AND / OR and > separator
    public function pcGt(string $separator = "AND", array $columns): LibMysqli {
        try {
            if(!empty($columns)) {
                array_push($this -> conditionFiller, current($columns));
                if(!empty($columnNames = array_keys($columns))) {
                    if($this ->conditionString) {
                        $this -> conditionString.=" $separator ".$columnNames[0]." > ?";
                    } else {
                        $this -> conditionString = $columnNames[0]." > ?";
                    }
                }
            }
        } catch(\Throwable $t) {
            echo PHP_EOL.$t -> getMessage().PHP_EOL;
        }
        return $this;
    }

    // Prepare query condition with AND / OR and < separator
    public function pcLt(string $separator = "AND", array $columns): LibMysqli {
        try {
            if(!empty($columns)) {
                array_push($this -> conditionFiller, current($columns));
                if(!empty($columnNames = array_keys($columns))) {
                    if($this ->conditionString) {
                        $this -> conditionString.=" $separator ".$columnNames[0]." < ?";
                    } else {
                        $this -> conditionString = $columnNames[0]." < ?";
                    }
                }
            }
        } catch(\Throwable $t) {
            echo PHP_EOL.$t -> getMessage().PHP_EOL;
        }
        return $this;
    }

    // Prepare In query
    public function IN(string $separator = "AND", string $column, array $values): LibMysqli {
        $inSubStr = ""; // In substring (:val1,:val2,:val3) holder
        $inValCounter = 1;
        if(!empty($values)) {
            // prepare sub query like (:val1,:val2,:val3)
            array_map(function($value) use (&$inValCounter,&$inSubStr){
                $inSubStr.="?,";
                array_push($this -> conditionFiller, $value);
                ++$inValCounter;
            }, $values);
            $inSubStr = substr($inSubStr, 0, strlen($inSubStr)-1);;
            if($this ->conditionString) {
                $this -> conditionString.=" $separator ".$column." IN (".$inSubStr.")";
            } else {
                $this -> conditionString = $column." IN (".$inSubStr.")";
            }
        }
        return $this;
    }

    // Prepare query with Limit
    public function limit(int $limit, int $offset = 0): LibMysqli {
        try {
            if($limit) {
                $this -> oBLG.=" LIMIT $offset, $limit";
            }
        } catch (\Throwable $t) {
            echo PHP_EOL.$t -> getMessage().PHP_EOL;
        }
        return $this;
    }

    // Prepare query with Group
    public function groupBy(string $columnName) {
        if($columnName) {
            $this -> oBLG.=" GROUP BY $columnName";
        }
    }

    // Prepare query with order by
    public function orderBY(string $clause): LibMysqli {
        if($clause) {
            $this -> oBLG.=" ORDER BY $clause";
        }
        return $this;
    }

    // Execute Raw queries
    public function raw(string $sql, string $is_chainAble) {
        // reset all previous changes
        $this -> resetAll();
        if($sql) {
            try{
                $sql = mysqli_real_escape_string(self::$adapter, $sql);
                $this -> resultset = mysqli_query(self::$adapter, $sql);
                if($this -> resultset) {
                    $this -> clonedResultSet = $this -> cloneMysqliStmt($this -> resultset);
                    if($is_chainAble) {
                        return $this;
                    } else {
                        return true;
                    }
                } else {
                    CoreException::__sendErrorResponse("Error Executing query: ".$sql);
                    return false;
                }
            } catch(\Throwable $t) {
                echo PHP_EOL.$t -> getMessage().PHP_EOL;
                return false;
            }
        } else {
            return false;
        }

    }

    // prepare and fetch the given columns based on the prepared conditions
    public function fetch(array $columns): LibMysqli {
        // set requested columns for further processing
        $this -> requestColumns = $columns;
        // prepare query string based on conditions
        if(!empty($columns) && !array_search('*', $columns)) {
            array_map(function($column) {
                return "`".$column."`";
            }, $columns);
            $columns = implode(',', $columns);
            if($this -> conditionString) {
                $this -> queryString = "select $columns from ".self::$table." WHERE ".$this -> conditionString." ".$this -> oBLG;
            } else {
                $this -> queryString = "select $columns from ".self::$table." ".$this -> oBLG;
            }
        } else if(!empty($columns)){
            if($this -> conditionString) {
                $this -> queryString = "select * from `".self::$table."` WHERE ".$this -> conditionString." ".$this -> oBLG;
            } else {
                $this -> queryString = "select * from `".self::$table."` ".$this -> oBLG;
            }
        }

//        return $this;
        // prepare, execute, bind, store
        if($this -> commit()) {
            return $this;
        } else {
            return null;
        }
    }

    /**
     * Add, Update, Delete, Alter
     */
    // Add New Row
    public function addRow(array $row): LibMysqli {
        if(!empty($row)) {
            $columnString = implode(",", array_keys($row));
            $this -> conditionFiller = array_values($row);
            $positionalPlaceholders = array_fill(0, sizeof($row), "?");
            $positionalPlaceholders = implode(",", $positionalPlaceholders);
            $this -> queryString = "insert into ".self::$table." ($columnString) values ( $positionalPlaceholders )";
            return $this;
        }
        return null;
    }

    // Delete Row
    public function delete(): bool {
        // prepare query string based on conditions
        if($this -> conditionString) { // if condition string exists then prepare query with condition string and execute
            $this -> queryString = "delete from ".self::$table." WHERE ".$this -> conditionString;
            // prepare, execute, bind, store
            if($this -> commit()) {
                return true;
            } else {
                return false;
            }
        } else { // if no condition string then delete all rows
            $this -> queryString = "delete from ".self::$table;
            if($this -> raw($this -> queryString, false)) {
                return true;
            } else {
                return false;
            }
        }
    }

    // Update row/s
    public function update(array $setColumns): LibMysqli {
        if(!empty($setColumns)) {
            $preparedSetStatement = "";
            array_walk($setColumns, function($columnValue, $columnName) use (&$preparedSetStatement) {
                array_unshift($this -> conditionFiller, $columnValue);
                $preparedSetStatement.=$columnName." = ?,";
            });
            $preparedSetStatement = substr($preparedSetStatement, 0, strlen($preparedSetStatement)-1);
            if($this -> conditionString) {
                $this -> queryString = "UPDATE  ".self::$table." SET ".$preparedSetStatement. " WHERE ".$this -> conditionString;
            } else {
                $this -> queryString = "UPDATE  ".self::$table." SET ".$preparedSetStatement;
            }
            return $this;
        } else {
            return null;
        }
    }

    // Alter schema
    public function alter(string $alterQuery): bool {
        if($alterQuery) {
            $this -> queryString = "ALTER TABLE ".self::$table." $alterQuery";
            if($this -> raw($this -> queryString, false)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Count number of rows using count(*)
    public function numRows(): int {
        // check if conditions are set then use them to count number of rows with that condition
        if($this -> conditionString) {
            $this -> queryString = "select count(*) as numRows WHERE ".$this -> conditionString;
            if($this -> commit()) {
                try {
                    if($count = $this -> first()) {
                        return $count['numRows'];
                    } else {
                        return 0;
                    }
                } catch(\Throwable $t) {
                    echo PHP_EOL;
                    echo $t -> getMessage();
                    echo PHP_EOL;
                    return 0;
                }
            } else {
                return 0;
            }
        } else { // else count all rows
            $this -> queryString = "select count(*) as numRows";
            if($this -> raw($this -> queryString, false)) {
                try {
                    if($count = $this -> first()) {
                        return $count['numRows'];
                    } else {
                        return 0;
                    }
                } catch(\Throwable $t) {
                    echo PHP_EOL;
                    echo $t -> getMessage();
                    echo PHP_EOL;
                    return 0;
                }
            } else {
                return 0;
            }
        }
    }

    // Bind the params given with then current statement
    public function bindWith(array $bindings): LibMysqli {
        // check if data type exists in constants array
        if(!empty($bindings) && !empty($this -> conditionFiller)) {
            array_walk($bindings, function ($length, string $data_type ){
                if(isset($data_type) && array_key_exists($data_type, self::DATA_TYPES)) {
                    $conditionKey = key($this -> conditionFiller);
                    $conditionValue = current($this -> conditionFiller);
                    // Holding the values of condition filler to use in binding and removing it from condition filler so that we make conditionFiller empty which prevents mistakenly injecting binding values to both execute and bind params.
                    array_shift($this -> conditionFiller);
                    if($length) {
                        ($this -> resultset) -> bindParam(":".$conditionKey, $conditionValue, self::DATA_TYPES[$data_type], $length);
                    } else {
                        ($this -> resultset) -> bindParam(":".$conditionKey, $conditionValue, self::DATA_TYPES[$data_type]);
                    }
                } else {
                    CoreException::__sendErrorResponse("Cannot find $data_type. No such data type found for PDO prepared statements.");
                }
            });
        } else {
            CoreException::__sendErrorResponse("No bindings or conditions found.");
        }
        return $this;
    }

    // receive the binding values data types and set it
    public function bindTypes(string $dataTypes): LibMysqli {
        if($dataTypes) {
            $this -> bindDatatypes = $dataTypes;
        }
        return $this;
    }
    // Prepare pdo statement
    private function prepareStatement(): bool {
        $mysqli = self::$adapter;
        // prepare and assign prepared statement.
        try {
            if($this -> queryString) {
                $this -> stmt = mysqli_prepare($mysqli, $this -> queryString);
                if(!$this -> stmt) {
                    CoreException::__sendErrorResponse(mysqli_error($mysqli));
                    return false;
                }
                return true;
            } else {
                CoreException::__sendErrorResponse("No query to prepare");
                return false;
            }
        } catch(\Throwable $t) {
            echo PHP_EOL.$t -> getMessage().PHP_EOL;
            echo PHP_EOL."Error on Line Number : ".$t -> getLine().PHP_EOL;
        }
        return false;
    }

    // Execute pdo statement
    private function executeStatement(): bool {
        try {
            mysqli_stmt_execute($this -> stmt);
            $this -> clonedStatement = $this -> cloneMysqliStmt($this -> stmt);
            return true;
        } catch(\Throwable $t) {
            echo PHP_EOL.$t -> getMessage().PHP_EOL;
            return false;
        }
    }

    // Bind prepared statements with given values and data types
    private function bindStatementParam(): bool {
        if($this -> stmt) {
            try {
                if($this -> bindDatatypes) {
                    mysqli_stmt_bind_param($this -> stmt, $this -> bindDatatypes, ... $this -> conditionFiller);
                }
                return true;
            } catch(\Throwable $t) {
                echo PHP_EOL.$t -> getMessage().PHP_EOL;
                return false;
            }
        }
        return false;
    }

    // execute prepareStatement, executeStatement. Helpful if we need to buffer query string and wait for other changes to happen before executing.
    public function commit(): bool {
        if($this -> prepareStatement() && $this -> bindStatementParam() && $this -> executeStatement()) {
            return true;
        }
        return false;
    }

    // Load/Store the result from prepared statement
    private function storeResult(): bool {
        if($this -> stmt) {
            try {
                mysqli_stmt_store_result($this -> stmt);
                return true;
            } catch(\Throwable $t) {
                echo PHP_EOL.$t -> getMessage().PHP_EOL;
                return false;
            }
        }
        return false;
    }

    // Bind Result with variables for fetching with mysqli_stmt_store_result
    private function bindResult(): bool {
        if($this -> stmt) {
            // compute the number and name columns required for binding
            if(!empty($this -> requestColumns)) {
                $columnNames = [];
                // if all columns are requested using *
                if(array_search("*", $this -> requestColumns)) {
                    try {
                        $records = $this -> raw("show columns from ".self::$table, true) -> all();
                        while($row = mysqli_fetch_assoc($records)) {
                            array_push($columnNames, "$".$row['Field']);
                        }
                    } catch(\Throwable $t) {
                        echo PHP_EOL.$t -> getMessage().PHP_EOL;
                    }
                } else { // if only few columns are requested
                    foreach($this -> requestColumns as $requestColumn) {
                        array_push($columnNames, "$".$requestColumn);
                    }
                }
                // bind the columns
                try {
                    mysqli_stmt_bind_result($this -> stmt, ... $requestColumn);
                    return true;
                } catch(\Throwable $t) {
                    echo PHP_EOL.$t -> getMessage().PHP_EOL;
                    return false;
                }
            } else {
                CoreException::__sendErrorResponse("No Columns found to bind them to result");
                return false;
            }
        }
        return false;
    }

    // public method to reset all configs related to last query
    public function clean() {
        $this -> resetAll();
    }

    // Reset all values related to last query
    private function resetAll() {
        $this -> queryString = ""; // reset prepared query string
        $this -> conditionString = ""; // reset prepared condition string
        $this -> conditionFiller = array(); // reset prepared condition filler array
        $this -> resultset = null; // reset prepared statement
        $this -> clonedResultSet = null; // reset cloned result set
        $this -> clonedStatement = null; // reset cloned prepared statement
        $this -> stmt = null; // reset prepared statement
        $this -> allRecords = array(); // reset variable to remove records fetched from last query
    }

    // Call different modes of fetch
    public function __call($name, array $argument) {
        try {
            if($this -> clonedStatement) {
                $localCloneStatement = $this -> cloneMysqliStmt($this -> clonedStatement);
            } else {
                $localCloneStatement = $this -> cloneMysqliStmt($this -> stmt);
            }
            switch($name) {
                case "all":
                    $resource = mysqli_stmt_get_result($localCloneStatement);
                    $this -> allRecords = mysqli_fetch_all($resource);
                    return $this -> allRecords;
                    break;
                case "enumerate":
                    if($this -> storeResult() && $this -> bindResult()) {
                        return $this;
                    } else {
                        return false;
                    }
                    break;
                case "first":
                    if(empty($this -> allRecords)) {
                        $resource = mysqli_stmt_get_result($localCloneStatement);
                        $this -> allRecords = mysqli_fetch_all($resource);
                    }
                    return current($this -> allRecords);
                    break;
                case "last":
                    if(empty($this -> allRecords)) {
                        $resource = mysqli_stmt_get_result($localCloneStatement);
                        $this -> allRecords = mysqli_fetch_all($resource);
                    }
                    end($this -> allRecords);
                    return current($this -> allRecords);
                    break;
                case "pos":
                    if(empty($this -> allRecords)) {
                        $resource = mysqli_stmt_get_result($localCloneStatement);
                        $this -> allRecords = mysqli_fetch_all($resource);
                    }
                    $allrecords = $this -> allRecords;
                    return $allrecords[$argument[0]];
                    break;
            }
        } catch(\Throwable $t) {
            echo PHP_EOL.$t -> getMessage().PHP_EOL;
            return false;
        }
    }

    // Clone PDO statement object by receiving it as a copy and then returning the copy
    private function cloneMysqliStmt($copyMysqliStmt) {
        return $copyMysqliStmt;
    }

    // fetch columns row by row
    public function fetchRecords() {
        try {
            mysqli_stmt_fetch($this -> stmt);
        } catch(\Throwable $t) {
            echo PHP_EOL.$t -> getMessage().PHP_EOL;
        }
    }
}