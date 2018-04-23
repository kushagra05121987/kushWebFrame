<?php

class BaseController extends Controller {

    public function __construct() {
        \Cookie::queue('xssss-cookie', 'v-cookie', time()+3600);
    }

    /**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
