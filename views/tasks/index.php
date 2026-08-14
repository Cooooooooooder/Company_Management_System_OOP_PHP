<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="mb-0">
            Tasks
        </h1>

        <a
            href="<?= url('tasks/create') ?>"
            class="btn btn-primary">
            Create New Task
        </a>

    </div>

    <form
        action="<?= url('tasks') ?>"
        method="GET"
        class="mb-4">

        <div class="input-group">

            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search by task, project, employee, priority or status..."
                value="<?= htmlspecialchars($search ?? '') ?>">

            <button
                type="submit"
                class="btn btn-dark">
                Search
            </button>

            <?php if (!empty($search)): ?>

                <a
                    href="<?= url('tasks') ?>"
                    class="btn btn-outline-secondary">
                    Clear
                </a>

            <?php endif; ?>

        </div>

    </form>

    <?php if (empty($tasks)): ?>

        <div class="alert alert-info">

            No tasks found.

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
                                            $task['employee_name'] ?? 'N/A'
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
                                            $task['due_date'] ?? 'N/A'
                                        ) ?>
                                    </td>


                                    <td>

                                        <div class="d-flex gap-2">

                                            <a
                                                href="<?= url('tasks/show?id=' . $task['id']) ?>"
                                                class="btn btn-info btn-sm">
                                                View
                                            </a>

                                            <a
                                                href="<?= url('tasks/edit?id=' . $task['id']) ?>"
                                                class="btn btn-warning btn-sm">
                                                Edit
                                            </a>


                                            <form
                                                action="<?= url('tasks/delete') ?>"
                                                method="POST"
                                                class="d-inline">

                                                <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?= htmlspecialchars((string) $task['id']) ?>">

                                                <button
                                                    type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this task?')">
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