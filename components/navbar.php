<?php
$userName = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : 'guest@example.com';
?>

<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                    aria-controls="logo-sidebar" type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 
                            rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none 
                            focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">
                        Open sidebar
                    </span>
                    <i class="bi bi-list"></i>
                </button>
                <a href="index.php" class="flex ms-2 md:me-24">
                    <h2 class="text-3xl font-bold text-center dark:text-white">
                        Kos <span class="bg-amber-500 px-3 rounded-md text-white dark:text-black">hub</span>
                    </h2>
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    <div>
                        <button type="button"
                            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                            aria-expanded="false"
                            data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">
                                Open user menu
                            </span>
                            <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                                alt="user photo">
                        </button>
                    </div>
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                        id="dropdown-user">
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm text-gray-900 dark:text-white" role="none">
                                <?php echo htmlspecialchars($userName); ?>
                            </p>
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                <?php echo htmlspecialchars($userEmail); ?>
                            </p>
                        </div>
                        <ul class="py-1" role="none">
                            <li>
                                <a href="../config/logout.php"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem">
                                    Sign out
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>