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

###### Publish The Resources File

```
php artisan vendor:publish --tag=resources
```
###### Publish The Config File

```
php artisan vendor:publish --tag=crud-generator
```
 
```
 Then go to config/crud-generator.php and configur laravel version
```

## Usage

### If what want to generate without folder. Just run the below command.

```
php artisan crud:make ModelName 
```

### If what want to generate with Repository Patter without folder. Just run the below command.

```
php artisan crud:make ModelName --rep
```

### If what want to generate in folder. Just run the below command.

```
php artisan crud:make FolderName/ModelName;
```

### If what want to generate in folder with Repository Pattern. Just run the below command.

```
php artisan crud:make FolderName/ModelName --rep;
```
### If what want to generate in folder without Repository Pattern. Just run the below command.

```
php artisan crud:make FolderName/ModelName ;
```

