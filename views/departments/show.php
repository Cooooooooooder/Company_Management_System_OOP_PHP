<div class="container mt-5">

    <!-- Department Information -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>
            Department Details
        </h1>

        <div class="d-flex gap-2">

            <a
                href="<?= url('departments/edit?id=' . $department['id']) ?>"
                class="btn btn-warning"
            >
                Edit
            </a>

            <a
                href="<?= url('departments') ?>"
                class="btn btn-secondary"
            >
                Back
            </a>

        </div>

    </div>


    <!-- Department Card -->

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <h3 class="card-title">
                <?= htmlspecialchars($department['name']) ?>
            </h3>


            <p class="card-text">

                <strong>Description:</strong>

                <?= !empty($department['description'])
                    ? htmlspecialchars($department['description'])
                    : 'No description'
                ?>

            </p>


            <p class="text-muted mb-0">

                Department ID:

                <?= htmlspecialchars((string) $department['id']) ?>

            </p>

        </div>

    </div>


    <!-- Employees -->

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h2 class="mb-0">
            Employees
        </h2>

        <span class="badge bg-primary">
            <?= count($employees) ?>
        </span>

    </div>


    <?php if (empty($employees)): ?>

        <div class="alert alert-info">

            No employees are assigned to this department.

        </div>

    <?php else: ?>

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>Image</th>

                                <th>Name</th>

                                <th>Email</th>

                                <th>Phone</th>

                                <th>Position</th>

                                <th>Salary</th>

                                <th>Actions</th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php foreach ($employees as $employee): ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars(
                                            (string) $employee['id']
                                        ) ?>
                                    </td>


                                    <td>

                                        <?php if (!empty($employee['image'])): ?>

                                            <img
                                                src="<?= url('assets/images/' . $employee['image']) ?>"
                                                width="50"
                                                height="50"
                                                class="rounded-circle"
                                                style="object-fit: cover;"
                                                alt="Employee Image"
                                            >

                                        <?php else: ?>

                                            <span class="text-muted">
                                                No Image
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <td>
                                        <?= htmlspecialchars(
                                            $employee['name']
                                        ) ?>
                                    </td>


                                    <td>
                                        <?= htmlspecialchars(
                                            $employee['email']
                                        ) ?>
                                    </td>


                                    <td>
                                        <?= htmlspecialchars(
                                            $employee['phone']
                                        ) ?>
                                    </td>


                                    <td>
                                        <?= htmlspecialchars(
                                            $employee['position']
                                        ) ?>
                                    </td>


                                    <td>
                                        <?= htmlspecialchars(
                                            $employee['salary']
                                        ) ?>
                                    </td>


                                    <td>

                                        <a
                                            href="<?= url('employees/show?id=' . $employee['id']) ?>"
                                            class="btn btn-info btn-sm"
                                        >
                                            View
                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    <?php endif; ?>

</div>