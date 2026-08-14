<div class="container mt-4">

    <!-- Dashboard Title -->

    <h2 class="mb-4 fw-bold">
        Dashboard
    </h2>


    <!-- ========================= -->
    <!-- Main Statistics -->
    <!-- ========================= -->

    <div class="row g-3">


        <!-- Users -->

        <div class="col-12 col-md-6 col-lg-3">

            <div class="dashboard-card users-card">

                <div class="card-title">
                    👤 Users
                </div>

                <div class="card-number">
                    <?= htmlspecialchars(
                        (string) ($statistics['users'] ?? 0)
                    ) ?>
                </div>

            </div>

        </div>


        <!-- Departments -->

        <div class="col-12 col-md-6 col-lg-3">

            <div class="dashboard-card departments-card">

                <div class="card-title">
                    🏢 Departments
                </div>

                <div class="card-number">
                    <?= htmlspecialchars(
                        (string) ($statistics['departments'] ?? 0)
                    ) ?>
                </div>

            </div>

        </div>


        <!-- Employees -->

        <div class="col-12 col-md-6 col-lg-3">

            <div class="dashboard-card employees-card">

                <div class="card-title">
                    👨‍💼 Employees
                </div>

                <div class="card-number">
                    <?= htmlspecialchars(
                        (string) ($statistics['employees'] ?? 0)
                    ) ?>
                </div>

            </div>

        </div>


        <!-- Projects -->

        <div class="col-12 col-md-6 col-lg-3">

            <div class="dashboard-card projects-card">

                <div class="card-title">
                    📁 Projects
                </div>

                <div class="card-number">
                    <?= htmlspecialchars(
                        (string) ($statistics['projects'] ?? 0)
                    ) ?>
                </div>

            </div>

        </div>

    </div>


    <!-- ========================= -->
    <!-- Task Statistics -->
    <!-- ========================= -->

    <div class="row g-3 mt-1">


        <!-- Total Tasks -->

        <div class="col-12 col-md-4">

            <div class="dashboard-card tasks-card">

                <div class="card-title">
                    ☑️ Total Tasks
                </div>

                <div class="card-number">
                    <?= htmlspecialchars(
                        (string) ($statistics['tasks'] ?? 0)
                    ) ?>
                </div>

            </div>

        </div>


        <!-- Completed -->

        <div class="col-12 col-md-4">

            <div class="dashboard-card completed-card">

                <div class="card-title">
                    🎉 Completed
                </div>

                <div class="card-number">
                    <?= htmlspecialchars(
                        (string) ($statistics['completed_tasks'] ?? 0)
                    ) ?>
                </div>

            </div>

        </div>


        <!-- Pending -->

        <div class="col-12 col-md-4">

            <div class="dashboard-card pending-card">

                <div class="card-title">
                    ⏳ Pending
                </div>

                <div class="card-number">
                    <?= htmlspecialchars(
                        (string) ($statistics['pending_tasks'] ?? 0)
                    ) ?>
                </div>

            </div>

        </div>

    </div>

</div>


<style>

    .dashboard-card {

        background: #ffffff;

        border-radius: 6px;

        padding: 12px 15px;

        text-align: center;

        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);

        min-height: 75px;

        transition: 0.2s ease;

    }


    .dashboard-card:hover {

        transform: translateY(-2px);

        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.16);

    }


    .card-title {

        font-size: 14px;

        font-weight: 500;

        margin-bottom: 3px;

        color: #222;

    }


    .card-number {

        font-size: 26px;

        font-weight: 600;

        line-height: 1.2;

    }


    /* Users */

    .users-card .card-number {

        color: #0d6efd;

    }


    /* Departments */

    .departments-card .card-number {

        color: #198754;

    }


    /* Employees */

    .employees-card .card-number {

        color: #0dcaf0;

    }


    /* Projects */

    .projects-card .card-number {

        color: #ffc107;

    }


    /* Total Tasks */

    .tasks-card .card-number {

        color: #212529;

    }


    /* Completed */

    .completed-card .card-number {

        color: #198754;

    }


    /* Pending */

    .pending-card .card-number {

        color: #dc3545;

    }

</style>