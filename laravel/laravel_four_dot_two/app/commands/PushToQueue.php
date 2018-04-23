<?php
namespace LAtrisan\Push\Q;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PushToQueue extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'push:queue';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Pushes Jobs To Queue.';

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
		if($this -> option('start')) {
            \Queue::push('JobHandler', ['del_job' => true, "timeout" => 15], 'queue1');
//            \Queue::bulk(['JobHandler@processJobs', \OtherJobHandler::class, "OtherJobHandler@processJobs"], ['del_job' => false, "timeout" => 20, 'release' => true], 'queue2');
//            \Queue::push(\OtherJobHandler::class, ['del_job' => true, "timeout" => 10, 'release' => true, 'release_delay' => 10], 'queue3');
//            \Queue::push('JobHandler@processJobs', ['del_job' => true, "timeout" => 2, 'release' => false, 'fail_job' => true], 'queue4');
        }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
            array('example', InputArgument::OPTIONAL, 'An example argument.'),
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
			array('start', null, InputOption::VALUE_NONE, 'Tells to start pushing.', null),
		);
	}

}
