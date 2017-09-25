<?php if($pageCount > 1): ?>
  <ul class="pagination-list">
    <?php foreach ($pages as $page): ?>
      <li class="pagination-item <?php echo intval($page) === intval($currentPage) ? 'pagination-item-active' : '';?>"><a href="<?php echo $addPaginationUrl ? $addPaginationUrl : '';?>page=<?=$page;?>"><?=$page;?></a></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
