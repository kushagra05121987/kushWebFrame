<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16/4/18
 * Time: 12:58 PM
 */
class JobHandler {
    public function fire($job, $arg) {
        echo "\n Firing Job \n";
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
        \Mail::send([], [], function($message)
        {
            $message->to('kushagra.mishra05121987@gmail.com', 'Kushagra Mishra')->subject('Welcome!') -> setBody('This is a mail');
        });

        if(isset($arg['del_job']) && $arg['del_job']) {
            sleep(10);
            $job -> delete();
        }
    }

    public function processJobs($job, $arg) {
        echo "\n Processing Job \n";
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

    public function sendMail($job, $data) {
        \Mail::send([], [], function($message)
        {
            $message->to('kushagra.mishra05121987@gmail.com', 'Kushagra Mishra')->subject('Welcome!') -> setBody('This is a mail');
        });
        $job -> delete();
    }
    public function sendMailbody($message) {
        $message -> to('kushagra.mishra05121987@gmail.com', 'Kushagra Mishra')
                    -> subject("Test Email");
    }
}