<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>CMS OOP</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>

<?php

$successMessage = getFlash('success');
$errorMessage = getFlash('error');

?>

<?php if ($successMessage !== null): ?>

    <div class="container mt-4">

        <div
            class="alert alert-success alert-dismissible fade show"
            role="alert"
        >

            <?= htmlspecialchars($successMessage) ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>

        </div>

    </div>

<?php endif; ?>


<?php if ($errorMessage !== null): ?>

    <div class="container mt-4">

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert"
        >

            <?= htmlspecialchars($errorMessage) ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>

        </div>

    </div>

<?php endif; ?>