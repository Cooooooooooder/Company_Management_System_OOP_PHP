<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">

    <div class="container">

        <!-- Logo -->

        <a
            class="navbar-brand fw-bold"
            href="<?= url('') ?>">
            CMS OOP
        </a>





        <!-- Navigation -->

        <div
            class="collapse navbar-collapse"
            id="navbar">

            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">


                <!-- Home -->

                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="<?= url('') ?>">
                        Home
                    </a>

                </li>


                <!-- About -->

                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="<?= url('about') ?>">
                        About
                    </a>

                </li>


                <!-- Contact -->

                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="<?= url('contact') ?>">
                        Contact
                    </a>

                </li>


                <?php if (isAuthenticated()): ?>


                    <!-- Dashboard -->

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="<?= url('dashboard') ?>">
                            Dashboard
                        </a>

                    </li>


                    <!-- Users -->

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="<?= url('users') ?>">
                            Users
                        </a>

                    </li>


                    <!-- Departments -->

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="<?= url('departments') ?>">
                            Departments
                        </a>

                    </li>


                    <!-- Employees -->

                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="<?= url('employees') ?>">
                            Employees
                        </a>

                    </li>

                    <!-- projects -->
                     
                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="<?= url('projects') ?>">
                            Projects
                        </a>

                    </li>

                    <!-- tasks -->

                      <li class="nav-item">

                        <a
                            class="nav-link"
                            href="<?= url('tasks') ?>">
                            Tasks
                        </a>


                    <!-- Logout -->

                    <li class="nav-item ms-lg-2">

                        <form
                            action="<?= url('logout') ?>"
                            method="POST"
                            class="d-inline">

                            <button
                                type="submit"
                                class="btn btn-outline-light btn-sm px-3">
                                Logout
                            </button>

                        </form>

                    </li>


                <?php else: ?>


                    <!-- Login -->

                    <li class="nav-item ms-lg-2">

                        <a
                            href="<?= url('login') ?>"
                            class="btn btn-primary btn-sm px-3">
                            Login
                        </a>

                    </li>


                <?php endif; ?>


            </ul>

        </div>

    </div>

</nav>