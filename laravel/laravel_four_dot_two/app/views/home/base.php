<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 14/4/18
 * Time: 2:58 PM
 */
echo "\n delivery_status ====> \n";
echo $delivery_status;
echo PHP_EOL;
echo "\n show_notification ====> \n";
echo $show_notification;
echo PHP_EOL;
echo $nameshared;
?>
<form method="post" enctype="multipart/form-data" action="<?php echo URL::route('letter.send'); ?> ">
    <input name="name" value="<?php echo $oldname ?? ""; ?>"/>
    <input name="password" value="<?php echo $oldpassword ?? ""; ?>" />
    <input name="file" type="file" />
    <input name="sbmt" type="submit" />
</form>