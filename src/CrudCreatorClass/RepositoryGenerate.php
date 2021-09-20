<?php

namespace Mahabub\CrudGenerator\CrudCreatorClass;

class RepositoryGenerate
{
    protected static function getStubs($type)
    {
        return file_get_contents(resource_path("mahabub/stubs/$type.stub"));
    }

    /**
     ****===== ImplementNow =====****
     *
     * @param mixed $name
     * @return void
     */

    public static function ImplementNow($name)
    {
        $name= str_replace('/', '', strstr($name, "/")) !=""? str_replace('/', '', strstr($name, "/")) :$name;

        if (!file_exists($path=app_path('Repositories'))) {
            mkdir($path, 0777, true);
        }
        self::MakeRepositoryClass($name);
    }
    
    /**
     *****===== MakeRepositoryClass =====****
     *
     * @param mixed $name
     **This will create Reposiory class in Repositories
     * @return void
     */
    protected static function MakeRepositoryClass($name)
    {
        try {
            $version = config('crud_generator.laravel_version');
            self::CreateRepository($name, $version);
        } catch (\Throwable $th) {
            return  "already exists";
        }
    }

    /**
     *****===== MakeProvider =====****
     **This will create MakeProvider class
     * @return void
     */

    protected static function MakeProvider()
    {
        $template =  self::getStubs('RepositoryBackendServiceProvider');

        if (!file_exists($path=app_path('Repositories/RepositoryBackendServiceProvider.php'))) {
            file_put_contents(app_path('Repositories/RepositoryBackendServiceProvider.php'), $template);
        }
    }

    /**
    *****===== CreateRepository =====****
    * @param mixed $name
    *
    **This will create Reposiory class in Repositories
    * @return void
    */
    protected static function CreateRepository($name, $version)
    {
        $template = str_replace(
            [
              '{{modelName}}',
              '{{modelNameSingularLowerCase}}',
            ],
            [
                $name,
                strtolower($name)
            ],
            $version >= 8 ? self::GetStubs('Repository') :  self::GetStubs('Repositoryov')
        );
        
        file_put_contents(app_path("Repositories/{$name}Repository.php"), $template);
    }
}
