@story('admin:build-image')
    admin:build-image
@endstory

@story('admin:build-and-push-image')
    admin:build-image
    admin:push-image
@endstory

@before
    echo 'admin:build-image before: ...!' . PHP_EOL;
@endbefore

@task('admin:build-image', ['on' => ['localhost'], 'confirm' => false])
    cd $PWD/../admin/docker/node
    docker build -t  idocker2494/esseelitegroup-admin ../../ -f Dockerfile --target production
@endtask

@task('admin:push-image', ['on' => ['localhost'], 'confirm' => false])
    cd $PWD/../admin
    docker push idocker2494/esseelitegroup-admin
@endtask

@after
    echo 'admin:update-code after: ...!' . PHP_EOL;
@endafter
