<div class="container mt-5">

    <h2 class="mb-4">User Details</h2>

    <div class="card">

        <div class="card-body">

            <div class="mb-3">
                <strong>ID:</strong>
                <?= htmlspecialchars((string) $user['id']) ?>
            </div>

            <div class="mb-3">
                <strong>Name:</strong>
                <?= htmlspecialchars($user['name']) ?>
            </div>

            <div class="mb-3">
                <strong>Email:</strong>
                <?= htmlspecialchars($user['email']) ?>
            </div>

            <div class="mb-3">
                <strong>Phone:</strong>
                <?= htmlspecialchars($user['phone']) ?>
            </div>

            <a href="<?= url('users') ?>" class="btn btn-secondary">
                Back to Users
            </a>

            <a href="<?= url('users/edit?id=' . $user['id']) ?>"
               class="btn btn-warning">
                Edit
            </a>

        </div>

    </div>

</div>