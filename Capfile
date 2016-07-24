require 'capistrano/setup'

# Includes default deployment tasks
require 'capistrano/deploy'
#require 'capistrano-simple-formatter'
require 'capistrano/symfony'
require 'capistrano/copy_files'
require 'capistrano/composer'
require 'capistrano/pending'

# Loads custom tasks from `lib/capistrano/tasks' if you have any defined.
Dir.glob('app/config/capistrano/tasks/*.rake').each { |r| import r }
