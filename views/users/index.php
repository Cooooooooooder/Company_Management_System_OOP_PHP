<div class="container mt-5">



    <div class="container mt-5">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h1 class="mb-0">
                Users
            </h1>

            <a
                href="<?= url('users/create') ?>"
                class="btn btn-primary">
                Create New User
            </a>

        </div>


        <!-- Search -->

        <form
            action="<?= url('users') ?>"
            method="GET"
            class="mb-4">

            <div class="input-group">

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search by name, email or phone..."
                    value="<?= htmlspecialchars($search ?? '') ?>">

                <button
                    type="submit"
                    class="btn btn-dark">
                    Search
                </button>

                <?php if (!empty($search)): ?>

                    <a
                        href="<?= url('users') ?>"
                        class="btn btn-outline-secondary">
                        Clear
                    </a>

                <?php endif; ?>

            </div>

        </form>




        <?php if (empty($users)): ?>

            <div class="alert alert-info">
                No users found.
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

                                    <th>Email</th>

                                    <th>Phone</th>

                                    <th>Actions</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php foreach ($users as $user): ?>

                                    <tr>

                                        <td>
                                            <?= htmlspecialchars((string) $user['id']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($user['name']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($user['email']) ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars($user['phone']) ?>
                                        </td>

                                        <td>

                                            <div class="d-flex gap-2">

                                                <a
                                                    href="<?= url('users/show?id=' . $user['id']) ?>"
                                                    class="btn btn-info btn-sm">
                                                    View
                                                </a>

                                                <a
                                                    href="<?= url('users/edit?id=' . $user['id']) ?>"
                                                    class="btn btn-warning btn-sm">
                                                    Edit
                                                </a>

                                                <form
                                                    action="<?= url('users/delete') ?>"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this user?');"
                                                    class="d-inline">
                                                    <input
                                                        type="hidden"
                                                        name="id"
                                                        value="<?= htmlspecialchars((string) $user['id']) ?>">

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