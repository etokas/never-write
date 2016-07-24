# config valid only for current version of Capistrano
lock '3.5.0'

set :application, 'never-write'
set :repo_url, 'git@github.com:etokas/never-write.git'

set :deploy_to, '/var/www/never-write'

# Default value for :scm is :git
set :scm, :git

set :log_level, :info

set :linked_files, %w{app/config/parameters.yml}

set :linked_dirs, %w{var/logs var/sessions}

set :keep_releases, 5

set :file_permissions_paths, %w{
    var/logs
    var/cache
}

set  :use_sudo,      false

set :file_permissions_users, ["www-data", "root"]
set :permission_method,     :acl
set :use_set_permissions,   true

set :composer_install_flags, '--no-interaction --optimize-autoloader'