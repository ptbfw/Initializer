New Initializer: Executer
Usage:

<pre>
default:
    extensions:
      Ptbfw\Initializer\Extension:
          test:
            type: 'Executer'
            commands:
              - "ls"
              - "whoami"
</pre>

<b>ls</b> and <b>whoami</b> are command witch are executed before every scenario.
You can use this for apache restart, moving files, clearing cache etc...

Development version 0.3

<hr>

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
                <b>directory</b>: 'local_service_api'
</pre>

<b>directory</b> is relative from %features/bootstrap/database/<br>
if <b>directory</b> start with slash / then path is treated as absolute

Development version 0.2