#!/usr/bin/env bash

# Wait until mysql is started and all dumps are imported
cat << EOF > /tmp/wait_for_mysql.php
<?php
\$connected = false;
while(!\$connected) {
    try{
        \$dbh = new pdo(
            'mysql:host='. getenv('MYSQL_HOST') .':3306;dbname=' . getenv('MYSQL_DATABASE'), getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'),
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
        );
        \$dbh->query('SELECT * from wallet;');
        \$connected = true;
    }
    catch(PDOException \$ex){
        error_log("Waiting for MySQL to be up and running... (".\$ex->getMessage().")");
        sleep(5);
    }
}
EOF
php /tmp/wait_for_mysql.php
rm /tmp/wait_for_mysql.php

sleep 5

echo "Starting Table daemon.."
/usr/bin/php /project/application/bin/cli.php NewQueue Table --name=touchTable >> /project/application/system/log/queue-table &

echo "Starting Wallet daemon.."
/usr/bin/php /project/application/bin/cli.php NewQueue Wallet --name=newWallet >> /project/application/system/log/queue-wallet &
