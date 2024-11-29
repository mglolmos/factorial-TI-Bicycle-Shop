# Domain
All of the entities are expected to expand in the future. For example:
* Name could include more restrictions, such as special characters.
* Product can have additional fields, like Description, which would require creating another entity called LongText or something similar.
* Price could accept currency to make the system multi-currency compatible.

## Product
Entity that represents a catalog product, such as bicycles, skis, roller skates, etc.

* UUid: This represents the identifier of the product. It should be of UUID type and defined for the client to avoid possible collisions. It should not depend on the infrastructure to create the product.

* Name: Indicate the product's name.

* Collections: A set of collections of this product.

## Collection
Entity that represents a set of components like frame type, frame finish, wheels, rim color, etc.

* Id: This represents the identifier of the collection. It's not a UUID, as two collections with the same name cannot exist within the same product. For example, there cannot be two collections named "color".

* Name: Indicate the collection's name.

* Component: A set of components of this collection.


## Component
Entity that represents each option within a collection like full-suspension, diamond, matte, red, black, etc.

* Id: This represents the identifier of the component. It's not a UUID, as two components with the same name cannot exist within the same collection. For example, there cannot be two components named "red" inside collection "color".

* Name: Indicate the component's name.

* Price: Indicate the component's price.

* Incompatible Components: A set of components that can not be compatible with this component.

## Product Order
Entity that represents a specific product order. It checks if an order is correct and determines the final price based on the selected components and product information.

* UUid: This represents the identifier of the product order. It should be of UUID type and defined for the client to avoid possible collisions. It should not depend on the infrastructure to create the product order.

* Product: The Product entity represents the product catalog selected for the user in the order.

* Components Selected: A set of components chosen by the user from the selected product.

## UUID
An entity that represents a universal unique identifier is required for products and product orders. This allows us to make the system more scalable, as clients can create the identifier independently. We will not depend on any infrastructure, such as databases or ID generators. UUIDs also help us avoid identifier conflicts.

## ID
An entity that represents an identifier based on a name. This allows us to have consistent identifiers in sets where we cannot accept duplicates, such as Collections and Components.

## Name
An entity that represents any name in our system. This allows us to maintain consistent naming across all our domains, avoiding placeholder names such as those with excessive spaces, trailing spaces, minimum character limits, maximum character limits, and so on.

## Price
An entity that represents the price of a product or component. This allows us to maintain consistent pricing, avoiding negative numbers and enabling us to expand the system in the future, such as by adding currency options if we enter international markets.

