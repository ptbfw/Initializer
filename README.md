Compatible with behat v3

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/89d83982-c16c-47df-8f3c-1b40d6621a64/big.png)](https://insight.sensiolabs.com/projects/89d83982-c16c-47df-8f3c-1b40d6621a64)

Usage:

<pre>
default:
    extensions:
      Ptbfw\Initializer\Extension:
            resetters:
                {servicename}:
                    type: {executer type}
                    {executer Options}
                {SecondServiceName}:
                    type: {executer type}
                    {executer Options}
</pre>

Example:

<pre>
default:
    extensions:
      Ptbfw\Initializer\Extension:
            resetters:
                test:
                  type: 'Executer'
                  commands:
                    - "ls"
                    - "whoami"
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
                <b>directories</b>:
                    - 'local_service_api'
                    - 'local_service'
</pre>

<h2>Types</h2>

<h3>Mysql</h3>
<b>directory(ies)</b> is relative from %features%/bootstrap/database/<br>
If <b>directory</b> start with slash / then path is treated as absolute.
</pre>
If both <b>directory</b> and <b>directories</b> are provided, <b>directory</b> is merged in <b>directories</b>

<h3>Executer</h3>
<b>ls</b> and <b>whoami</b> are command witch are executed before every scenario.
You can use this for apache restart, moving files, clearing cache etc...
