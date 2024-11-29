# Code exercise

> ℹ️ **Information:** Not all the cases have been finished. The core model is complete, but some Controllers and UseCases are still pending. That said, there are sections of the code where you can see how each part would be resolved.

## Download the project
To download the project:
```
git pull git@github.com:mglolmos/factorial-TI-Bicycle-Shop.git
```

## Set up and running the code 🚀

To set up and run the code:
```
make up
```

## Run test ✅
To run the test:
```
make test
```

## Dependencies
* PHP 8.3: I have chosen the latest version with the longest active support. PHP 8.4 was not a candidate in my opinion, as it was released only a few days ago. 
* Symfony 6.4: A long-term support version of Symfony.
* Redis 7.4: Latest stable version.
* Nginx 1.27: Latest stable version.

## Code description ([🔗](code_description.md))

### Domain ([🔗](code_description/domain.md))

The code has been structured according to the DDD framework. The core domain is based on this main entities:
* Product: Entity that represents a catalog product, such as bicycles, skis, roller skates, etc.
* Collection: A set of components like frame type, frame finish, wheels, rim color, etc.
* Component: Each option within a collection, including full-suspension, diamond, matte, red, black, etc.

* Product Order: Entity that represents a specific product order. It checks if an order is correct and determines the final price based on the selected components and product information.

### Use Cases ([🔗](code_description/use_cases.md))

All use cases must be located in the `Application/UseCases` folder. They can be grouped by type or domain element, depending on the criteria.

### API ([🔗](code_description/api.md))
All controllers are located in the `Infrastructure/Http` folder. The code is structured to be independent of the input, enabling it to work with both controllers and asynchronous commands. The unique logic that will change is within the Infrastructure folder.

### DB ([🔗](code_description/db.md))
A documented Redis database has been used for testing and exercise purposes. If the project goes into production, we can determine which type of database would be best based on the context. The code is designed to allow for changes to the database without altering the core model; only the infrastructure component needs to be modified.

### Test
All tests can be run by executing `make test`. Alternatively, you can run just the unit tests with `test-unit` or the E2E tests with `test-e2e`.

