<?php

namespace Mahabub\CrudGenerator\CrudCreatorClass;
class RepositoryGenerate 
{
    
    protected static function getStubs($type)
    {
        return file_get_contents(resource_path("mahabub/stubs/$type.stub"));
    }

    public static function ImplementNow($name)
    {
        $name= str_replace('/','',strstr($name,"/")) !=""? str_replace('/','',strstr($name,"/")) :$name;
        if (!file_exists($path=app_path('Repositories')))
          mkdir($path, 0777, true);
          self::MakeRepositoryClass($name);
    }

    protected static function MakeRepositoryClass($name)
    {
        $name= str_replace('/','',strstr($name,"/")) !=""? str_replace('/','',strstr($name,"/")) :$name;
        $template = str_replace(
            ['{{modelName}}'],
            [$name],
            self::GetStubs('Repository')
        );

        file_put_contents(app_path("Repositories/{$name}Repository.php"), $template);

    }

    protected static function MakeProvider()
    {
        $template =  self::getStubs('RepositoryBackendServiceProvider');

        if (!file_exists($path=app_path('Repositories/RepositoryBackendServiceProvider.php')))
            file_put_contents(app_path('Repositories/RepositoryBackendServiceProvider.php'), $template);
    }
}
