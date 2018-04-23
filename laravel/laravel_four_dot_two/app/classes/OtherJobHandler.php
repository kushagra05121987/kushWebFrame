<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16/4/18
 * Time: 1:06 PM
 */

class OtherJobHandler{
    public function fire($job, $arg) {
        echo "\n Firing Job In other job \n";
        sleep($arg['timeout']);
        echo "\n Attempts: ". $job -> attempts()." \n";
        echo "\n Job Id: ". $job->getJobId()." \n";
        if(isset($arg['release']) && $arg['release'] && isset($arg['release_delay']) && $arg['release_delay']) {
            $job -> release($arg['release_delay']);
        } else if(isset($arg['release']) && $arg['release']) {
            $job -> release();
        }

        if(isset($arg['fail_job']) && $arg['fail_job']) {
            throw new Exception('Failed tO proceess the job as asked.', '503');
        }

        if(isset($arg['del_job']) && $arg['del_job']) {
            $job -> delete();
        }
    }

    public function processJobs($job, $arg) {
        echo "\n Processing Job In Other Job \n";
        sleep($arg['timeout']);
        sleep($arg['timeout']);
        echo "\n Attempts: ". $job -> attempts()." \n";
        echo "\n Job Id: ". $job->getJobId()." \n";
        if(isset($arg['release']) && $arg['release'] && isset($arg['release_delay']) && $arg['release_delay']) {
            $job -> release($arg['release_delay']);
        } else if(isset($arg['release']) && $arg['release']) {
            $job -> release();
        }

        if(isset($arg['fail_job']) && $arg['fail_job']) {
            throw new Exception('Failed tO proceess the job as asked.', '503');
        }

        if(isset($arg['del_job']) && $arg['del_job']) {
            $job -> delete();
        }
    }
}