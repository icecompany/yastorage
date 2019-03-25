<?php
defined('_JEXEC') or die;
$listOrder    = $this->escape($this->state->get('list.ordering'));
$listDirn    = $this->escape($this->state->get('list.direction'));
?>
<tr>
    <th>
        <?php echo JText::sprintf('COM_YASTORAGE_HEAD_OBJECT_NAME'); ?>
    </th>
    <th>
        <?php echo JText::sprintf('COM_YASTORAGE_HEAD_OBJECT_SIZE'); ?>
    </th>
    <th>
        <?php echo JText::sprintf('COM_YASTORAGE_HEAD_OBJECT_MODIFY_DATE'); ?>
    </th>
    <th>
        <?php echo JText::sprintf('COM_YASTORAGE_HEAD_OBJECT_STORAGE_CLASS'); ?>
    </th>
    <th>
        <?php echo JText::sprintf('COM_YASTORAGE_HEAD_OBJECT_LINK_PREVIEW'); ?>
    </th>
</tr>