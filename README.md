# IlluminateDatabaseLib Module for NamelessMC

This module provides an integration of Laravel's Illuminate Database library for use within NamelessMC modules or plugins. It allows developers to utilize Eloquent ORM and other database features from the Laravel ecosystem in their NamelessMC projects.

## Features
- Eloquent ORM support
- Query builder
- Integration with NamelessMC module system

## Installation
1. Place the `IlluminateDatabaseLib` folder inside your `modules/` directory of your NamelessMC installation.

## Usage
1. Include the module in your NamelessMC project by enabling it from the Admin Panel or by ensuring it is loaded in your module loader.
2. Use the provided `BaseModel.php` as a base for your Eloquent models, or use Illuminate's Eloquent features directly in your custom modules.
3. Example usage:

```php
use IlluminateDatabaseLib\\BaseModel;

class User extends BaseModel {
    protected $table = 'nl2_users';
}

$users = User::all();
```

## Creating Modules That Use This Library
To create a NamelessMC module that uses the IlluminateDatabaseLib, follow these steps:

1. **Set Dependency in Module Loader**
   In your module's main class (usually extending `Module`), specify `load_after: ['IlluminateDatabaseLib']` in the parent constructor. This ensures your module loads after the database library is available.

   Example:
   ```php
   class MyModule extends Module {
       public function __construct() {
           parent::__construct($this, 'MyModule', 'Author', '1.0.0', '2.2.2', load_after: ['IlluminateDatabaseLib']);
           // ... your module setup ...
       }
   }
   ```

2. **Use Eloquent Models**
   Extend `IlluminateDatabaseLib\\BaseModel` for your models to use Eloquent ORM features.

   Example:
   ```php
   use IlluminateDatabaseLib\\BaseModel;

   class MyModel extends BaseModel {
       protected $table = 'nl2_my_table';
   }
   ```

3. **Access Models Anywhere in Your Module**
   You can now use Eloquent ORM methods in your module:
   ```php
   $items = MyModel::where('active', 1)->get();
   ```

**Note:** Always ensure `IlluminateDatabaseLib` is enabled before your module.

## Requirements
- NamelessMC v2 or higher
- PHP 8.0 or higher

## What is this?
This is a library module that brings Laravel's powerful database tools to NamelessMC, making it easier to build complex modules with robust database support. It is intended for developers who want to leverage modern PHP database practices within the NamelessMC ecosystem.
