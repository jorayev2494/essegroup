@story('admin-interface:deploy')
    admin-interface:pull-image
    admin-interface:stop-container
    admin-interface:stop-container
@endstory

@task('admin-interface:pull-image', ['on' => ['production'], 'confirm' => false])
    cd /var/www/essegroup
    docker image pull idocker2494/esseelitegroup-admin
@endtask

@task('admin-interface:stop-container', ['on' => ['production'], 'confirm' => false])
    cd /var/www/essegroup
    ./app-console stop admin-front-end
@endtask

@task('admin-interface:stop-container', ['on' => ['production'], 'confirm' => false])
    cd /var/www/essegroup
    ./app-console start admin-front-end
@endtask
