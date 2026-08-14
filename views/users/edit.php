<?php if (!empty($_SESSION['errors'])): ?>

    <div class="container mt-4">

        <div class="alert alert-danger">

            <ul class="mb-0">

                <?php foreach ($_SESSION['errors'] as $error): ?>

                    <li>
                        <?= htmlspecialchars($error) ?>
                    </li>

                <?php endforeach; ?>

            </ul>

        </div>

    </div>

    <?php unset($_SESSION['errors']); ?>

<?php endif; ?>


<div class="container mt-5">

    <h2 class="mb-4">Edit User</h2>

    <form
        action="<?= url('users/update') ?>"
        method="POST"
    >

        <input
            type="hidden"
            name="id"
            value="<?= htmlspecialchars((string) $user['id']) ?>"
        >


        <div class="mb-3">

            <label class="form-label">
                Name
            </label>

            <input
                type="text"
                name="name"
                class="form-control"
                value="<?= htmlspecialchars($_SESSION['old']['name'] ?? $user['name']) ?>"
            >

        </div>


        <div class="mb-3">

            <label class="form-label">
                Email
            </label>

            <input
                type="email"
                name="email"
                class="form-control"
                value="<?= htmlspecialchars($_SESSION['old']['email'] ?? $user['email']) ?>"
            >

        </div>


        <div class="mb-3">

            <label class="form-label">
                Phone
            </label>

            <input
                type="text"
                name="phone"
                class="form-control"
                value="<?= htmlspecialchars($_SESSION['old']['phone'] ?? $user['phone']) ?>"
            >

        </div>


        <div class="mb-3">

            <label class="form-label">
                Password
            </label>

            <input
                type="password"
                name="password"
                class="form-control"
            >

            <small class="text-muted">
                Leave blank if you don't want to change the password.
            </small>

        </div>


        <button
            type="submit"
            class="btn btn-primary"
        >
            Update User
        </button>


        <a
            href="<?= url('users') ?>"
            class="btn btn-secondary"
        >
            Cancel
        </a>

    </form>

</div>


<?php unset($_SESSION['old']); ?>