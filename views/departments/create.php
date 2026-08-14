<div class="container mt-5">

    <?php if (!empty($_SESSION['errors'])): ?>

        <div class="alert alert-danger">

            <ul class="mb-0">

                <?php foreach ($_SESSION['errors'] as $error): ?>

                    <li>
                        <?= htmlspecialchars($error) ?>
                    </li>

                <?php endforeach; ?>

            </ul>

        </div>

        <?php unset($_SESSION['errors']); ?>

    <?php endif; ?>


    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="mb-0">Create Department</h1>

        <a
            href="<?= url('departments') ?>"
            class="btn btn-secondary"
        >
            Back
        </a>

    </div>


    <div class="card shadow-sm">

        <div class="card-body">

            <form
                action="<?= url('departments/store') ?>"
                method="POST"
            >

                <div class="mb-3">

                    <label class="form-label">
                        Department Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="<?= htmlspecialchars($_SESSION['old']['name'] ?? '') ?>"
                    >

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        Description
                    </label>

                    <textarea
                        name="description"
                        class="form-control"
                        rows="5"
                    ><?= htmlspecialchars($_SESSION['old']['description'] ?? '') ?></textarea>

                </div>


                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Save Department
                </button>

            </form>

        </div>

    </div>

</div>


<?php unset($_SESSION['old']); ?>