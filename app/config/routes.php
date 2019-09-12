<?php
return [
  // MAIN
  [
    "controller"=>"MainController",
    "data"=>[
      [
        "method"=>"get",
        "path"=>"/",
        "action"=>"index",
        "checkAuth"=>false,
      ],
      [
        "method"=>"get",
        "path"=>"/doc",
        "action"=>"doc",
        "checkAuth"=>false,
      ],
      [
        "method"=>"get",
        "path"=>"/swagger.json",
        "action"=>"swagger",
        "checkAuth"=>false,
      ],
      [
        "method"=>"get",
        "path"=>"/sha512/{t}",
        "action"=>"sha512",
        "checkAuth"=>false,
      ],
    ],
  ],
  // Belajar
  [
    "controller"=>"BelajarController",
    "data"=>[
      [
        "method"=>"get",
        "path"=>"/belajar",
        "action"=>"getData",
        "checkAuth"=>false,
      ],
      [
        "method"=>"post",
        "path"=>"/belajar/add",
        "action"=>"addData",
        "checkAuth"=>false,
      ],
      [
        "method"=>"put",
        "path"=>"/belajar/edit",
        "action"=>"editData",
        "checkAuth"=>false,
      ],
    ],
  ],
];