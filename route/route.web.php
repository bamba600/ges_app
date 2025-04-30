<?php

$route=[
         'controleur'=>function(){
              
               $root=__DIR__ . '/../controllers/controller.php';
               return $root;
         },
         'contrlogin'=>function(){
              
               $root=__DIR__ . '/../controllers/contrlogin.php';
               return $root;
         },
         'controlref'=>function(){
              
               $root=__DIR__ . '/../controllers/controlref.php';
               return $root;
         },
         'controlref2'=>function(){
              
               $root=__DIR__ . '/../controllers/controlref2.php';
               return $root;
         },
         'controlproms1'=>function(){
              
               $root=__DIR__ . '/../controllers/controlproms1.php';
               return $root;
         },
         'controlproms2'=>function(){
              
               $root=__DIR__ . '/../controllers/controlproms2.php';
               return $root;
         },
         "controlmdpoublie"=>function(){
              
               $root=__DIR__ .'/../controllers/control_mdp_oublie.php';
               return $root;
         },
         'controldeconnexion' => function() {
             return __DIR__ . '/../controllers/controldeconnexion.php';
         },
         'controlajoutpromo' => function () {
        return __DIR__ . '/../controllers/controlajoutpromo.php';
    },
    'controlajoutref' => function () {
   return __DIR__ . '/../controllers/controlajoutref.php';
},
'controlajoutref2' => function () {
return __DIR__ . '/../controllers/controlajoutref2.php';
},
'control2proms' => function () {
return __DIR__ . '/../controllers/controliste.php';
},
'apprenant' => function () {
return __DIR__ . '/../controllers/control_apprenant.php';
},
'ajt_appr' => function () {
return __DIR__ . '/../controllers/control_ajt_appr.php';
},
'connect_detail' => function () {
return __DIR__ . '/../controllers/control_connect.php';
},
'changer_pass' => function () {
return __DIR__ . '/../controllers/control_changer.php';
}
   
   
         
    ];