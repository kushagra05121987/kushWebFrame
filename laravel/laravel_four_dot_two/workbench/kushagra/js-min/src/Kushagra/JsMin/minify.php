<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/4/18
 * Time: 8:12 PM
 */
namespace Kushagra\JsMin;
use Kushagra\JsMin\DefaultFiles;
class Minify {
    private $baseFiles = null;
    public function __construct(DefaultFiles $df) {
        $this -> baseFiles = $df;
        echo json_encode($df);
    }

    private function initMinFiles() {
        echo "\n Starting Bootstraping of Minified Files \n";
    }

    private function loadMinFiles() {
        echo "\n Reading Files to Minify  \n";
    }

    public function startMinification() {
        echo "\n ============ \n";
        print_r(\Config::get('js-min::config.base_url'));
        echo "<br />";
        print_r(\Lang::get('js-min::messages.apples', ['count' => 10]));
        echo "\n ============ \n";
        $this -> initMinFiles();
        $this -> loadMinFiles();
        echo "\n Minifiying Files ... \n";
    }
}