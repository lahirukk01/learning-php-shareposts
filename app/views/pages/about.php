<?php require APP_ROOT . '/views/inc/header.php'; ?>
    <h1 class="display-3"><?php echo $data['title']; ?></h1>
    <p class="lead"><?php echo $data['description']; ?></p>
    <p>Version: <strong><?php echo APP_VERSION; ?></strong></p>

<input id="page-name" type="hidden" name="page" value="about">

<?php require APP_ROOT . '/views/inc/footer.php';?>