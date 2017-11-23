<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13/11/17
 * Time: 2:47 PM
 */
namespace Core;

class LibApcu {
    // apcu loaded status
    public $is_loaded = false;
    public function __construct() {
        // check if apcu is loaded then set identifier as true
        if(extension_loaded('apcu')) {
            $this -> is_loaded = true;
        }
    }
    // store value in apcu
    public function store(string $key, $value): bool {
        try{
            // if key exists then pull the data from it and check if it is array then append new data to it otherwise replace it
            if(\apcu_exists($key)) {
                $apcStore = \apcu_fetch($key);
                // check if returned value is array
                if(\is_array($apcStore)) {
                    array_push($apcStore, $value);
                } else {
                    $apcStore = $value;
                }
            } else { // if key doesn't exists then create an empty array and add the value to it
                $apcStore = [];
                array_push($apcStore, $value);
            }
            // return true if store was success
            if(\apcu_store($key, $apcStore)) {
                return true;
            } else {
                return false;
            }
        } catch(\Throwable $t) {
            echo PHP_EOL;
            echo $t -> getMessage();
            echo PHP_EOL;
            return false;
        }
    }

    // return the stored apcu value if found
    public function fetch(string $key) {
        try {
            if(\apcu_exists($key)) { // check if key exists in apcu store then return it
                return \apcu_fetch($key);
            } else { //otherwise return false
                return false;
            }
        } catch(\Throwable $t) {
            echo PHP_EOL;
            echo $t -> getMessage();
            echo PHP_EOL;
            return false;
        }
    }

    // delete apcu entry
    public function remove(string $key): bool {
        // check if apcu entry exists then remove it
        if(\apcu_exists($key)) {
            \apcu_delete($key);
            return true;
        } else {
            return false;
        }
    }
}