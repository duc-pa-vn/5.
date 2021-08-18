<?php
require __DIR__ . '/vendor/autoload.php';

use SebastianBergmann\Timer\Timer;

echo 'Here the index file';

try {
    $dbh = new PDO('mysql:host=db;port=3306;dbname=sampleDB', 'root', 'root');
    $dbh->exec('CREATE TABLE IF NOT EXISTS sample_table (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        sample_column VARCHAR(30) NOT NULL
    );');

    echo '</br>';
    echo 'Connection success';
} catch (PDOException $e) {
    echo 'Error!:';
    echo '</br>';
    echo $e;
    die();
}

$timer = new Timer;

$timer->start();
$var = 0;
foreach (\range(0, 100000) as $i) {
    $var += 1;
}

$duration = $timer->stop();
echo '</br></br>';
echo 'Time to execute 100.000 loop of increment assign operator:';
echo '</br>';
echo $duration->asString();

echo '</br>';

echo $duration->asMilliseconds() . 'miliseconds';
