<?php

require_once "vendor/autoload.php";

$user = new Hillel\HomeWork\Models\User();



print $user->get();

$user2 = new \My\ValueObjects\User();

print $user2->get();


