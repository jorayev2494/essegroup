@story('server:deploy')
    server:update-code
    server:install-dependencies
    server:migrating
@endstory

@task('server:update-code', ['confirm' => false])
    cd /var/www/essegroup
    git branch
    git pull
@endtask

@task('server:install-dependencies', ['confirm' => false])
    cd /var/www/essegroup
    ./app-console composer install --no-dev --no-script
@endtask

@task('server:migrating', ['confirm' => false])
    cd /var/www/essegroup
    ./app-console migrations migrate --no-interaction
@endtask