<?php
function render_wbs($field, $items, $name)
{
  $active_items = array_filter($items, function($item){
    return $item->get('status') !== 'trash';  });

  if (sizeof($active_items) > 0) :
?>

    <select name="<?php echo esc_attr($field['name']) ?>">
      <option value="none">Select a <?= $name ?></option>
      <?php foreach ($active_items as $item) : ?>
        )
        <option value="<?= $item->get('id') ?>" <?= intval($field['value']) === $item->get('id') ? 'selected="selected"' : '' ?>><?= $item->get('name') ?></option>

      <?php endforeach; ?>
    </select>

  <?php else : ?>

    <p>No <?= $name ?>s found</p>

  <?php endif; ?>

  <a href="/wp-admin/admin.php?page=wpbs-<?= sanitize_title($name) ?>s&subpage=add-<?= sanitize_title($name) ?>" target="_blank">Add new <?= $name ?></a>

<?php
}
