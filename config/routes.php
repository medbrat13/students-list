<?php

return [

    '^$' =>
    [
        'controller' => 'main',
        'action'     => 'index'
    ],
//
//    '^search$' =>
//    [
//      'controller' => 'main',
//      'action'     => 'search'
//    ],

//    '^register$' =>
//    [
//        'controller' => 'register',
//        'action'     => 'index'
//    ],


    '^(?P<controller>[a-z]+)/?(?P<action>[a-z]+)?$' =>
    [
        'controller' => '',
        'action'     => ''
    ]
];