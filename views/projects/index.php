<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="mb-0">Projects</h1>

        <a
            href="<?= url('projects/create') ?>"
            class="btn btn-primary">
            Create New Project
        </a>

    </div>

    <form
        action="<?= url('projects') ?>"
        method="GET"
        class="mb-4">

        <div class="input-group">

            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search by project name, manager or status..."
                value="<?= htmlspecialchars($search ?? '') ?>">

            <button
                type="submit"
                class="btn btn-dark">
                Search
            </button>

            <?php if (!empty($search)): ?>

                <a
                    href="<?= url('projects') ?>"
                    class="btn btn-outline-secondary">
                    Clear
                </a>

            <?php endif; ?>

        </div>

    </form>

    <?php if (empty($projects)): ?>

        <div class="alert alert-info">
            No projects found.
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

                                <th>Manager</th>

                                <th>Status</th>

                                <th>Start Date</th>

                                <th>End Date</th>

                                <th>Actions</th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php foreach ($projects as $project): ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars(
                                            (string) $project['id']
                                        ) ?>
                                    </td>


                                    <td>
                                        <?= htmlspecialchars(
                                            $project['name']
                                        ) ?>
                                    </td>


                                    <td>
                                        <?= htmlspecialchars(
                                            $project['manager_name'] ?? 'N/A'
                                        ) ?>
                                    </td>


                                    <td>

                                        <?php
                                        $status = $project['status'];
                                        ?>

                                        <span class="badge bg-secondary">
                                            <?= htmlspecialchars($status) ?>
                                        </span>

                                    </td>


                                    <td>
                                        <?= htmlspecialchars(
                                            $project['start_date'] ?? 'N/A'
                                        ) ?>
                                    </td>


                                    <td>
                                        <?= htmlspecialchars(
                                            $project['end_date'] ?? 'N/A'
                                        ) ?>
                                    </td>


                                    <td>

                                        <div class="d-flex gap-2">

                                            <a
                                                href="<?= url('projects/show?id=' . $project['id']) ?>"
                                                class="btn btn-info btn-sm">
                                                View
                                            </a>


                                            <a
                                                href="<?= url('projects/edit?id=' . $project['id']) ?>"
                                                class="btn btn-warning btn-sm">
                                                Edit
                                            </a>


                                            <form
                                                action="<?= url('projects/delete') ?>"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this project?');">
                                                <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?= $project['id'] ?>">

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