<?php require APP_ROOT . '/views/inc/header.php'; ?>

<?php flash('post_message'); ?>
<a href="<?php echo URL_ROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<br>
<h1><?php echo $data['post']->title; ?></h1>
<div class="bg-secondary text-white p-2 mb-3">
    Written by <?php echo $data['post']->name; ?> on <?php echo $data['post']->post_created_at; ?>
</div>
<p><?php echo $data['post']->body; ?></p>

<?php if ($data['post']->user_id == $_SESSION['user_id']): ?>
    <hr>
    <a href="<?php echo URL_ROOT; ?>/posts/edit/<?php echo $data['post']->post_id; ?>" class="btn btn-dark">Edit</a>
    <form action="<?php echo URL_ROOT; ?>/posts/delete/<?php echo $data['post']->post_id; ?>" method="post" class="pull-right">
        <input type="submit" value="Delete" class="btn btn-danger">
    </form>
<?php endif; ?>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
