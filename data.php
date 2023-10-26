<?php

// think of this like an array of objects in javascript
// or a long container, with three little containers inside of the long container and inside of the little container, there is a value
// a dresser ($data), the top has a box labeled name and inside of it a piece of paper that says chazz
$data = [
    ['name' => 'chazz'],
    ['name' => 'peter'],
    ['name' => 'gwen']
];

// basically, we send out a piece of paper that has all of the $data information, but we do it on a special piece of paper that is human and machine readable
echo json_encode($data);

?>