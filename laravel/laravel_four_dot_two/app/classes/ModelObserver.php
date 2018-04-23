<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18/4/18
 * Time: 5:12 PM
 */

class ModelObserver{
    public function saving($model) {
        print_r("Saving ....");
    }
    public function saved($model) {
        print_r("Saved ....");
    }
    public function updating($model) {
        print_r("Updating ....");
    }
    public function updated($model) {
        print_r("Updated ....");
    }
}