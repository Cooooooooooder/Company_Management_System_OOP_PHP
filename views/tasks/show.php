<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="mb-0">
            Task Details
        </h1>

        <div class="d-flex gap-2">

            <a
                href="<?= url('tasks') ?>"
                class="btn btn-secondary"
            >
                Back to Tasks
            </a>

            <a
                href="<?= url('tasks/edit?id=' . $task['id']) ?>"
                class="btn btn-warning"
            >
                Edit
            </a>

        </div>

    </div>


    <div class="card shadow-sm">

        <div class="card-body">

            <div class="row">


                <!-- ID -->

                <div class="col-md-6 mb-4">

                    <div class="border rounded p-3 h-100">

                        <strong class="d-block mb-2">
                            ID
                        </strong>

                        <?= htmlspecialchars(
                            (string) $task['id']
                        ) ?>

                    </div>

                </div>


                <!-- Title -->

                <div class="col-md-6 mb-4">

                    <div class="border rounded p-3 h-100">

                        <strong class="d-block mb-2">
                            Title
                        </strong>

                        <?= htmlspecialchars(
                            $task['title']
                        ) ?>

                    </div>

                </div>


                <!-- Project -->

                <div class="col-md-6 mb-4">

                    <div class="border rounded p-3 h-100">

                        <strong class="d-block mb-2">
                            Project
                        </strong>

                        <?= htmlspecialchars(
                            $task['project_name'] ?? 'N/A'
                        ) ?>

                    </div>

                </div>


                <!-- Employee -->

                <div class="col-md-6 mb-4">

                    <div class="border rounded p-3 h-100">

                        <strong class="d-block mb-2">
                            Employee
                        </strong>

                        <?= htmlspecialchars(
                            $task['employee_name'] ?? 'N/A'
                        ) ?>

                    </div>

                </div>


                <!-- Priority -->

                <div class="col-md-6 mb-4">

                    <div class="border rounded p-3 h-100">

                        <strong class="d-block mb-2">
                            Priority
                        </strong>

                        <?= htmlspecialchars(
                            $task['priority']
                        ) ?>

                    </div>

                </div>


                <!-- Status -->

                <div class="col-md-6 mb-4">

                    <div class="border rounded p-3 h-100">

                        <strong class="d-block mb-2">
                            Status
                        </strong>

                        <?= htmlspecialchars(
                            $task['status']
                        ) ?>

                    </div>

                </div>


                <!-- Due Date -->

                <div class="col-md-6 mb-4">

                    <div class="border rounded p-3 h-100">

                        <strong class="d-block mb-2">
                            Due Date
                        </strong>

                        <?= htmlspecialchars(
                            $task['due_date'] ?? 'N/A'
                        ) ?>

                    </div>

                </div>


                <!-- Created At -->

                <div class="col-md-6 mb-4">

                    <div class="border rounded p-3 h-100">

                        <strong class="d-block mb-2">
                            Created At
                        </strong>

                        <?= htmlspecialchars(
                            $task['created_at'] ?? 'N/A'
                        ) ?>

                    </div>

                </div>


                <!-- Description -->

                <div class="col-12">

                    <div class="border rounded p-3">

                        <strong class="d-block mb-2">
                            Description
                        </strong>

                        <?php if (!empty($task['description'])): ?>

                            <p class="mb-0">
                                <?= nl2br(
                                    htmlspecialchars(
                                        $task['description']
                                    )
                                ) ?>
                            </p>

                        <?php else: ?>

                            <span class="text-muted">
                                No description provided.
                            </span>

                        <?php endif; ?>

                    </div>

                </div>


            </div>

        </div>

    </div>

</div>