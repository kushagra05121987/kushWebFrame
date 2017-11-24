<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 5/11/17
 * Time: 5:07 PM
 */
namespace Core\Model\Adapters\Implement;

interface CommonLibImplements {
    // require the lib creator to implement this method and expose it to for creating lib specific adapter
    public static function __createAdapter();
}