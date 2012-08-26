Usage:
yml example:
default:
    context:
    extensions:
      Ptbfw\Initializer\Extension:
          local_service:
                type: 'mysql'
                host: 'localhost'
                user: 'behat'
                password: '1'
                database: 'behat'
                port: 3306
                directory: 'local'
                init_command: 'SET NAMES "UTF8"'
          local_service_api:
                type: 'mysql'
                host: 'localhost'
                user: 'behat2'
                password: '1'
                database: 'behatTwo'


directory is relative from %features/bootstrap/database/