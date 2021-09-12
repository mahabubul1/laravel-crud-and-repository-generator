## Laravel CRUD Generator with Repository Repository Pattern.

## Installation

```
composer require mahabub/laravel-crud-and-repository-generator
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
php artisan vendor:publish --tag=resources
```

## Usage

After publishing the configuration file just run the below command.

```
php artisan crud:make ModelName 
```

### If what want to make controller in folder. Just run the below command.

```
php artisan crud:make FolderName/ModelName;
```

### If what want to make controller in folder with Repository Pattern. Just run the below command.

```
php artisan crud:make FolderName/ModelName --rep;
```
### If what want to make controller in folder without Repository Pattern. Just run the below command.

```
php artisan crud:make FolderName/ModelName ;
```

