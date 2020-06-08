<?php
$dynamic                = new Dynamic();
$dynamic->a=2;
$dynamic->a->a=4;
$dynamic->anotherMethod = function () {
    echo "Hey there";
};
$dynamic->randomInt     = function ($min, $max) {
    return mt_rand($min, $max); // random_int($min, $max); // <-- PHP7+
};



var_dump(
    Dynamic::fromArray($ej),
    $dynamic,
    $dynamic->randomInt(1, 11)
);

return;