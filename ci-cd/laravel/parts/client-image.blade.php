@story('client:build-image')
    client:build-image
@endstory

@story('client:build-and-push-image')
    client:build-image
    client:push-image
@endstory

@before
    echo 'client:build-image before: ...!' . PHP_EOL;
@endbefore

@task('client:build-image', ['on' => ['localhost'], 'confirm' => false])
    cd $PWD/../client/docker/node
    docker build -t  idocker2494/esseelitegroup-client ../../ -f Dockerfile --target production
@endtask

@task('client:push-image', ['on' => ['localhost'], 'confirm' => false])
    cd $PWD/../client
    docker push idocker2494/esseelitegroup-client
@endtask

@after
    echo 'client:update-code after: ...!' . PHP_EOL;
@endafter
