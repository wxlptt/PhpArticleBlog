<?php

use src\Repositories\UserRepository;

// TODO: get the authenticated user if there is one, and conditonally render the appropriate buttons.
// 
// If the user is authenticated: show the new article button and logout button
// If we have a guest user: show the login and registration buttons

?>

<div class="navbar bg-indigo-500 text-primary-content">
    <div class="flex-1">
        <a class="btn btn-ghost normal-case text-xl" href="/">COMP 3015 News</a>
        <?php if (isset($_SESSION['authentication'])) : ?>
            <form action="/create_article" method="get">
                <input type="hidden" id="userId" name="userId" value="<?= $_SESSION['userId'] ?? null ?>" />
                <button class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Add New</button>
            </form>
        <?php endif; ?>

    </div>
    <li class="flex-none">
        <ul class="menu menu-horizontal px-1">
            <?php if (!isset($_SESSION['authentication']) || $_SESSION['authentication'] === false) : ?>

                <form action="/login" method="get">
                    <button class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Sign in</button>
                </form>
                <form action="/register" method="get">
                    <button class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Create account</button>
                </form>
                <img class="h-8 w-8 rounded-full" src="images/default.png" alt="">

            <?php else: ?>
                <form action="/logout" method="post">
                    <button class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Log out</button>
                </form>
                <form action="/setting" method="get">
                    <button type="submit">
                        <input type="text" name="id" value="<?= $_SESSION['userId'] ?>" hidden="hidden">
                        <img class="h-8 w-8 rounded-full" src="images/<?= htmlspecialchars($_SESSION['profilePicture'] ?? 'default.png') ?>" alt="">
                    </button>
                </form>


            <?php endif; ?>

        </ul>
</div>

<style>
    .clickable {
        cursor: pointer;
    }

    .cover {
        object-fit: cover;
    }
</style>