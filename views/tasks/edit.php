<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>Edit Task</h1>

        <a
            href="<?= url('tasks') ?>"
            class="btn btn-secondary"
        >
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
                action="<?= url('tasks/update') ?>"
                method="POST"
            >

                <input
                    type="hidden"
                    name="id"
                    value="<?= htmlspecialchars((string) $task['id']) ?>"
                >


                <!-- Project -->

                <div class="mb-3">

                    <label
                        for="project_id"
                        class="form-label"
                    >
                        Project
                    </label>

                    <select
                        name="project_id"
                        id="project_id"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Select Project
                        </option>


                        <?php foreach ($projects as $project): ?>

                            <?php
                            $selectedProject =
                                $old['project_id']
                                ?? $task['project_id'];
                            ?>

                            <option
                                value="<?= htmlspecialchars((string) $project['id']) ?>"
                                <?= ((int) $selectedProject === (int) $project['id']) ? 'selected' : '' ?>
                            >

                                <?= htmlspecialchars($project['name']) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <!-- Employee -->

                <div class="mb-3">

                    <label
                        for="employee_id"
                        class="form-label"
                    >
                        Employee
                    </label>

                    <select
                        name="employee_id"
                        id="employee_id"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Select Employee
                        </option>


                        <?php foreach ($employees as $employee): ?>

                            <?php
                            $selectedEmployee =
                                $old['employee_id']
                                ?? $task['employee_id'];
                            ?>

                            <option
                                value="<?= htmlspecialchars((string) $employee['id']) ?>"
                                <?= ((int) $selectedEmployee === (int) $employee['id']) ? 'selected' : '' ?>
                            >

                                <?= htmlspecialchars($employee['name']) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <!-- Title -->

                <div class="mb-3">

                    <label
                        for="title"
                        class="form-label"
                    >
                        Task Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control"
                        value="<?= htmlspecialchars($old['title'] ?? $task['title']) ?>"
                        required
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
                        rows="4"
                    ><?= htmlspecialchars($old['description'] ?? $task['description'] ?? '') ?></textarea>

                </div>


                <!-- Priority -->

                <div class="mb-3">

                    <label
                        for="priority"
                        class="form-label"
                    >
                        Priority
                    </label>

                    <?php
                    $selectedPriority =
                        $old['priority']
                        ?? $task['priority'];
                    ?>

                    <select
                        name="priority"
                        id="priority"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Select Priority
                        </option>

                        <option
                            value="Low"
                            <?= $selectedPriority === 'Low' ? 'selected' : '' ?>
                        >
                            Low
                        </option>

                        <option
                            value="Medium"
                            <?= $selectedPriority === 'Medium' ? 'selected' : '' ?>
                        >
                            Medium
                        </option>

                        <option
                            value="High"
                            <?= $selectedPriority === 'High' ? 'selected' : '' ?>
                        >
                            High
                        </option>

                    </select>

                </div>


                <!-- Status -->

                <div class="mb-3">

                    <label
                        for="status"
                        class="form-label"
                    >
                        Status
                    </label>

                    <?php
                    $selectedStatus =
                        $old['status']
                        ?? $task['status'];
                    ?>

                    <select
                        name="status"
                        id="status"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Select Status
                        </option>

                        <option
                            value="Pending"
                            <?= $selectedStatus === 'Pending' ? 'selected' : '' ?>
                        >
                            Pending
                        </option>

                        <option
                            value="In Progress"
                            <?= $selectedStatus === 'In Progress' ? 'selected' : '' ?>
                        >
                            In Progress
                        </option>

                        <option
                            value="Completed"
                            <?= $selectedStatus === 'Completed' ? 'selected' : '' ?>
                        >
                            Completed
                        </option>

                    </select>

                </div>


                <!-- Due Date -->

                <div class="mb-3">

                    <label
                        for="due_date"
                        class="form-label"
                    >
                        Due Date
                    </label>

                    <input
                        type="date"
                        name="due_date"
                        id="due_date"
                        class="form-control"
                        value="<?= htmlspecialchars($old['due_date'] ?? $task['due_date']) ?>"
                        required
                    >

                </div>


                <!-- Buttons -->

                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Update Task
                    </button>

                    <a
                        href="<?= url('tasks') ?>"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>