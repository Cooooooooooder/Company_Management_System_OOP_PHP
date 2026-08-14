<?php if (!empty($_SESSION['errors'])): ?>

    <div class="alert alert-danger">

        <ul class="mb-0">

            <?php foreach ($_SESSION['errors'] as $error): ?>

                <li><?= htmlspecialchars($error) ?></li>

            <?php endforeach; ?>

        </ul>

    </div>

    <?php unset($_SESSION['errors']); ?>

<?php endif; ?>

<div class="container mt-5">

    <h2 class="mb-4">Create New User</h2>

    <form action="<?= url('users/store') ?>" method="POST">
        <div class="mb-3">

            <label class="form-label">
                Name
            </label>

            <input
                type="text"
                name="name"
                class="form-control"
                value="<?= htmlspecialchars($_SESSION['old']['name'] ?? '') ?>">

        </div>

        <div class="mb-3">

            <label class="form-label">
                Email
            </label>

            <input
                type="email"
                name="email"
                class="form-control"
                value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>">

        </div>

        <div class="mb-3">

            <label class="form-label">
                Phone
            </label>

            <input
                type="text"
                name="phone"
                class="form-control"
                value="<?= htmlspecialchars($_SESSION['old']['phone'] ?? '') ?>">

        </div>

        <div class="mb-3">

            <label class="form-label">
                Password
            </label>

            <input
                type="password"
                name="password"
                class="form-control">

        </div>

        <button type="submit" class="btn btn-success">
            Save User
        </button>

    </form>

</div>

<?php unset($_SESSION['old']); ?>