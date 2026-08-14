<div class="container mt-5">

    <h2 class="mb-4">Edit Employee</h2>


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


    <form
        action="<?= url('employees/update') ?>"
        method="POST"
        enctype="multipart/form-data"
    >

        <input
            type="hidden"
            name="id"
            value="<?= htmlspecialchars((string) $employee['id']) ?>"
        >


        <!-- Department -->

        <div class="mb-3">

            <label class="form-label">
                Department
            </label>

            <select
                name="department_id"
                class="form-select"
            >

                <option value="">
                    Select Department
                </option>

                <?php foreach ($departments as $department): ?>

                    <option
                        value="<?= $department['id'] ?>"
                        <?= (
                            ($_SESSION['old']['department_id']
                                ?? $employee['department_id'])
                            == $department['id']
                        ) ? 'selected' : '' ?>
                    >

                        <?= htmlspecialchars($department['name']) ?>

                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <!-- Name -->

        <div class="mb-3">

            <label class="form-label">
                Name
            </label>

            <input
                type="text"
                name="name"
                class="form-control"
                value="<?= htmlspecialchars(
                    $_SESSION['old']['name']
                    ?? $employee['name']
                ) ?>"
            >

        </div>


        <!-- Email -->

        <div class="mb-3">

            <label class="form-label">
                Email
            </label>

            <input
                type="email"
                name="email"
                class="form-control"
                value="<?= htmlspecialchars(
                    $_SESSION['old']['email']
                    ?? $employee['email']
                ) ?>"
            >

        </div>


        <!-- Phone -->

        <div class="mb-3">

            <label class="form-label">
                Phone
            </label>

            <input
                type="text"
                name="phone"
                class="form-control"
                value="<?= htmlspecialchars(
                    $_SESSION['old']['phone']
                    ?? $employee['phone']
                ) ?>"
            >

        </div>


        <!-- Position -->

        <div class="mb-3">

            <label class="form-label">
                Position
            </label>

            <input
                type="text"
                name="position"
                class="form-control"
                value="<?= htmlspecialchars(
                    $_SESSION['old']['position']
                    ?? $employee['position']
                ) ?>"
            >

        </div>


        <!-- Salary -->

        <div class="mb-3">

            <label class="form-label">
                Salary
            </label>

            <input
                type="number"
                name="salary"
                step="0.01"
                class="form-control"
                value="<?= htmlspecialchars(
                    $_SESSION['old']['salary']
                    ?? $employee['salary']
                ) ?>"
            >

        </div>


        <!-- Hire Date -->

        <div class="mb-3">

            <label class="form-label">
                Hire Date
            </label>

            <input
                type="date"
                name="hire_date"
                class="form-control"
                value="<?= htmlspecialchars(
                    $_SESSION['old']['hire_date']
                    ?? $employee['hire_date']
                ) ?>"
            >

        </div>


        <!-- Current Image -->

        <div class="mb-3">

            <label class="form-label d-block">
                Current Image
            </label>

            <?php if (!empty($employee['image'])): ?>

                <img
                    src="<?= url('/assets/images/' . $employee['image'])?>"
                    alt="<?= htmlspecialchars($employee['name']) ?>"
                    width="120"
                    height="120"
                    class="rounded"
                    style="object-fit: cover;"
                >

            <?php else: ?>

                <span class="text-muted">
                    No Image
                </span>

            <?php endif; ?>

        </div>


        <!-- New Image -->

        <div class="mb-4">

            <label class="form-label">
                New Image
            </label>

            <input
                type="file"
                name="image"
                class="form-control"
                accept="image/jpeg,image/png,image/webp"
            >

            <div class="form-text">
                Leave empty to keep the current image.
            </div>

        </div>


        <!-- Buttons -->

        <div class="d-flex gap-2">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Update Employee
            </button>

            <a
                href="<?= url('employees') ?>"
                class="btn btn-secondary"
            >
                Cancel
            </a>

        </div>

    </form>

</div>


<?php unset($_SESSION['old']); ?>