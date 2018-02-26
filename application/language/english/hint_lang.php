<?php
/**
 * Created by PhpStorm.
 * User: Cancel
 * Date: 1/3/2017
 * Time: 9:11 PM
 */

$hint_lang = array(
    'hint_no_more_message' => 'there is no more message',
);



if(!is_array($lang))
{
    $lang = array();
}
$lang = array_merge($hint_lang,$lang);

