<?php
spl_autoload_register(function ($class_name) {
    
    $paths = [
        'Srv'=>SERVER_DIR.'/src',
        'Request'=>SERVER_DIR.'/request',
        'Cls'=>SERVER_DIR.'/class',
        'Schema'=>SERVER_DIR.'/dbschema',
    ];
    
    $track = explode('\\', $class_name);
    $isReq = false;
    if($track[0] == 'Request')
        $isReq = true;
    $track[0] = str_replace(array_keys($paths), array_values($paths), $track[0], $match);
    if(!$match){
        $bt = debug_backtrace()[1];
        exit("<br/>Can't find <b>$class_name</b><br/>In file:<b>".$bt['file']."</b> on line ".$bt['line']."<br/>");
    }
    $file = implode('/', $track).($isReq?'.req':'').'.php';
    if(file_exists($file))
        require_once($file);
    else{
        echo "AutoLoader: Can't find $class_name";
        print_r(debug_backtrace());
        exit();
    }
});

if(file_exists(BASE_DIR.'/vendor/autoload.php'))
    require_once(BASE_DIR.'/vendor/autoload.php');