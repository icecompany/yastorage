<?php
defined('_JEXEC') or die;
?>
<form action="<?php echo $this->uploadAction;?>" name="adminForm" id="adminForm" method="post">
    <input type="url" name="jform[url]" id="jform_url">
    <input type="submit" value="<?php echo JText::sprintf('COM_YASTORAGE_ACTION_UPLOAD');?>">
</form>
