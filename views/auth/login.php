<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow-sm">

                <div class="card-body p-4">

                    <h2 class="text-center mb-4">
                        Login
                    </h2>

                    <form
                        action="<?= url('login') ?>"
                        method="POST"
                    >

                        <div class="mb-3">

                            <label
                                for="email"
                                class="form-label"
                            >
                                Email
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                required
                            >

                        </div>


                        <div class="mb-3">

                            <label
                                for="password"
                                class="form-label"
                            >
                                Password
                            </label>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control"
                                required
                            >

                        </div>


                        <div class="mb-3 form-check">

                            <input
                                type="checkbox"
                                class="form-check-input"
                                id="remember"
                                name="remember"
                                value="1"
                            >

                            <label
                                class="form-check-label"
                                for="remember"
                            >
                                Remember Me
                            </label>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            Login
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>