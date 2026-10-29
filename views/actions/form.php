<?php
$values = $actions ?? [];

require_once __DIR__ . '/../layout/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Form Actions</h4>
            </div>

            <div class="card-body">
                <form action="<?= $isEdit ? BASE_URL . '/actions/' . $id . '/update' : BASE_URL . '/actions/store' ?>" method="POST">

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                               value="<?= htmlspecialchars($values['name'] ?? '') ?>">
                        <?php if (isset($errors['name'])): ?>
                            <div class="invalid-feedback"><?= $errors['name'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="4"
                                  class="form-control <?= isset($errors['description']) ? 'is-invalid' : '' ?>"><?= htmlspecialchars($values['description'] ?? '') ?></textarea>
                        <?php if (isset($errors['description'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['description']) ?></div>
                        <?php endif; ?>
                        <div class="form-text">
                            Jelaskan aktivitas yang diizinkan, misalnya: melihat daftar akun.
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Update' : 'Save' ?></button>
                        <a href="<?= BASE_URL ?>/actions" class="btn btn-secondary">Cancel</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
