<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
foreach ($this->items as $name => $item) :
    ?>
    <tr class="row0">
        <td>
            <?php echo $item['key'];?>
        </td>
        <td>
            <?php echo $item['size'];?>
        </td>
        <td>
            <?php echo $item['modified'];?>
        </td>
        <td>
            <?php echo $item['storage'];?>
        </td>
    </tr>
<?php endforeach; ?>