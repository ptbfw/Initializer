Usage:
yml example:
<pre>
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
                <b>directory</b>: 'local'
                init_command: 'SET NAMES "UTF8"'
          local_service_api:
                type: 'mysql'
                host: 'localhost'
                user: 'behat2'
                password: '1'
                database: 'behatTwo'
</pre>

<b>directory</b> is relative from %features/bootstrap/database/