set :stage, :production

server '192.168.1.62', user: 'root', roles: [:web, :app, :db], domain: '192.168.1.62'

set :branch, 'master'

SSHKit.config.command_map[:composer] = "#{shared_path.join("composer.phar")}"

set :composer_install_flags, "--no-dev --prefer-dist --no-interaction -vvv --optimize-autoloader"
