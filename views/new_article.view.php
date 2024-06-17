<?php require_once 'header.php'; ?>

<body>

    <?php require_once 'nav.php'; ?>

    <div class="grid grid-cols-12 mt-20">

        <form class="space-y-6 col-start-4 col-span-6" action="/articles/store" method="POST">
            <!-- TODO: add inputs for article creation -->


            <div>
                <label for="title" class="block text-sm font-medium text-gray-700"> Article Title </label>
                <div class="mt-1">
                    <input placeholder="Title"
                           id="title"
                           name="title"
                           type="text"
                           class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            </div>

            <div>
                <label for="url" class="block text-sm font-medium text-gray-700"> Article URL </label>
                <div class="mt-1">
                    <input type="url" id="url" name="url" placeholder="URL you like here!" rows="3" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

            </div>
            <div for="title" class="block text-sm font-medium text-red-600"> <?= htmlspecialchars($data[0] ?? '') ?> </div>
            <div>
                <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Post!
                </button>
            </div>

        </form>

    </div>

</body>