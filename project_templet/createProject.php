<?php
/*依据项目模板生成一个新的项目*/

if(!empty($argv[1])){
    $projectName=trim($argv[1]);
}else{
    die('项目名不能为空');
}

$nameSpace=ucfirst($projectName);
$rootDir=dirname(__DIR__);

/*总目录*/
$projectDir=$rootDir.DIRECTORY_SEPARATOR.$projectName;
if(!file_exists($projectDir)){
    mkdir($projectDir);
}
/*下属小目录*/
$thisDirFiles=scandir(__DIR__);
foreach ($thisDirFiles as $thisDirFile) {
    if($thisDirFile=='.' || $thisDirFile=='..'){
        continue;
    }
    if(is_dir($thisDirFile)){
       if(!file_exists($projectDir.'/'.$thisDirFile)){
           mkdir($projectDir.'/'.$thisDirFile);
       }
    }
}

/*启动文件*/
$bootstrapFile=file_get_contents(__DIR__.'/Bootstrap.php');
$bootstrapFile=str_replace('Tmp',$nameSpace,$bootstrapFile);
file_put_contents($projectDir.'/Bootstrap.php',$bootstrapFile);
copy(__DIR__.'/.gitignore',$projectDir.'/.gitignore');
/*配置文件*/
copy(__DIR__.'/config/config.php',$projectDir.'/config/config.php');
copy(__DIR__.'/config/.gitignore',$projectDir.'/config/.gitignore');
/*public文件*/
copy(__DIR__.'/public/.htaccess',$projectDir.'/public/.htaccess');
copy(__DIR__.'/public/favicon.ico',$projectDir.'/public/favicon.ico');
$indexContent=file_get_contents(__DIR__.'/public/index.php');
$indexContent=str_replace('Tmp',$nameSpace,$indexContent);
file_put_contents($projectDir.'/public/index.php',$indexContent);
/*视图文件*/
copy(__DIR__.'/views/index.phtml',$projectDir.'/views/index.phtml');
if(!file_exists($projectDir.'/views/msg')){
    mkdir($projectDir.'/views/msg');
}
copy(__DIR__.'/views/msg/msg.phtml',$projectDir.'/views/msg/msg.phtml');
/*控制器*/
$controllerContent=file_get_contents(__DIR__.'/Controllers/TmpController.php');
$controllerContent=str_replace('Tmp',$nameSpace,$controllerContent);
file_put_contents($projectDir.'/Controllers/'.$nameSpace.'Controller.php',$controllerContent);


$controllerContent=file_get_contents(__DIR__.'/Controllers/IndexController.php');
$controllerContent=str_replace('Tmp',$nameSpace,$controllerContent);
file_put_contents($projectDir.'/Controllers/IndexController.php',$controllerContent);

$controllerContent=file_get_contents(__DIR__.'/Controllers/LoginController.php');
$controllerContent=str_replace('Tmp',$nameSpace,$controllerContent);
file_put_contents($projectDir.'/Controllers/LoginController.php',$controllerContent);





