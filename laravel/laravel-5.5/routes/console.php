<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $anticipate = $this -> anticipate('What is you name?', ['Mishra', 'Kushagra']); // auto completion
    $choice = $this -> choice($this -> question("What is your name?"), ['Mishra', 'Kushagra']); // auto completion choices
    $this -> line($choice);
    $this -> info($choice);
    $this -> comment($choice);
    $this -> question($choice);
    $this -> error($choice);
})->describe('Display an inspiring quote');

Artisan::command('features', function() {
    $headers = ['Name', "Age"];
    $rows = [
        ["Kushagra", "30"],
        ["Gas", 23],
        ["Hes", 46],
        ["Ranger", '23']
    ];
    $this -> table($headers, $rows); // prints a beautiful table

    // creates a progress bar
    function performTask($value) {
        sleep(1);
        echo $value;
    }
    $payload = range(1,1000);
    $progress = $this -> output -> createProgressBar(count($payload));
    foreach($payload as $value) {
        performTask($value);
        $progress -> advance();
    }
    $progress -> finish();
});