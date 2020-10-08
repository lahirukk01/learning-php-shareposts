<?php require APP_ROOT . '/views/inc/header.php'; ?>

<a href="<?php echo URL_ROOT; ?>/posts/show/<?php echo $data['id']; ?>" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<div class="card card-body bg-light mt-5">
    <h2>Edit Post</h2>
    <p>Create a post with this form</p>
    <form action="<?php echo URL_ROOT; ?>/posts/edit/<?php echo $data['id']; ?>" method="post">
        <div class="form-group">
            <label for="title">Title: <sup>*</sup></label>
            <input type="text" name="title" class="form-control form-control-lg
                <?php echo (!empty($data['title_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
            <span class="invalid-feedback"><?php echo $data['title_error']; ?></span>
        </div>
        <div class="form-group">
            <label for="password">Body: <sup>*</sup></label>
            <textarea type="text" name="body" class="form-control form-control-lg
                <?php echo (!empty($data['body_error'])) ? 'is-invalid' : ''; ?>"><?php echo $data['body']; ?></textarea>
            <span class="invalid-feedback"><?php echo $data['body_error']; ?></span>
        </div>
        <input type="submit" class="btn btn-success">
    </form>
</div>

<?php require APP_ROOT . '/views/inc/footer.php';?>