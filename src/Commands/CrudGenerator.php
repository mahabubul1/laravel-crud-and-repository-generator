<?php
namespace Mahabub\CrudGenerator\Commands;

use Illuminate\Console\Command;
use Mahabub\CrudGenerator\CrudCreatorClass\CrudCreatorService;
use Mahabub\CrudGenerator\CrudCreatorClass\RepositoryGenerate;

class CrudGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:make {name} {--rep}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create all Crud operations with a single command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

     
       
        $name = $this->argument('name');
   
        $optional= $this->option('rep');

        CrudCreatorService::MakeController($name ,$optional);
        
        CrudCreatorService::MakeModel($name);
        CrudCreatorService::MakeMigration($name);
        CrudCreatorService::MakeView($name);
        CrudCreatorService::MakeRoute($name);
        CrudCreatorService::MakeRequest($name);
        
        $this->info('model created successfully');
        $this->info('controller created successfully');
        $this->info('view created successfully');

        if($optional){
            RepositoryGenerate::ImplementNow($name);
            $this->info('Repostiory class created successfully');
        }
    }
}
