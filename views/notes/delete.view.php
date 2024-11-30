<?php require base_path('views/partials/head.php') ?>
<?php require base_path('views/partials/nav.php') ?>
<?php require base_path('views/partials/banner.php') ?>

<main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

        <form method="POST" action="/note">
            <!-- Below tells the router to treat this as a DELETE request, not a POST request -->
            <input type="hidden" name="_method" value="DELETE">
            <!-- use another hidden input, this time to pass along the id of the record bing edited -->
            <input type="hidden" name="id" value="<?= $note['id'] ?>">
            <div class="border-b border-gray-900/10 pb-12">
                <div class="col-span-full">
                    <label for="body" class="block text-md font-medium leading-6 text-gray-900">Note Body:</label>
                    <div class="mt-2">
                            <?= $note['body'] ?>

                        <?php if (isset($errors['body'])) : ?>
                            <p class="text-red-600 text-xs mt-2"><?= $errors['body'] ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a
                    href="/notes"
                    class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Cancel</a>
                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">Delete</button>
            </div>
        </form>

    </div>
</main>

<?php
require base_path('views/partials/footer.php') ?>