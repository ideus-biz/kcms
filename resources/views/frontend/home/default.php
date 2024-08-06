<h1><?=env('APP_NAME')?></h1>
<h3>Welcome to the website under KCMS v5.5 for Laravel</h3>
<p>
	You've successfully installed your new project ;)<br>
    What's the next?
    Please follow the next tips to start and create your great project driven by KCMS.
</p>
<ol>
    <li>
        <strong>Name your project!</strong><br>
        Open <span class="refer">/.env</span> file and set a new value for <span class="refer">APP_NAME</span> directive. <br>
        Update the page to see the changes.
    </li>
    <li>
        <strong>Database configuration</strong><br>
        The next important thing is a database. <br>
        KCMS has a pool of internal entities (database models) which have to be impoerted into DB to be able to start administrative application as well as your future app.
        <br>
        At first you have to create a database and a credentials to access into it. <br>
        Then let's set the database configuration. <br>
        We assume you are going to use MySQL and standard Laravel configuration under <span class="refer">mysql</span> node in the <span class="refer">/config/database.php</span><br>
        Database configuration is per hosting basis, so it's a good idea to set the configuration in the <span class="refer">/.env</span> file. <br>
        It is recommended to have two different credentials: one for general purposes access and another with extended administration permissions. <br>
        Otherwise, if you decide to use single database profile, you must grant it appropriate permissions to allow creating and alter the tables in the database.
        <br>
        Now open <span class="refer">/.env</span> file and change at least the next directives (for single or ordinal database user profile):
        <ul>
            <li>
                <span class="refer">DB_DATABASE</span> - database name.
            </li>
            <li>
                <span class="refer">DB_USERNAME</span> - database user name.
            </li>
            <li>
                <span class="refer">DB_PASSWORD</span> - database user password.
            </li>
        </ul>
        <br>
        In case of usage the second profile create the next directives:
        <ul>
            <li>
                <span class="refer">DB_ADMIN_USERNAME</span> - database username with write permissions.
            </li>
            <li>
                <span class="refer">DB_ADMIN_PASSWORD</span> - it's password.
            </li>
        </ul>
        <br>
        <br>
        If everything has done right then execute command line in the project: <br>
        <span class="code shell">
            php artisan ecr:sync install
        </span>
        This imports structure of all built-in entities into your database. <br>
        Then import pre-defined data for imported entities and some special SQL command...
    </li>
</ol>
<p>
</p>
