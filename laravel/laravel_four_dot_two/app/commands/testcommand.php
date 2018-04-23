<?php namespace testComamnd;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class testcommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'run:tests';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		//
        echo "\n Options \n";
        print_r($this -> option());
        echo "\n Arguments \n";
        print_r($this -> argument());
        echo "\n ------- \n";
//        print_r($this -> app); // not found here
//        print_r(\$app); // not found here
        echo "-----------";
//        $foo = \App::make('fooser');
//        print_r($foo);
        print_r($this -> info('The value for option 1 is'.$this -> option('option1')));
        print_r($this -> error('The value for argument 1 is'.$this -> argument('a1')));
        print_r($this -> ask('What is your name ?'));
        print_r($this -> secret('What is your password ?'));
        print_r($this -> confirm('Is your favourite color blue ?')); // return 1 on yes otherwise nothing
        print_r($this -> question('What is your name ?'));

        \JMin::startMinification();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('a1', InputArgument::REQUIRED, 'This is a required argument 1.'),
            array('a3', InputArgument::REQUIRED, 'This is a required argument 2.'),
            array('a2', InputArgument::OPTIONAL, 'This is an optional argument 1.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('option2', 'ot', InputOption::VALUE_REQUIRED, 'This is a required option.', null),
            array('option3', 'oth', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'This is an array option.', [1]),// Array has to be used with optional or required flag.
            array('option4', 'ofo', InputOption::VALUE_NONE, 'This is a non option.', null),// this becomes boolean indicating if its set or not.
            array('option1', 'oo', InputOption::VALUE_OPTIONAL, 'This is an optional option.', null),
        );
	}

}
