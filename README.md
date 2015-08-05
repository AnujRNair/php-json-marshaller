PHP JSON Marshaller
===================

A library to marshall and unmarshall JSON strings to populated PHP classes, driven by annotations.

We would like fine grain control over our marshalling and unmarshalling because:
* json_decode always returns a StdClass object. We want to be able to decode into our own classes.
* We can add expected type information about the data we are receiving/sending and validate it before using it.
* json_encode cannot be controlled on a property by property basis. This will allow us to do that.

The latest version can be found here: https://github.com/AnujRNair/php-json-marshaller.

Installation
-------------------

    $ git clone https://github.com/AnujRNair/php-json-marshaller.git
    $ composer install

Usage
-------------------

In your classes, add MarshallProperty annotations to your properties and methods to describe how JSON should be marshalled or unmarshalled.

The MarshallProperty annotation requires a name and type, otherwise an exception will be thrown.

You can do this on any public property or method.

```php
class User
{

    /**
     * @MarshallProperty(name="id", type="int")
     * This property is public - it will be accessed directly
     */
    public $id;
    
    /**
    * This property is NOT public - it must be accessed through a getter (marshalling) or a setter (unmarshalling)
    */
    protected $name;
    
    /**
     * @MarshallProperty(name="name", type="string")
     * This function will be used for marshalling json
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @MarshallProperty(name="name", type="string")
     * This function will be used for unmarshalling json
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
}
```

Once you have configured your class, load an instance of the JSONMarshaller class, and call the marshall or unmarshall function:

```php
$json = '{
    "id": 12345,
    "name": "Anuj"
}';

// Assuming autoloading
$marshaller = new JsonMarshaller(new ClassDecoder(new DoctrineAnnotationReader()));

// Notice the fully qualified namespace!
$user = $marshaller->unmarshall($json, '\My\Example\User');

// Use the new class
echo $user->getName(); // (string) 'Anuj'

// Marshall the class
$marshalled = $marshaller->marshall($user);

// $json and $marshalled are both json_encoded string holding the same data
$json == $marshalled;
```

The `$user` variable should now be an instance of the `\My\Example\User` class, and be populated with the id and name we passed in from the JSON string.

The `$marshalled` variable will be a json encoded string holding data from the `\My\Example\User` object instance.

Nesting Objects
-------------------

You can also nest classes within classes for recursive marshalling and unmarshalling like so:

```php
class User
{

    /**
     * @MarshallProperty(name="address", type="\My\Example\Address")
     * Notice the fully qualified namespace!
     */
    public $address;

}
```

And then in your code:

```php
$json = '{
    "id": 12345,
    "name": "Anuj",
    "address": {
        "id": 1,
        "street": "123 Main Street"
    }
}';

// Assuming autoloading
$marshaller = new JsonMarshaller(new ClassDecoder(new DoctrineAnnotationReader()));

// Notice the fully qualified namespace!
$user = $marshaller->unmarshall($json, '\My\Example\User');

// Use the nested object
$user->getAddress()->getStreet(); // (string) "123 Main Street"
```

Arrays of Objects
-------------------

You can marshall and unmarshall arrays of scalars/objects by indicating so in the type of the MarshallProperty annotation:

```php
class User
{

    /**
     * @MarshallProperty(name="flags", type="\My\Example\Flag[]")
     * Notice the fully qualified namespace and the array indicator in the type
     */
    public $flags;

}
```

Then in your code:

```php
$json = '{
    "id": 12345,
    "name": "Anuj",
    "flags": [
        {
            "id": 11087,
            "value": 0
        },
        {
            "id": 11088,
            "value": 1
        }
    ],
}';

// Assuming autoloading
$marshaller = new JsonMarshaller(new ClassDecoder(new DoctrineAnnotationReader()));

// Notice the fully qualified namespace!
$user = $marshaller->unmarshall($json, '\My\Example\User');

// Use the data
$user->getFlags()[0]->getId(); // (int) 11087
```

Unmarshalling into Objects with a Constructor
-------------------

To unmarshall into an object with a constructor, with required params, use the @MarshallCreator annotation to describe to the marshaller which values to instantiate the class with.

This Annotation takes an array of @MarshallProperty objects like the following:

```php
class User
{

    /**
     * @var int $id
     */
    protected $id;

    /**
     * @var float $rank
     */
    protected $rank;

    /**
     * @MarshallCreator({@MarshallProperty(name="id", type="int"), @MarshallProperty(name="rank", type="float")})
     */
    public function __construct($id, $rank)
    {
        $this->id = $id;
        $this->rank = $rank;
    }

}
```

The marshaller will then look for these values in the json string passed to it (The same level on which the class was instantiated) and instantiate the object with these values.

Caching
-------------------

You can cache decoded classes for performance boosts. This will _not_ cache data from JSON strings.

To do so, instantiate an instance of the `Cache` class, and pass in a storage type. Then pass this through to the `ClassDecoder` instance:

```php
$marshaller = new JsonMarshaller(
    new ClassDecoder(
        new DoctrineAnnotationReader(),
        new Cache(
            new InMemoryStorage()
        )
    )
);
```

See `\PhpJsonMarshaller\Cache\Storage` for all storage types available. `MemcachedStorage` has a few options you can set as well.

Unknown Entries
-------------------

You can specifically allow a class to fail on any unknown json variables by adding a MarshallConfig annotation to a specific class:

```php
/**
 * @MarshallConfig(ignoreUnknown=false)
 */
class User
{

}
```

Now if you try unmarshalling an unknown variable into this class, an exception will be thrown.

Tests
-------------------

Testing is covered by PHPUnit. Browse to the root of the library and run `phpunit`.

Please ensure you have the memcached daemon running to ensure the `MemcachedStorageTest` tests pass.

License
-------------------

Feel free to use wherever, however.