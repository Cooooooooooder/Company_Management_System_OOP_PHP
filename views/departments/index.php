<div class="container mt-5">



    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="mb-0">Departments</h1>

        <a
            href="<?= url('departments/create') ?>"
            class="btn btn-primary">
            Create Department
        </a>

    </div>

    <form
    action="<?= url('departments') ?>"
    method="GET"
    class="mb-4"
>

    <div class="input-group">

        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search departments..."
            value="<?= htmlspecialchars($search ?? '') ?>"
        >

        <button
            type="submit"
            class="btn btn-dark"
        >
            Search
        </button>

        <?php if (!empty($search)): ?>

            <a
                href="<?= url('departments') ?>"
                class="btn btn-outline-secondary"
            >
                Clear
            </a>

        <?php endif; ?>

    </div>

</form>
   
    <?php if (empty($departments)): ?>

        <div class="alert alert-info">
            No departments found.
        </div>

    <?php else: ?>

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead>

                            <thead>

                                <tr>

                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Actions</th>

                                </tr>

                            </thead>
                        </thead>

                        <tbody>

                            <?php foreach ($departments as $department): ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars((string) $department['id']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($department['name']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($department['description'] ?? '') ?>
                                    </td>

                                    <td>

                                        <div class="d-flex gap-2">

                                            <a
                                                href="<?= url('departments/show?id=' . $department['id']) ?>"
                                                class="btn btn-info btn-sm">
                                                View
                                            </a>

                                            <a
                                                href="<?= url('departments/edit?id=' . $department['id']) ?>"
                                                class="btn btn-warning btn-sm">
                                                Edit
                                            </a>

                                            <form
                                                action="<?= url('departments/delete') ?>"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this department?');">

                                                <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?= $department['id'] ?>">

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