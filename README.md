## Laravel CRUD Generator with Repository Repository Pattern.

## Installation

```
composer require mahabub/laravel-crud-and-repository
```

## Features

* Controller
* Model
* Migration
* Requests
* Routes
* Repository pattern
* views

## Configuration
Publish the configuration file

This step is required

```
php artisan vendor:publish --provider="Mahabub\CrudGenerator\\CrudServiceProvider"
```

## Usage

After publishing the configuration file just run the below command.

```
php artisan crud:make ModelName 
```

#### If what want to make controller in folder. Just run the below command.

```
php artisan crud:make FolderName/ModelName;
```

### If what want to make Repository Pattern. Just run the below command.

```
php artisan crud:make FolderName/ModelName --rep;
```
# Or

```
php artisan crud:make FolderName/ModelName --rep;
```

