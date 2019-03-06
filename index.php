<?php
try
{
    $pdo = new PDO('mysql:host=localhost;dbname=task3', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET NAMES "utf8"');
}
catch (PDOException $e)
{
    echo $output = 'Unable to connect to the database server.';
        exit();
}
// Создание таблиц
$pdoQuery = "CREATE TABLE IF NOT EXISTS `Usernames` ( `id` INT NOT NULL ,  `name` TINYTEXT,
`surname` TINYTEXT, PRIMARY KEY (`id`)) ENGINE = InnoDB";

$pdoResult = $pdo->query($pdoQuery);

$pdoQuery = "CREATE TABLE IF NOT EXISTS `Dob` ( `dob` DATE NOT NULL , `usernames_id` INT NOT NULL ,
             FOREIGN KEY (`usernames_id`) REFERENCES `task3`.`Usernames`(id)) ENGINE = InnoDB";


   $pdoResult = $pdo->query($pdoQuery);

$pdoQuery = "CREATE TABLE IF NOT EXISTS `Tel` ( `tel` TINYTEXT NOT NULL , `usernames_id` INT NOT NULL ,
             FOREIGN KEY (`usernames_id`) REFERENCES `task3`.`Usernames`(id)) ENGINE = InnoDB";

$pdoResult = $pdo->query($pdoQuery);

// Если таблицы пустые, заполнить данными
$members=$pdo->query("SELECT COUNT(*) as count FROM `task3`.`Usernames`")->fetchColumn();
if ($members =='0'){

$arrUsernames =(array(
    array("id"=>1, "name"=>"Иван", "surname"=>"Иванов"),
    array("id"=>2, "name"=>"Петр", "surname"=>"Петров"),
    array("id"=>3, "name"=>"Сидор", "surname"=>"Сидоров"),
    array("id"=>4, "name"=>"Антон", "surname"=>"Антонов"),
    array("id"=>5, "name"=>"Николай", "surname"=>"Николаев"),
    array("id"=>6, "name"=>"Евгений", "surname"=>"Евгеньев"),
    array("id"=>7, "name"=>"Стол", "surname"=>"Столов"),
    array("id"=>8, "name"=>"Пол", "surname"=>"Полов"),
    array("id"=>9, "name"=>"Поп", "surname"=>"Попов"),
    array("id"=>10, "name"=>"Шон", "surname"=>"Шонов"),

));

for ($i=0;$i<count($arrUsernames);$i++) {
  $pdoQuery = "INSERT INTO `task3`.`Usernames`(`id`, `name`, `surname`) VALUES (:id,:name,:surname)";

  $pdoResult = $pdo->prepare($pdoQuery);

  $pdoExec = $pdoResult->execute($arrUsernames[$i]);

}

$arrDob = (
    array(
        array("dob"=>'2000-01-02', "usernames_id"=>1),
        array("dob"=>'2001-01-02', "usernames_id"=>2),
        array("dob"=>'2002-10-10', "usernames_id"=>3),
        array("dob"=>'2003-10-10', "usernames_id"=>4),
        array("dob"=>'2004-10-10', "usernames_id"=>5),
        array("dob"=>'2005-10-10', "usernames_id"=>6),
        array("dob"=>'2006-10-10', "usernames_id"=>7),
        array("dob"=>'2007-10-10', "usernames_id"=>8),
        array("dob"=>'2007-10-10', "usernames_id"=>9),
    )
);

for ($i=0;$i<count($arrDob);$i++) {
    $pdoQuery = "INSERT INTO `task3`.`Dob`(`dob`, `usernames_id`) VALUES (:dob,:usernames_id)";
    $pdoResult = $pdo->prepare($pdoQuery);
    $pdoExec = $pdoResult->execute($arrDob[$i]);
}

$arrTel = (
    array(
        array("tel"=>"11111-1", "usernames_id"=>1),
        array("tel"=>"11111-2", "usernames_id"=>2),
        array("tel"=>"11111-3", "usernames_id"=>3),
        array("tel"=>"11111-4", "usernames_id"=>4),
        array("tel"=>"11111-5", "usernames_id"=>5),
        array("tel"=>"11111-6", "usernames_id"=>6),
        array("tel"=>"11111-7", "usernames_id"=>7),
        array("tel"=>"11111-8", "usernames_id"=>8),
    )
);

for ($i=0;$i<count($arrTel);$i++) {
    $pdoQuery = "INSERT INTO `task3`.`Tel`(`tel`, `usernames_id`) VALUES (:tel,:usernames_id)";

    $pdoResult = $pdo->prepare($pdoQuery);

    $pdoExec = $pdoResult->execute($arrTel[$i]);
}
}

//Объединение 3-х таблиц
$pdoQuery = "SELECT `Usernames`.`name`, `Usernames`.`surname`, `Dob`.`dob`, `Tel`.`tel`
FROM `Usernames` LEFT JOIN `Dob` ON `Usernames`.`id`=`Dob`.`usernames_id`
LEFT JOIN `Tel` ON `Usernames`.`id`=`Tel`.`usernames_id`";

$pdoResult = $pdo->query($pdoQuery);

while ($rows = $pdoResult->fetch()) {
    print "$rows[name], $rows[surname], $rows[dob], $rows[tel] <br>";
}

echo '<pre>';
print_r($rows);
echo '</pre>';

$pdo = null;

