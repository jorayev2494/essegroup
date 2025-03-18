@servers([
    'localhost' => [
        '127.0.0.1',
    ],
    'production' => [
        'root@45.94.158.165',
    ],
])

{{-- Server --}}
@import('ci-cd/laravel/parts/server.blade.php')

{{-- Admin --}}
@import('ci-cd/laravel/parts/admin-image.blade.php')
@import('ci-cd/laravel/parts/admin-interface.blade.php')

{{--
@task('admin:build-and-push-image-deploy')
    ./app-console ci/cd run admin:build-and-push-image
    ./app-console ci/cd run admin-interface:deploy
@endtask
--}}

{{-- Client --}}
@import('ci-cd/laravel/parts/client-image.blade.php')
@import('ci-cd/laravel/parts/client-interface.blade.php')

{{--
@task('client:build-and-push-image-deploy')
    ./app-console ci/cd run client:build-and-push-image
    ./app-console ci/cd run client-interface:deploy
@endtask
--}}
