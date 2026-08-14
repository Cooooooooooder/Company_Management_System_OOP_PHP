<div class="container mt-5">


    <!-- Project Header -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>
            Project Details
        </h1>

        <div class="d-flex gap-2">

            <a
                href="<?= url('projects/edit?id=' . $project['id']) ?>"
                class="btn btn-warning"
            >
                Edit
            </a>

            <a
                href="<?= url('projects') ?>"
                class="btn btn-secondary"
            >
                Back
            </a>

        </div>

    </div>


    <!-- Project Information -->

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <h3 class="card-title mb-3">

                <?= htmlspecialchars($project['name']) ?>

            </h3>


            <p class="mb-2">

                <strong>Status:</strong>

                <?= htmlspecialchars($project['status']) ?>

            </p>


            <p class="mb-2">

                <strong>Start Date:</strong>

                <?= htmlspecialchars($project['start_date']) ?>

            </p>


            <p class="mb-2">

                <strong>End Date:</strong>

                <?= htmlspecialchars($project['end_date']) ?>

            </p>


            <p class="mb-0">

                <strong>Manager ID:</strong>

                <?= htmlspecialchars(
                    (string) $project['manager_id']
                ) ?>

            </p>

        </div>

    </div>


    <!-- Tasks -->

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h2 class="mb-0">
            Tasks
        </h2>

        <span class="badge bg-primary">

            <?= count($tasks) ?>

        </span>

    </div>


    <?php if (empty($tasks)): ?>

        <div class="alert alert-info">

            No tasks are assigned to this project.

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

                                <th>Employee</th>

                                <th>Priority</th>

                                <th>Status</th>

                                <th>Due Date</th>

                                <th>Actions</th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php foreach ($tasks as $task): ?>

                                <tr>


                                    <!-- ID -->

                                    <td>

                                        <?= htmlspecialchars(
                                            (string) $task['id']
                                        ) ?>

                                    </td>


                                    <!-- Title -->

                                    <td>

                                        <?= htmlspecialchars(
                                            $task['title']
                                        ) ?>

                                    </td>


                                    <!-- Employee -->

                                    <td>

                                        <?= htmlspecialchars(
                                            $task['employee_name'] ?? 'N/A'
                                        ) ?>

                                    </td>


                                    <!-- Priority -->

                                    <td>

                                        <?= htmlspecialchars(
                                            $task['priority']
                                        ) ?>

                                    </td>


                                    <!-- Status -->

                                    <td>

                                        <?= htmlspecialchars(
                                            $task['status']
                                        ) ?>

                                    </td>


                                    <!-- Due Date -->

                                    <td>

                                        <?= htmlspecialchars(
                                            $task['due_date']
                                        ) ?>

                                    </td>


                                    <!-- Actions -->

                                    <td>

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