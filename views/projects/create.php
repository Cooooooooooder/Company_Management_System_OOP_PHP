<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="mb-0">
            Create New Project
        </h1>

        <a
            href="<?= url('projects') ?>"
            class="btn btn-secondary"
        >
            Back to Projects
        </a>

    </div>


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


    <?php

    $old = $_SESSION['old'] ?? [];

    unset($_SESSION['old']);

    ?>


    <div class="card shadow-sm">

        <div class="card-body">

            <form
                action="<?= url('projects/store') ?>"
                method="POST"
            >

                <!-- Manager -->

                <div class="mb-3">

                    <label
                        for="manager_id"
                        class="form-label"
                    >
                        Project Manager
                    </label>

                    <select
                        name="manager_id"
                        id="manager_id"
                        class="form-select"
                    >

                        <option value="">
                            Select Manager
                        </option>

                        <?php foreach ($users as $user): ?>

                            <option
                                value="<?= $user['id'] ?>"
                                <?= (
                                    ($old['manager_id'] ?? '') == $user['id']
                                ) ? 'selected' : '' ?>
                            >

                                <?= htmlspecialchars($user['name']) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <!-- Project Name -->

                <div class="mb-3">

                    <label
                        for="name"
                        class="form-label"
                    >
                        Project Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        value="<?= htmlspecialchars(
                            $old['name'] ?? ''
                        ) ?>"
                    >

                </div>


                <!-- Description -->

                <div class="mb-3">

                    <label
                        for="description"
                        class="form-label"
                    >
                        Description
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        rows="5"
                    ><?= htmlspecialchars(
                        $old['description'] ?? ''
                    ) ?></textarea>

                </div>


                <!-- Status -->

                <div class="mb-3">

                    <label
                        for="status"
                        class="form-label"
                    >
                        Status
                    </label>

                    <select
                        name="status"
                        id="status"
                        class="form-select"
                    >

                        <?php

                        $status = $old['status'] ?? 'pending';

                        ?>

                        <option
                            value="pending"
                            <?= $status === 'pending'
                                ? 'selected'
                                : '' ?>
                        >
                            Pending
                        </option>

                        <option
                            value="active"
                            <?= $status === 'active'
                                ? 'selected'
                                : '' ?>
                        >
                            Active
                        </option>

                        <option
                            value="completed"
                            <?= $status === 'completed'
                                ? 'selected'
                                : '' ?>
                        >
                            Completed
                        </option>

                        <option
                            value="cancelled"
                            <?= $status === 'cancelled'
                                ? 'selected'
                                : '' ?>
                        >
                            Cancelled
                        </option>

                    </select>

                </div>


                <!-- Start Date -->

                <div class="mb-3">

                    <label
                        for="start_date"
                        class="form-label"
                    >
                        Start Date
                    </label>

                    <input
                        type="date"
                        name="start_date"
                        id="start_date"
                        class="form-control"
                        value="<?= htmlspecialchars(
                            $old['start_date'] ?? ''
                        ) ?>"
                    >

                </div>


                <!-- End Date -->

                <div class="mb-4">

                    <label
                        for="end_date"
                        class="form-label"
                    >
                        End Date
                    </label>

                    <input
                        type="date"
                        name="end_date"
                        id="end_date"
                        class="form-control"
                        value="<?= htmlspecialchars(
                            $old['end_date'] ?? ''
                        ) ?>"
                    >

                </div>


                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Create Project
                    </button>

                    <a
                        href="<?= url('projects') ?>"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>