set :stage, :production

server '192.168.1.62', user: 'root', roles: [:web, :app, :db], domain: '192.168.1.62'

set :branch, 'master'
