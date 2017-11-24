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

// Creates pdo adapter and provides hooks to execute pdo related queries
class LibPdo implements CommonLibImplements{
    // holder for pdo adapter
    private static $adapter = null;
    // holder for pdo dsn value
    private static $dsn = "";
    // holder for default charset for pdo
    private static $charset = "utf8mb4";
    // holder for pdo connection opts
    private static $opts = array(
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES   => true,
        \PDO::ATTR_PERSISTENT => false
    );
    // holder for condition string
    private $conditionString = "";
    // holder for conditions array which will be used while executing the prepared statement
    private $conditionFiller = array();
    // holder for query string after query string is completely prepared
    public $queryString = "";
    // current table holder
    private static $table;
    // Prepared Statement holder
    private $stmt = null;
    // constant holding data types
    CONST DATA_TYPES = array(
        "int" => \PDO::PARAM_INT,
        "str" => \PDO::PARAM_STR,
        "bool" => \PDO::PARAM_BOOL
    );

    // Temporary holder of fetch all result for future manipulations and pulling record from specified positions
    private $allRecords = array();

    // Prepared Statement clone for working on data from the start at any point of time
    private $clonedStatement = null;

    // Constant for order by , limit and group by statements
    private $oBLG = "";


    public function __construct($table){
        self::$table = $table;
        $this -> resetAll();
    }
    // Create a PDO Adapter
    public static function __createAdapter() {
        // prepare dsn value from the given config values in ini file
        if(!self::$adapter) {
            self::__prepareDSN();
            $constants = Constants::getConstants("USER");
            self::$adapter = new \PDO(self::$dsn, $constants['APP_CONFIG']['default']['DB']['USER'], $constants['APP_CONFIG']['default']['DB']['PWD'], self::$opts);
        }
    }

    // Prepare dsn from config ini file
    private static function __prepareDSN() {
        $constants = Constants::getConstants("USER");
        $driver = $constants['APP_CONFIG']['default']['DB']['DRIVER'];
        $host = $constants['APP_CONFIG']['default']['DB']['HOST'];
        $db_name = $constants['APP_CONFIG']['default']['DB']['DB_NAME'];
        if(isset($constants['APP_CONFIG']['default']['DB']['charset'])) {
            $charset = $constants['APP_CONFIG']['default']['DB']['charset'];
        } else {
            $charset = self::$charset;
        }
        self::__setDSN($driver, $host, $db_name, $charset);
    }

    // set dsn value
    private static function __setDSN(string $driver, string $host, string $db_name, string $charset) {
        self::$dsn = "$driver:host=$host;dbname=$db_name;charset=$charset";
    }

    // Prepare query condition with AND / OR and = separator
    public function pcEquals(string $separator = "AND", array $columns): LibPdo {
        if(!empty($columns)) {
            $this -> conditionFiller[key($columns)] = current($columns);
            if(!empty($columnNames = array_keys($columns))) {
                if($this ->conditionString) {
                    $this -> conditionString.=" $separator ".$columnNames[0]." = :".$columnNames[0];
                } else {
                    $this -> conditionString = $columnNames[0]." = :".$columnNames[0];
                }
            }
        }
        return $this;
    }

    // Prepare query condition with AND / OR and LIKE separator
    public function pcLike(string $separator = "AND", array $columns): LibPdo {
        try {
            if(!empty($columns)) {
                $this -> conditionFiller[key($columns)] = current($columns);
                if(!empty($columnNames = array_keys($columns))) {
                    if($this ->conditionString) {
                        $this -> conditionString.=" $separator ".$columnNames[0]." LIKE :".$columnNames[0];
                    } else {
                        $this -> conditionString = $columnNames[0]." LIKE :".$columnNames[0];
                    }
                }
            }
        } catch(\Throwable $t) {
            echo $t -> getMessage();
        }
        return $this;
    }

    // Prepare query condition with AND / OR and > separator
    public function pcGt(string $separator = "AND", array $columns): LibPdo {
        try {
            if(!empty($columns)) {
                $this -> conditionFiller[key($columns)] = current($columns);
                if(!empty($columnNames = array_keys($columns))) {
                    if($this ->conditionString) {
                        $this -> conditionString.=" $separator ".$columnNames[0]." > :".$columnNames[0];
                    } else {
                        $this -> conditionString = $columnNames[0]." > :".$columnNames[0];
                    }
                }
            }
        } catch(\Throwable $t) {
            echo $t -> getMessage();
        }
        return $this;
    }

    // Prepare query condition with AND / OR and < separator
    public function pcLt(string $separator = "AND", array $columns): LibPdo {
        try {
            if(!empty($columns)) {
                $this -> conditionFiller[key($columns)] = current($columns);
                if(!empty($columnNames = array_keys($columns))) {
                    if($this ->conditionString) {
                        $this -> conditionString.=" $separator ".$columnNames[0]." < :".$columnNames[0];
                    } else {
                        $this -> conditionString = $columnNames[0]." < :".$columnNames[0];
                    }
                }
            }
        } catch(\Throwable $t) {
            echo $t -> getMessage();
        }
        return $this;
    }

    // Prepare In query
    public function IN(string $separator = "AND", string $column, array $values): LibPdo {
        $inSubStr = ""; // In substring (:val1,:val2,:val3) holder
        $inValCounter = 1;
        $preparedInQueryPayload = array();
        if(!empty($values)) {
            // prepare sub query like (:val1,:val2,:val3)
            array_map(function($value) use (&$inValCounter,&$inSubStr,&$preparedInQueryPayload){
                $placeholder = "val".$inValCounter;
                $inSubStr.=":".$placeholder.",";
                $preparedInQueryPayload[$placeholder] = $value;
                ++$inValCounter;
            }, $values);
            $inSubStr = substr($inSubStr, 0, strlen($inSubStr)-1);;
            $this -> conditionFiller = array_merge($this -> conditionFiller, $preparedInQueryPayload);
            if($this ->conditionString) {
                $this -> conditionString.=" $separator ".$column." IN (".$inSubStr.")";
            } else {
                $this -> conditionString = $column." IN (".$inSubStr.")";
            }
        }
        return $this;
    }

    // Prepare query with Limit
    public function limit(int $limit, int $offset = 0): LibPdo {
        try {
            if($limit) {
                $this -> oBLG.=" LIMIT $offset, $limit";
            }
        } catch (\Throwable $t) {
            echo $t -> getMessage();
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
    public function orderBY(string $clause): LibPdo {
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
            $this -> stmt = (self::$adapter) -> query($sql);
            if($this -> stmt) {
                $this -> clonedStatement = $this -> clonePdoStmt($this -> stmt);
                if($is_chainAble) {
                    return $this;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Add, Update, Delete, Alter
     */
    // Add New Row
    public function addRow(array $row): LibPdo {
        if(!empty($row)) {
            $columnString = implode(",", array_keys($row));
            $this -> conditionFiller = $row;
            $preparedInsertStmt = "";
            array_map(function($colName) use(&$preparedInsertStmt) {
                $preparedInsertStmt.=":".$colName.",";
            }, array_keys($row));
            $preparedInsertStmt = substr($preparedInsertStmt, 0, strlen($preparedInsertStmt)-1);
            $this -> queryString = "insert into ".self::$table." ($columnString) values ( $preparedInsertStmt )";
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
    public function update(array $setColumns): LibPdo {
        if(!empty($setColumns)) {
            $preparedSetStatement = "";
            $setColProcessedCount = 0;
            array_walk($setColumns, function($columnValue, $columnName) use (&$preparedSetStatement, &$setColProcessedCount) {
                $setColName = "setCol".$setColProcessedCount;
                $this -> conditionFiller[$setColName] = $columnValue;
                $preparedSetStatement.=$columnName." = :".$setColName.",";
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
            $this -> queryString = "select count(*) as numRows from ".self::$table." WHERE ".$this -> conditionString;
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
                    if($count = ($this -> stmt) -> first()) {
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

    // execute prepareStatement, executeStatement. Helpful if we need to buffer query string and wait for other changes to happen before executing.
    public function commit(): bool {
        if($this -> prepareStatement() && $this -> executeStatement()) {
            return true;
        }
        return false;
    }

    // prepare and fetch the given columns based on the prepared conditions
    public function fetch(array $columns): LibPdo {
        // prepare query string based on conditions
        if(!empty($columns) && !array_search('*', $columns)) {
            array_map(function($column) {
                return "`".$column."`";
            }, $columns);
            $columns = implode(',', $columns);
            if($this -> conditionString) {
                $this -> queryString = "select $columns from `".self::$table."` WHERE ".$this -> conditionString." ".$this -> oBLG;
            } else {
                $this -> queryString = "select $columns from `".self::$table."` ".$this -> oBLG;
            }
        } else if(!empty($columns)){
            if($this -> conditionString) {
                $this -> queryString = "select * from `".self::$table."` WHERE ".$this -> conditionString." ".$this -> oBLG;
            } else {
                $this -> queryString = "select * from `".self::$table."` ".$this -> oBLG;
            }
        }

//        return $this;
        // prepare and execute
        if($this -> prepareStatement() && $this -> executeStatement()) {
            return $this;
        } else {
            return null;
        }
    }

    // Bind the params given with then current statement
    public function bindWith(array $bindings): LibPdo {
        // check if data type exists in constants array
        if(!empty($bindings) && !empty($this -> conditionFiller)) {
            array_walk($bindings, function ($length, string $data_type ){
                if(isset($data_type) && array_key_exists($data_type, self::DATA_TYPES)) {
                    $conditionKey = key($this -> conditionFiller);
                    $conditionValue = current($this -> conditionFiller);
                    // Holding the values of condition filler to use in binding and removing it from conditionfiller so that we make conditionFiller empty which prevents mistakenly injecting binding values to both execute and bind params.
                    array_shift($this -> conditionFiller);
                    if($length) {
                        ($this -> stmt) -> bindParam(":".$conditionKey, $conditionValue, self::DATA_TYPES[$data_type], $length);
                    } else {
                        ($this -> stmt) -> bindParam(":".$conditionKey, $conditionValue, self::DATA_TYPES[$data_type]);
                    }
                } else {
                    CoreException::__sendErrorResponse("Cannot find $data_type. No such data type found for PDO prepared statements.");
                }
            });
        } else {
            CoreException::__sendErrorResponse("No bindings or conditions found.");
        }
    }
    // Prepare pdo statement
    private function prepareStatement(): bool {
        $pdo = self::$adapter;
        // prepare and assign prepared statement.
        try {
            if($this -> queryString) {
                $this -> stmt = $pdo -> prepare($this -> queryString);
                return true;
            } else {
                CoreException::__sendErrorResponse("No query to prepare");
                return false;
            }
        } catch(\Throwable $t) {
            echo $t -> getMessage();
            return false;
        }
    }

    // Execute pdo statement
    private function executeStatement(): bool {
        try {
            if($this -> stmt) {
                if(!empty($this -> conditionFiller)) {
                    ($this -> stmt) -> execute($this -> conditionFiller);
                } else {
                    ($this -> stmt) -> execute();
                }
                $this -> clonedStatement = $this -> clonePdoStmt($this -> stmt);
                return true;
            } else {
                CoreException::__sendErrorResponse("No statement to execute");
                return false;
            }
        } catch(\Throwable $t) {
            echo $t -> getMessage();
            return false;
        }
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
        $this -> stmt = null; // reset prepared statement
        $this -> clonedStatement = null; // reset cloned prepared statement
        $this -> allRecords = array(); // reset variable to remove records fetched from last query
    }

    // Call different modes of fetch
    public function __call($name, array $argument) {
        try {
            if($this -> clonedStatement) {
                $localCloneStatement = $this -> clonePdoStmt($this -> clonedStatement);
            } else {
                $localCloneStatement = $this -> clonePdoStmt($this -> stmt);
            }
            switch($name) {
                case "all":
                    $this -> allRecords = ($localCloneStatement) -> fetchAll();
                    return $this -> allRecords;
                    break;
                case "enumerate":
                    return $this -> stmt;
                    break;
                case "first":
                    if(empty($this -> allRecords)) {
                        $this -> allRecords = ($localCloneStatement) -> fetchAll();
                    }
                    return current($this -> allRecords);
                    break;
                case "last":
                    if(empty($this -> allRecords)) {
                        $this -> allRecords = ($localCloneStatement) -> fetchAll();
                    }
                    end($this -> allRecords);
                    return current($this -> allRecords);
                    break;
                case "pos":
                    if(empty($this -> allRecords)) {
                        $this -> allRecords = ($localCloneStatement) -> fetchAll();
                    }
                    $allrecords = $this -> allRecords;
                    return $allrecords[$argument[0]];
                    break;
            }
        } catch(\Throwable $t) {
            echo $t -> getMessage();
            return false;
        }
    }

    // Clone PDO statement object by receiving it as a copy and then returning the copy
    private function clonePdoStmt($copyPdoStmt) {
        return $copyPdoStmt;
    }

}