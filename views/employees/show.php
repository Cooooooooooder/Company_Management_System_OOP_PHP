<div class="container mt-5">

    <!-- Employee Header -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>
            Employee Details
        </h1>

        <div class="d-flex gap-2">

            <a
                href="<?= url('employees/edit?id=' . $employee['id']) ?>"
                class="btn btn-warning"
            >
                Edit
            </a>

            <a
                href="<?= url('employees') ?>"
                class="btn btn-secondary"
            >
                Back
            </a>

        </div>

    </div>


    <!-- Employee Information -->

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <div class="row">

                <!-- Image -->

                <div class="col-md-3 text-center">

                    <?php if (!empty($employee['image'])): ?>

                        <img
                            src="<?= url('assets/images/' . $employee['image']) ?>"
                            width="150"
                            height="150"
                            class="rounded-circle"
                            style="object-fit: cover;"
                            alt="Employee Image"
                        >

                    <?php else: ?>

                        <div class="text-muted">
                            No Image
                        </div>

                    <?php endif; ?>

                </div>


                <!-- Information -->

                <div class="col-md-9">

                    <h3>
                        <?= htmlspecialchars($employee['name']) ?>
                    </h3>


                    <p>
                        <strong>Email:</strong>

                        <?= htmlspecialchars($employee['email']) ?>
                    </p>


                    <p>
                        <strong>Phone:</strong>

                        <?= htmlspecialchars($employee['phone']) ?>
                    </p>


                    <p>
                        <strong>Position:</strong>

                        <?= htmlspecialchars($employee['position']) ?>
                    </p>


                    <p>
                        <strong>Salary:</strong>

                        <?= htmlspecialchars($employee['salary']) ?>
                    </p>


                    <p>
                        <strong>Hire Date:</strong>

                        <?= htmlspecialchars($employee['hire_date']) ?>
                    </p>


                    <p class="mb-0">

                        <strong>Department:</strong>

                        <?= htmlspecialchars(
                            $employee['department_name'] ?? 'N/A'
                        ) ?>

                    </p>

                </div>

            </div>

        </div>

    </div>


    <!-- Assigned Tasks -->

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h2 class="mb-0">
            Assigned Tasks
        </h2>

        <span class="badge bg-primary">

            <?= count($tasks) ?>

        </span>

    </div>


    <?php if (empty($tasks)): ?>

        <div class="alert alert-info">

            No tasks are assigned to this employee.

        </div>

    <?php else: ?>

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>Title</th>

                                <th>Project</th>

                                <th>Priority</th>

                                <th>Status</th>

                                <th>Due Date</th>

                                <th>Actions</th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php foreach ($tasks as $task): ?>

                                <tr>

                                    <td>

                                        <?= htmlspecialchars(
                                            (string) $task['id']
                                        ) ?>

                                    </td>


                                    <td>

                                        <?= htmlspecialchars(
                                            $task['title']
                                        ) ?>

                                    </td>


                                    <td>

                                        <?= htmlspecialchars(
                                            $task['project_name'] ?? 'N/A'
                                        ) ?>

                                    </td>


                                    <td>

                                        <?= htmlspecialchars(
                                            $task['priority']
                                        ) ?>

                                    </td>


                                    <td>

                                        <?= htmlspecialchars(
                                            $task['status']
                                        ) ?>

                                    </td>


                                    <td>

                                        <?= htmlspecialchars(
                                            $task['due_date']
                                        ) ?>

                                    </td>


                                    <td>

                                        <div class="d-flex gap-2">

                                            <a
                                                href="<?= url('tasks/show?id=' . $task['id']) ?>"
                                                class="btn btn-info btn-sm"
                                            >
                                                View
                                            </a>

                                            <a
                                                href="<?= url('tasks/edit?id=' . $task['id']) ?>"
                                                class="btn btn-warning btn-sm"
                                            >
                                                Edit
                                            </a>

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