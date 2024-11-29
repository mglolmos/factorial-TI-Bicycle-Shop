# DB

A documented Redis database has been used for testing and exercise purposes.

If the project goes into production, we can determine which type of database would be best based on the context.

There would be two possible options:

## Documented DB
Documented database:
* Where we can store all products, including fields such as UUID, name, description, etc. and a payload will contain all the collections and components needed to retrieve everything, as they are highly coupled with each other.
* The same applies to product orders, where we can store all the IDs of the selected components and the chosen product. For the selected product, we can store either an ID or a serialized element of the product, as it is important to retain all the information about the product at the time of purchase.

## Relational DB
A relational database can follow a structure similar to a document database or create tables for each entity. However, I don't believe this is a useful scenario for us. The product, collection, and components are highly coupled and cannot exist independently.

A scenario where this could be more useful is if we allow the same component to be related to different products. I have assumed that this is not possible, but if it were, then a component, for example, would become an entity that can exist independently and should be stored as itself.