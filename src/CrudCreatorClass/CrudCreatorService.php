<?php
namespace Mahabub\CrudGenerator\CrudCreatorClass;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
Class CrudCreatorService {


    protected static function GetStubs($type)
    {
        return file_get_contents(resource_path("mahabub/stubs/$type.stub"));
    }

      /**
     * @param $name
     * This will create controller from stub file
     */
    public static function MakeController($name, $optional)
    {
   
        if (strpos($name, '/') !== false) {
            $name=explode('/', $name);
            $path= app_path('Http/Controllers/'.$name[0]);
            if (!File::exists($path)) {
                File::makeDirectory($path);
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
                    strtolower( Str::plural($name[1])),
                    strtolower($name[1])
                ],
                 
                ($optional)? CrudCreatorService::GetStubs('ControllerresFolder') : CrudCreatorService::GetStubs('ControllerFolder') 
                
            );

            file_put_contents(app_path("/Http/Controllers/{$name[0]}/{$name[1]}Controller.php"), $template);


        }else{
            $template = str_replace(
                [
                    '{{modelName}}',
                    '{{modelNamePluralLowerCase}}',
                    '{{modelNameSingularLowerCase}}',
                ],
                [
                    $name,
                    strtolower( Str::plural($name)),
                    strtolower($name)
                ],

                ($optional)? CrudCreatorService::GetStubs('Controllerres') : CrudCreatorService::GetStubs('Controller') 
                
            );
            file_put_contents(app_path("/Http/Controllers/{$name}Controller.php"), $template);
        }
    }

    /**
     * @param $name
     * This will create model from stub file
     */
    public static function MakeModel($name)
    {
       $name= str_replace('/','',strstr($name,"/")) !=""? str_replace('/','',strstr($name,"/")) :$name;

        $template = str_replace(
            ['{{modelName}}'],
            [$name],
            CrudCreatorService::GetStubs('Model')
        );

        file_put_contents(app_path("Models/{$name}.php"), $template);
    }
   
   public static function MakeMigration($name)
   {
       Artisan::call('make:migration create_'. strtolower( Str::plural($name)).'_table --create='. strtolower( Str::plural($name)));

   }

    /**
     * @param $name
     * This will create route in web.php file
     */
    public static function MakeRoute($name)
    {
        $name= str_replace('/','',strstr($name,"/")) !=""? str_replace('/','',strstr($name,"/")) :$name;
        $path_to_file  = base_path('routes/web.php');
        $version = config('crud_generator.laravel_version');
        if($version < 8){
            $append_route = 'Route::resource(\'' . Str::plural(strtolower($name)) . "', {$name}Controller); \n";
        }else{
           $append_route = 'Route::resource(\'' . Str::plural(strtolower($name)) . "', {$name}Controller::class); \n";
        }
        File::append($path_to_file, $append_route);
    }



   public static function MakeView($name){
       
    $name= str_replace('/','',strstr($name,"/")) !=""? str_replace('/','',strstr($name,"/")) :$name;
    $name=strtolower($name);
    $path= resource_path('views/'.strtolower($name));
    if (!File::exists($path)) {
        File::makeDirectory($path);
    }
    touch(resource_path("views/{$name}/index.blade.php"));
    touch(resource_path("views/{$name}/create.blade.php"));
    touch(resource_path("views/{$name}/edit.blade.php"));
    touch(resource_path("views/{$name}/update.blade.php"));
   }

   /**
     * @param $name
     * This will create Request from stub file
     */
    public static function MakeRequest($name)
    {
        $name= str_replace('/','',strstr($name,"/")) !=""? str_replace('/','',strstr($name,"/")) :$name;

        $template = str_replace(
            ['{{modelName}}'],
            [$name],
           CrudCreatorService::GetStubs('Request')
        );

        if (!file_exists($path=app_path('/Http/Requests/')))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Requests/{$name}Request.php"), $template);
    }



}