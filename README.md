# Laravel Data Objects Repository

Save Data Transfer Objects (from Spatie's [Laravel Data](https://github.com/spatie/laravel-data)) and Value Objects (from Michael Rubel's [Laravel Value Objects](https://github.com/michael-rubel/laravel-value-objects)) in database and attach to eloquent models.

## Installation

Install the package via composer:

```bash
composer require ibrostudio/laravel-data-objects-repository
```

Then run the installer:

```bash
php artisan data-repository:install
```

## Usage

Add the trait `IBroStudio\DataRepository\Concerns\HasDataRepository` to your Eloquent models.

The trait implements a `MorphManyDataObjects` relationship that extends `MorphMany`.

```php
namespace App\Models;

use IBroStudio\DataRepository\Concerns\HasDataRepository;
use Illuminate\Database\Eloquent\Model;

class YourEloquentModel extends Model
{
    use HasDataRepository;
}
```

### Working with DTO

Create your DTO following Spatie's Laravel Data [documentation](https://spatie.be/docs/laravel-data/v4/as-a-data-transfer-object/creating-a-data-object).

```php
namespace App\DataObjects;

use Spatie\LaravelData\Data;

class SongData extends Data
{
    public function __construct(
        public string $title,
        public string $artist,
    ) {
    }
}
```

```php
$data = new SongData(
    title: 'Walk', 
    artist: 'Pantera'
);
```


### Working with Value Objects

Use built-in Value Objects or create one following Michael Rubel's Value Objects [documentation](https://github.com/michael-rubel/laravel-value-objects).

```php
$data = new \MichaelRubel\ValueObjects\Collection\Complex\Name('Pantera');
```

Save the Value Object attached to the model in database:
```php
$model->data_repository()->add($data);
```

For more complex usage, you can use Value Objects in DTO:

```php
namespace App\DataObjects;

use Spatie\LaravelData\Data;
use MichaelRubel\ValueObjects\Collection\Complex\Name;

class SongData extends Data
{
    public function __construct(
        public Name $title,
        public Name $artist,
    ) {
    }
}
```

#### Creating or updating objects

The following method save the object in database and attach it to the model:
```php
$model->data_repository()->add($data);
```
If an object with the sans data class is already attached to the model, its values will be replaced.

#### Unique data class
You can attach many objects to a model but only one for each data class by default.
Considering the previous examples, the model can have only one SongData object (and other DTO or Value Objects).


#### Multiple data class
If you need more than one object from the same data class, use the `valuesAttributes` parameter when you create or update an object:
```php
$song1 = new SongData(
    title: 'Walk', 
    artist: 'Pantera'
);

$model->data_repository()->add($data);

$song2 = new SongData(
    title: 'Cowboys From Hell', 
    artist: 'Pantera'
);

$model->data_repository()->add(
    data: $song2,
    valuesAttributes: [
        'values->title' => $song2->title,
    ]
);

$song3 = new SongData(
    title: 'Davidian', 
    artist: 'Machine Head'
);

$model->data_repository()->add(
    data: $song3,
    valuesAttributes: [
        'values->artist' => $song3->artist,
    ]
);
```

### Retrieving objects

You access to all `MorphManyDataObjects` relations for a model with:
```php
$model->data_repository();
```

You can limit the instance to a specific data class to access a single object:
```php
$model->data_repository(dataClass: SongData::class);
```

The object is then retrieved by the `values()` method:
```php
$song = $model->data_repository(dataClass: SongData::class)->values();
```

If necessary, you can also constrain the retrieval of the object to certain values of this object with the `valuesQuery` parameter:
```php
$model->data_repository(
    dataClass: SongData::class,
    valuesQuery: ['title' => 'Walk']
);
```


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
