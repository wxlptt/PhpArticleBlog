<?php require_once 'header.php'; ?>

<?php require_once 'nav.php' ?>
<div class="mx-auto max-w-4xl sm:px-6 lg:px-8 mt-10">
    <form class="space-y-8 w-96 mx-auto" action="/setting" method="post" enctype="multipart/form-data">
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700"> Email (Can not be changed) </label>
            <div class="mt-1">
                <input value="<?= htmlspecialchars($_SESSION['userEmail'] ?? '') ?>"
                       id="Email"
                       name="Email"
                       type="Email"
                       readonly="true"
                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
        </div>

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700"> Name </label>
            <div class="mt-1">
                <input value="<?= htmlspecialchars($_SESSION['userName'] ?? '') ?>"
                       id="name"
                       name="name"
                       type="text"
                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
        </div>

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700"> Photo </label>
            <img class="h-8 w-8 rounded-full" src="images/<?= htmlspecialchars($_SESSION['profilePicture'] ?? 'default.png') ?>" alt="">
            <div class="mt-1">
                <input id="file"
                       name="file"
                       type="file"
                       accept="image/png"
                       class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
        </div>

        <div>
            <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Update!
            </button>
        </div>
    </form>

</div>
