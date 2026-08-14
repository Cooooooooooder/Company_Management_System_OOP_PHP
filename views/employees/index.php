<div class="container mt-5">


    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="mb-0">Employees</h1>

        <a
            href="<?= url('employees/create') ?>"
            class="btn btn-primary">
            Create New Employee
        </a>

    </div>

    <form
        action="<?= url('employees') ?>"
        method="GET"
        class="mb-4">

        <div class="input-group">

            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search by name, email, phone or department..."
                value="<?= htmlspecialchars($search ?? '') ?>">

            <button
                type="submit"
                class="btn btn-dark">
                Search
            </button>

            <?php if (!empty($search)): ?>

                <a
                    href="<?= url('employees') ?>"
                    class="btn btn-outline-secondary">
                    Clear
                </a>

            <?php endif; ?>

        </div>

    </form>

    <?php if (empty($employees)): ?>

        <div class="alert alert-info">
            No employees found.
        </div>

    <?php else: ?>

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>Name</th>

                                <th>Image</th>

                                <th>Email</th>

                                <th>Phone</th>

                                <th>Department</th>

                                <th>Position</th>

                                <th>Salary</th>

                                <th>Hire Date</th>

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
                                        <?= htmlspecialchars(
                                            $employee['name']
                                        ) ?>
                                    </td>

                                    <td>

                                        <?php if (!empty($employee['image'])): ?>

                                            <img
                                                src="<?= url('/assets/images/' . $employee['image']) ?>"
                                                width="50"
                                                height="50"
                                                class="rounded-circle"
                                                style="object-fit: cover;">

                                        <?php else: ?>

                                            <span class="text-muted">
                                                No Image
                                            </span>

                                        <?php endif; ?>

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
                                            $employee['department_name'] ?? 'N/A'
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
                                        <?= htmlspecialchars(
                                            $employee['hire_date']
                                        ) ?>
                                    </td>


                                    <td>

                                        <div class="d-flex gap-2">

                                            <a
                                                href="<?= url('employees/show?id=' . $employee['id']) ?>"
                                                class="btn btn-info btn-sm">
                                                View
                                            </a>

                                            <a
                                                href="<?= url('employees/edit?id=' . $employee['id']) ?>"
                                                class="btn btn-warning btn-sm">
                                                Edit
                                            </a>

                                            <form
                                                action="<?= url('employees/delete') ?>"
                                                method="POST">
                                                <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?= $employee['id'] ?>">

                                                <button
                                                    type="submit"
                                                    class="btn btn-danger btn-sm">
                                                    Delete
                                                </button>
                                            </form>

                                        </div>

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