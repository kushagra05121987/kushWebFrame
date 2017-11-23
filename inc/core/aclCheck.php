<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/11/17
 * Time: 6:59 PM
 */

namespace Core;

use Core\Middleware\Acl\ACL as ACL;
use Core\Helpers\Functions as Helper;
use Core\Constants as Constants;
// check if session exists and has valid data other wise redirect to login page
$check = ACL::check();
$statusCheck = false;
$whiteListUrlCalledFlag = false;
function authentication($check, &$statusCheck, &$whiteListUrlCalledFlag) {
    // Process request uri to get the first part to match it against the whitelisted uri
    $uriToMatch = prepareUri();
    // match the uri prepared with the whitelisted uri
    $whiteListUrlCalledFlag = whiteListMatch($uriToMatch);
    // based on the match and ACL check take necessary actions
    aclCallForAction($check, $whiteListUrlCalledFlag, $statusCheck);

}

function prepareUri(): string {
    // Get request uri
    $constants = Constants::getConstants("SYSTEM");
    $request_uri = $constants['REQUEST']['SERVER']['REQUEST_URI'];
// process request uri to get its first part to match against the white listed urls
    $uriMatchPattern = "/\/{1}[a-zA-Z0-9]+\/?/";
    preg_match($uriMatchPattern, $request_uri, $matches);
    if(!empty($matches) && array_key_exists(0, $matches)) {
        $uriToMatch = explode("/", $matches[0]);
        $uriToMatch = $uriToMatch[1];
        return $uriToMatch;
    } else {
        return "/";
    }
}

function whiteListMatch(string $uriToMatch) {
    // get white listed urls
    $whiteListedUrls = $_ENV['whiteListedAclUrls'];
    $whiteListUrlCalledFlag = false;
    $matchCalculation = array_search($uriToMatch, $whiteListedUrls) ;
// if url request in not present in white listed urls then redirect to login page
    if(!is_bool($matchCalculation) && $matchCalculation >= 0) {
        $whiteListUrlCalledFlag = true;
    }
    return $whiteListUrlCalledFlag;
}

function aclCallForAction($check,$whiteListUrlCalledFlag, &$statusCheck) {
    // if acl check is not valid meaning either session is not existent or data in session is not valid
    if(!$check -> is_valid) {
        Helper::cleanSession(); // clean session
        // if url request in not present in white listed urls then redirect to login page
        if(!$whiteListUrlCalledFlag) {
            Helper::redirect(getenv("aclLoginRoute"));
        }
    } else {
        $statusCheck = true;
        // else if acl check is valid and white listed url is accessed redirect to login success url from environment
        if($whiteListUrlCalledFlag) {
            Helper::redirect(getenv("lSUrl"));
        }
    }
}

authentication($check, $statusCheck, $whiteListUrlCalledFlag);