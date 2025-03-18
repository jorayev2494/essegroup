@story('client-interface:deploy')
    client-interface:pull-image
    client-interface:stop-container
    client-interface:stop-container
@endstory

@task('client-interface:pull-image', ['on' => ['production'], 'confirm' => false])
    cd /var/www/essegroup
    docker image pull idocker2494/esseelitegroup-client
@endtask

@task('client-interface:stop-container', ['on' => ['production'], 'confirm' => false])
    cd /var/www/essegroup
    ./app-console stop client-front-end
@endtask

@task('client-interface:stop-container', ['on' => ['production'], 'confirm' => false])
    cd /var/www/essegroup
    ./app-console start client-front-end
@endtask
