<?php
require_once 'header.php';
use src\Repositories\ArticleRepository;
use src\Repositories\UserRepository;

// Magic Number
$_UNIXTIME_MIN = 60;
$_UNIXTIME_HOUR = 3600;
$_UNIXTIME_DAY = 86400;
$_UNIXTIME_WEEK = 604800;
$_UNIXTIME_MONTH = 2592000;
$_UNIXTIME_YEAR = 31536000;

$articleRepository = new ArticleRepository();
$articles = $articleRepository->getAllArticles();
$userRepository = new UserRepository();
?>

<body>

    <?php require_once 'nav.php' ?>

    <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">

        <h1 class="text-xl text-center font-semibold text-indigo-500 mt-10 mb-10 title">Articles</h1>

        <h6 class="text-center"><?= count($articles) === 0 ? "No articles yet :(" : ""; ?></h6>

            <div class="sm:rounded-md">
                    <ul role="list" class="mb-20">

                        <!-- Iterate the articles from newest to oldest. -->
                        <?php for ($i = count($articles) - 1; $i >= 0; $i-- ) : ?>
                            <li class="flex justify-between gap-x-6 py-5">
                                <div class="flex min-w-0 gap-x-4">
                                    <div class="min-w-0 flex-auto".>
                                        <p class="text-sm font-semibold leading-6 text-gray-900"><?php echo htmlspecialchars($articles[$i]->title) ?></p>
                                        <a href="<?php echo htmlspecialchars($articles[$i]->url) ?>">
                                            <p class="mt-1 truncate text-sm leading-5 text-gray-500"><?php echo htmlspecialchars($articles[$i]->url) ?></p>
                                        </a>

                                    </div>
                                </div>
                                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                                    <p class="mt-1 text-xs leading-5 text-gray-500">Posted at</p>
                                    <?php
                                    echo "<p class='mt-1 text-xs leading-5 text-gray-500'>" . htmlspecialchars($articles[$i]->createdAtFmt()) . "</p>";
                                    ?>

                                    <p class="mt-1 text-xs leading-5 text-gray-500">Posted by</p>
                                    <?php
                                    echo "<p class='mt-1 text-xs leading-5 text-gray-500'>" . htmlspecialchars($userRepository->getUserById($articles[$i]->author_id)->name) . "</p>";

                                    ?>

                                    <img class="h-8 w-8 rounded-full" src="images/<?= htmlspecialchars($userRepository->getUserById($articles[$i]->author_id)->profile_picture) ?>" alt="">

                                    <?php
                                    $createTime = $articles[$i]->createdAtFmt();
                                    // Calculate the time different between now and posted time.
                                    // Eliminate day postfix.
                                    $createTime = preg_replace('/(\d+)(st|nd|rd|th)/', '$1', $createTime);

                                    // Eliminate of.
                                    $createTime = str_replace(' of ', ' ', $createTime);

                                    // Convert the date to UNIX timestamp, and calculate it.
                                    $period = time() - strtotime($createTime);

                                    // Display the approximate time.
                                    if ($period <= $_UNIXTIME_MIN) {
                                        echo "1 minutes ago";
                                    }
                                    elseif ($period <= $_UNIXTIME_HOUR) {
                                        echo ceil($period / $_UNIXTIME_MIN) . " minutes ago";
                                    }
                                    elseif ($period <= $_UNIXTIME_WEEK) {
                                        echo ceil($period / $_UNIXTIME_HOUR) . " hours ago";
                                    }
                                    elseif ($period <= $_UNIXTIME_MONTH) {
                                        echo ceil($period / $_UNIXTIME_WEEK) . " weeks ago";
                                    }
                                    elseif ($period <= $_UNIXTIME_YEAR) {
                                        echo ceil($period / $_UNIXTIME_MONTH) . " months ago";
                                    }
                                    else {
                                        echo ceil($period / $_UNIXTIME_YEAR) . " years ago";
                                    }
                                    ?>

                                    <?php if (isset($_SESSION['userId']) && $articles[$i]->author_id === $_SESSION['userId']) : ?>
                                        <div class="mt-6 flex items-center justify-end gap-x-6">
                                            <form action="delete_article" class="flex items-center justify-end gap-x-6" method="POST">

                                                <input type="text" name="id" value="<?= $articles[$i]->id ?>" hidden="hidden">
                                                <button type="submit" name="deleteArticle" value="<?php echo $articles[$i]->id ?>" class="rounded-md bg-indigo-500 px-3 py-1 text-sm font-semibold text-white shadow-sm hover:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Delete</button>
                                            </form>
                                            <form action="update_article" class="flex items-center justify-end gap-x-6" method="GET">
                                                <input type="text" name="title" value="<?= htmlspecialchars($articles[$i]->title) ?>" hidden="hidden">
                                                <input type="text" name="url" value="<?= htmlspecialchars($articles[$i]->url) ?>" hidden="hidden">
                                                <button type="submit" name="updateArticle" value="<?php echo $articles[$i]->id ?>" class="rounded-md bg-indigo-500 px-3 py-1 text-sm font-semibold text-white shadow-sm hover:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Update</button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </li>

                            <!-- delimiter line -->
                            <div style="border-bottom: 1px solid rgb(0,0,0,0.1);"></div>
                        <?php endfor; ?>

                </ul>
            </div>
        </h6>
    </div>

</body>