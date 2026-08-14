<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="mb-0">
            Create New Task
        </h1>

        <a
            href="<?= url('tasks') ?>"
            class="btn btn-secondary">
            Back to Tasks
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
                action="<?= url('tasks/store') ?>"
                method="POST">


                <!-- Project -->

                <div class="mb-3">

                    <label
                        for="project_id"
                        class="form-label">
                        Project
                    </label>

                    <select
                        name="project_id"
                        id="project_id"
                        class="form-select"
                        required>

                        <option value="">
                            Select Project
                        </option>


                        <?php foreach ($projects as $project): ?>

                            <option
                                value="<?= $project['id'] ?>"
                                <?= (
                                    (string) ($old['project_id'] ?? '')
                                    === (string) $project['id']
                                ) ? 'selected' : '' ?>>

                                <?= htmlspecialchars(
                                    $project['name']
                                ) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <!-- Employee -->

                <div class="mb-3">

                    <label
                        for="employee_id"
                        class="form-label">
                        Employee
                    </label>

                    <select
                        name="employee_id"
                        id="employee_id"
                        class="form-select"
                        required>

                        <option value="">
                            Select Employee
                        </option>


                        <?php foreach ($employees as $employee): ?>

                            <option
                                value="<?= $employee['id'] ?>"
                                <?= (
                                    (string) ($old['employee_id'] ?? '')
                                    === (string) $employee['id']
                                ) ? 'selected' : '' ?>>

                                <?= htmlspecialchars(
                                    $employee['name']
                                ) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <!-- Title -->

                <div class="mb-3">

                    <label
                        for="title"
                        class="form-label">
                        Task Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control"
                        value="<?= htmlspecialchars(
                                    $old['title'] ?? ''
                                ) ?>"
                        required>

                </div>


                <!-- Description -->

                <div class="mb-3">

                    <label
                        for="description"
                        class="form-label">
                        Description
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        rows="4"><?= htmlspecialchars(
                                        $old['description'] ?? ''
                                    ) ?></textarea>

                </div>


                <!-- Priority -->

                <div class="mb-3">

                    <label
                        for="priority"
                        class="form-label">
                        Priority
                    </label>

                    <select
                        name="priority"
                        class="form-select">

                        <option value="">Select Priority</option>

                        <option
                            value="Low"
                            <?= (($old['priority'] ?? '') === 'Low') ? 'selected' : '' ?>>
                            Low
                        </option>

                        <option
                            value="Medium"
                            <?= (($old['priority'] ?? '') === 'Medium') ? 'selected' : '' ?>>
                            Medium
                        </option>

                        <option
                            value="High"
                            <?= (($old['priority'] ?? '') === 'High') ? 'selected' : '' ?>>
                            High
                        </option>

                    </select>

                </div>


                <!-- Status -->

                <div class="mb-3">

                    <label
                        for="status"
                        class="form-label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select">

                        <option value="">Select Status</option>

                        <option
                            value="Pending"
                            <?= (($old['status'] ?? '') === 'Pending') ? 'selected' : '' ?>>
                            Pending
                        </option>

                        <option
                            value="In Progress"
                            <?= (($old['status'] ?? '') === 'In Progress') ? 'selected' : '' ?>>
                            In Progress
                        </option>

                        <option
                            value="Completed"
                            <?= (($old['status'] ?? '') === 'Completed') ? 'selected' : '' ?>>
                            Completed
                        </option>

                    </select>

                </div>


                <!-- Due Date -->

                <div class="mb-4">

                    <label
                        for="due_date"
                        class="form-label">
                        Due Date
                    </label>

                    <input
                        type="date"
                        name="due_date"
                        id="due_date"
                        class="form-control"
                        value="<?= htmlspecialchars(
                                    $old['due_date'] ?? ''
                                ) ?>">

                </div>


                <!-- Buttons -->

                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary">
                        Create Task
                    </button>

                    <a
                        href="<?= url('tasks') ?>"
                        class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>