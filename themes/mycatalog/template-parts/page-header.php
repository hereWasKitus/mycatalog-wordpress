<!-- PAGE HEADER -->
<section class="page-header">
  <div class="wrapper">
    <div class="inner">

      <h1><?= __('choose for yourself', 'mycatalog') ?></h1>
      <ul>
        <?php foreach ( get_franchise_pages() as $page ): ?>
        <li><a href="<?= $page['link'] ?>"><?= $page['name'] ?></a></li>
        <?php endforeach; ?>
      </ul>

    </div>
  </div>
</section>