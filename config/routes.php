<?php

return [

    '^$' =>
    [
        'controller' => 'main',
        'action'     => 'index'
    ],

    '^search$' =>
    [
        'controller' => 'main',
        'action'     => 'search'
    ],

    '^signup$' =>
        [
            'controller' => 'user',
            'action'     => 'signup'
        ],

    '^user/[0-9]+/(?P<action>(?!signup)[a-z]+)$' =>
    [
        'controller' => 'user',
        'action'     => ''
    ],

];