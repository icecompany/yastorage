<?php
defined('_JEXEC') or die;

?>
<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
    <div>
        <?php echo $this->loadTemplate('upload'); ?>
    </div>
    <table class="table table-striped">
        <thead><?php echo $this->loadTemplate('head'); ?></thead>
        <tbody><?php echo $this->loadTemplate('body'); ?></tbody>
        <tfoot><?php echo $this->loadTemplate('foot'); ?></tfoot>
    </table>
</div>
