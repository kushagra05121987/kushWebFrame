<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16/4/18
 * Time: 3:23 PM
 */
class setMailContents
{
    public function mail($message) {
        $message -> to('kushagra.mishra05121987@gmail.com', 'Kushagra Mishra')
            -> subject("Test Email");
//        $job -> delete();
    }
}