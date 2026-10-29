<?php
$values = $account ?? [];
require_once __DIR__ . '/../layout/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><?= $isEdit ? 'Edit Account' : 'Add Account' ?></h4>
            </div>
            <div class="card-body">
                <form action="<?= $isEdit
                    ? BASE_URL . '/accounts/' . urlencode($id) . '/update'
                    : BASE_URL . '/accounts/store' ?>" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name"
                                   class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                                   value="<?= htmlspecialchars($values['name'] ?? '') ?>">
                            <?php if (isset($errors['name'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['name']) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                   class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                   value="<?= htmlspecialchars($values['email'] ?? '') ?>">
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['email']) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password <?= $isEdit ? '(leave blank to keep)' : '' ?></label>
                            <input type="password" name="password"
                                   class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>">
                            <?php if (isset($errors['password'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['password']) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Account Type</label>
                            <select name="account_type_id"
                                    class="form-select <?= isset($errors['account_type_id']) ? 'is-invalid' : '' ?>">
                                <option value="">-- Select type --</option>
                                <?php foreach ($accountTypes as $type): ?>
                                    <option value="<?= htmlspecialchars($type['id']) ?>"
                                        <?= ($values['account_type_id'] ?? '') === $type['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($type['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['account_type_id'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['account_type_id']) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status"
                                    class="form-select <?= isset($errors['status']) ? 'is-invalid' : '' ?>">
                                <option value="">-- Pilih status --</option>
                                <option value="aktif" <?= ($values['status'] ?? 'aktif') === 'aktif' ? 'selected' : '' ?>>
                                    Aktif
                                </option>
                                <option value="nonaktif" <?= ($values['status'] ?? '') === 'nonaktif' ? 'selected' : '' ?>>
                                    Nonaktif
                                </option>
                            </select>
                            <?php if (isset($errors['status'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['status']) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Identification Number</label>
                            <input type="text" name="identification_number"
                                   class="form-control <?= isset($errors['identification_number']) ? 'is-invalid' : '' ?>"
                                   value="<?= htmlspecialchars($values['identification_number'] ?? '') ?>">
                            <?php if (isset($errors['identification_number'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['identification_number']) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Identification Type</label>
                            <select name="identification_type"
                                    class="form-select <?= isset($errors['identification_type']) ? 'is-invalid' : '' ?>">
                                <option value="nim" <?= ($values['identification_type'] ?? '') === 'nim' ? 'selected' : '' ?>>NIM</option>
                                <option value="nip" <?= ($values['identification_type'] ?? '') === 'nip' ? 'selected' : '' ?>>NIP</option>
                            </select>
                            <?php if (isset($errors['identification_type'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['identification_type']) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username"
                                   class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>"
                                   value="<?= htmlspecialchars($values['username'] ?? '') ?>">
                            <?php if (isset($errors['username'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['username']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Update' : 'Save' ?></button>
                        <a href="<?= BASE_URL ?>/accounts" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
