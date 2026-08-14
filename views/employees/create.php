<div class="container mt-5">

    <h2 class="mb-4">Create New Employee</h2>


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
        action="<?= url('employees/store') ?>"
        method="POST"
        enctype="multipart/form-data"
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
                        <?= ($_SESSION['old']['department_id'] ?? '') == $department['id'] ? 'selected' : '' ?>
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
                value="<?= htmlspecialchars($_SESSION['old']['name'] ?? '') ?>"
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
                value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>"
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
                value="<?= htmlspecialchars($_SESSION['old']['phone'] ?? '') ?>"
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
                value="<?= htmlspecialchars($_SESSION['old']['position'] ?? '') ?>"
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
                value="<?= htmlspecialchars($_SESSION['old']['salary'] ?? '') ?>"
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
                value="<?= htmlspecialchars($_SESSION['old']['hire_date'] ?? '') ?>"
            >

        </div>


        <!-- Image -->

        <div class="mb-3">

            <label class="form-label">
                Employee Image
            </label>

            <input
                type="file"
                name="image"
                class="form-control"
                accept="image/*"
            >

        </div>


        <div class="d-flex gap-2">

            <button
                type="submit"
                class="btn btn-success"
            >
                Save Employee
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