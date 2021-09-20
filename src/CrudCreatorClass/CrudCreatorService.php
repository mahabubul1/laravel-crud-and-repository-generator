<?php
namespace Mahabub\CrudGenerator\CrudCreatorClass;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CrudCreatorService
{
    protected static function GetStubs($type)
    {
        return file_get_contents(resource_path("mahabub/stubs/$type.stub"));
    }


    /**
     * Make Controller
     *
     * @param string $name  example Blog
     * @param string $optional example --rep
     *
     */

    public static function MakeController($name, $optional)
    {
        try {
            $version = config('crud_generator.laravel_version');

            if (strpos($name, '/') !== false) {
                $name=explode('/', $name);
                $path= app_path('Http/Controllers/'.$name[0]);
                if (!File::exists($path)) {
                    File::makeDirectory($path);
                }
                if ($version >= 8) {
                    self::CreateControllerFolder($name, $fileName="ControllerFolder", $version, $optional);
                } else {
                    self::CreateControllerFolder($name, $fileName="ControllerFolder", $version, $optional);
                }
            } else {
                if ($version >= 8) {
                    self::CreateController($name, $fileName="Controller", $version, $optional);
                } else {
                    self::CreateController($name, $fileName="Controller", $version, $optional);
                }
            }
        } catch (\Throwable $th) {
            return "already exists";
        }
    }

   
    /**
     *****============ Make Model ============****
     * @param string $name
     *
     */

    public static function MakeModel($name)
    {
        try {
            $name= str_replace('/', '', strstr($name, "/")) !=""? str_replace('/', '', strstr($name, "/")) :$name;
            $version = config('crud_generator.laravel_version');
            if ($version >= 8) {
                self::CreateModel($name, $file="Model", $version);
            } else {
                self::CreateModel($name, $file="Modelov", $version);
            }
        } catch (\Throwable $th) {
            return "already exists";
        }
    }

    /**
     * ***============ Make Migration ============***
     * @param string $name
     *
     */

    public static function MakeMigration($name)
    {
        try {
            $name= str_replace('/', '', strstr($name, "/")) !=""? str_replace('/', '', strstr($name, "/")) :$name;
            Artisan::call('make:migration create_'. strtolower(Str::plural($name)).'_table --create='. strtolower(Str::plural($name)));
        } catch (\Throwable $th) {
            return "already exists";
        }
    }

    /**
     ****============ Make Route ===========***
     * @param $name
     * This will create route in web.php file
     */
    public static function MakeRoute($name)
    {
        try {
            $version = config('crud_generator.laravel_version');

            $name= str_replace('/', '', strstr($name, "/")) !=""? str_replace('/', '', strstr($name, "/")) :$name;
            $path_to_file  = base_path('routes/web.php');
    
            if ($version >= 8) {
                $append_route = 'Route::resource(\'' . Str::plural(strtolower($name)) . "', {$name}Controller::class); \n";
                File::append($path_to_file, $append_route);
            }
        } catch (\Throwable $th) {
            return "already exists";
        }
    }

    /**
     ****============ Make View ==========***
     * @param $name
     * This will create view file  in views folder
     */

    public static function MakeView($name)
    {
        try {
            $name= str_replace('/', '', strstr($name, "/")) !=""? str_replace('/', '', strstr($name, "/")) :$name;
            $name=strtolower($name);
            $path= resource_path('views/'.strtolower($name));
            if (!File::exists($path)) {
                File::makeDirectory($path);
            }
            touch(resource_path("views/{$name}/index.blade.php"));
            touch(resource_path("views/{$name}/create.blade.php"));
            touch(resource_path("views/{$name}/show.blade.php"));
            touch(resource_path("views/{$name}/edit.blade.php"));
            touch(resource_path("views/{$name}/update.blade.php"));
        } catch (\Throwable $th) {
            return "already exists";
        }
    }

    /**
    ****============ Make Request ==========***
    * @param $name
    * This will create file for custom validation rules
    */
    
    public static function MakeRequest($name)
    {
        try {
            $name= str_replace('/', '', strstr($name, "/")) !=""? str_replace('/', '', strstr($name, "/")) :$name;

            $template = str_replace(
                ['{{modelName}}'],
                [$name],
                CrudCreatorService::GetStubs('Request')
            );
    
            if (!file_exists($path=app_path('/Http/Requests/'))) {
                mkdir($path, 0777, true);
            }
    
            file_put_contents(app_path("/Http/Requests/{$name}Request.php"), $template);
        } catch (\Throwable $th) {
            return "already exists";
        }
    }

    /**
     ***===== Create Controller =====***
     *
     * @param mixed $name
     * @param mixed $fileName
     * @param mixed $version
     * @param mixed $optional
     *
     * @return void
     */
    protected static function CreateController($name, $fileName, $version, $optional)
    {
        $file= "";
        if ($version >= 8) {
            $file= ($optional !=null)? CrudCreatorService::GetStubs($fileName.'res') : CrudCreatorService::GetStubs($fileName);
        } else {
            $file= ($optional !=null)? CrudCreatorService::GetStubs($fileName.'resov') : CrudCreatorService::GetStubs($fileName.'ov');
        }

        $template = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}',
            ],
            [
                $name,
                strtolower(Str::plural($name)),
                strtolower($name)
            ],
            $file
        );

        file_put_contents(app_path("/Http/Controllers/{$name}Controller.php"), $template);
    }


    /**
    ***===== CreateControllerFolder =====***
    *
    * @param mixed $name
    * @param mixed $fileName
    * @param mixed $version
    * @param mixed $optional
    *
    *This will create controller in specific folder
    * @return void
    */

    protected static function CreateControllerFolder($name, $fileName, $version, $optional)
    {
        $file= "";
        if ($version >= 8) {
            $file= ($optional !=null)? CrudCreatorService::GetStubs("$fileName".'res') : CrudCreatorService::GetStubs($fileName);
        } else {
            $file= ($optional !=null)? CrudCreatorService::GetStubs($fileName.'resov') : CrudCreatorService::GetStubs($fileName.'ov');
        }



        $template = str_replace(
            [
                '{{folderName}}',
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}',
            ],
            [
                $name[0],
                $name[1],
                strtolower(Str::plural($name[1])),
                strtolower($name[1])
            ],
            $file
        );

        file_put_contents(app_path("/Http/Controllers/{$name[0]}/{$name[1]}Controller.php"), $template);
    }
        
   
    
    /**
     **====== CreateModel ======**
     *
     * @param mixed $name
     * @param mixed $fileName
     * @param mixed $version
     *
     *This will create Model above 5.8 laravel Version
     * @return void
     */

    protected static function CreateModel($name, $fileName, $version)
    {
        $template = str_replace(
            ['{{modelName}}'],
            [$name],
            CrudCreatorService::GetStubs($fileName)
        );
        $version >= 8 ? file_put_contents(app_path("Models/{$name}.php"), $template): file_put_contents(app_path("{$name}.php"), $template);
    }
}
