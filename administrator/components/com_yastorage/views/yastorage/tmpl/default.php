<?php
defined('_JEXEC') or die;

?>
<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
    <pre>
        <?php var_dump($this->buckets);?>
    </pre>
</div>
