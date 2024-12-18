# Use Cases
The system has been developed with two major use cases in mind:
1. The shop owner managing the back office.
2. The client purchasing the product and selecting the components.

## Backoffice 💻
The back office should operate using the Product.class entity. It represents all product catalogs, including their collections and components. Users can:
* Create, update, or delete a product, collection, or component.
* Update a component's price.
* Mark a component as out of stock or in stock.
* Add or remove incompatible components.

As an initial idea, the frontend will load all available products in a list using the `GET /products` method. When the owner selects a specific product, they can retrieve all relevant information, including collections and components, with the `GET /products/{product_id}` call. Once the page is loaded, the owner can create new collections and components using the `POST` method and manage the availability and incompatibility of the components with the `PATCH` method.

🔒 It is worth mentioning that all back-office use cases must be protected by a token access system to ensure availability only for authorized users. The token would be provided by a login system. Typically, all that uses Cass would be grouped in the same folder.

## Client purchasing 🛒
First, the user will search for or find a list of products. When the user selects one, all the product information, along with the collections and components, will be loaded and displayed. They can then select all the components they wish to include.
* Once a product purchase is selected, a Product Order is created that contains all the details about the selected product and components.
* If the product order is correct and the price is calculated, the order can be stored to make it available for the payment and shipping service. We can keep a record of the product order, but the best practice is to send a domain event for the payment and shipping service to listen for.
  * In the domain, I establish that a Product Order can be created even with incompatible or out-of-stock parts. This allows for the possibility of placing the order and waiting for the availability of the items, or initiating a discussion about the incompatible parts.

It is worth mentioning that the system is currently set up to handle only one product order at a time. However, in a real scenario, we should allow multiple product orders in the shopping cart or a similar feature to enable users to purchase more than one product simultaneously.

To manage the product information displayed to the client, we can create a separate use case to filter out specific details. For instance, if we want to hide the price of each component, this approach will allow us to show only the information we choose.

### Consideration about possible Product update/delete issue
In a Product Order, there is an instance of the selected product. This is important to know which exact product the user has purchased to avoid issues if the product is updated or deleted. For example, imagine I buy a bicycle in red. If, after my Product Order, the owner removes the red color as an option, my purchase was completed when the red color was available, and it should be reflected accordingly.

There are two options to solve this problem:
* We can save a Product instance serialized within the Product Order to identify the exact product purchased.
* We can store the Product ID in the Product Order. In this case, the Product ID must change each time the Product is updated, so it would effectively be a combination of the Product ID and version or something similar.
