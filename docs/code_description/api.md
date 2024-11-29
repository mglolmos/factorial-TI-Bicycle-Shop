# API

The API follows a REST methodology, using JSON for both input and output formats.

In the case of the back office calls, they must be secured by a user token that should be sent in the headers.

Not all the errors have been managed properly. However, in a real scenario, we should return a 4xx HTTP response code for cases such as bad input format or duplicate elements. Avoiding return 5xx HTTP response code.

The exercise includes only examples of GET and POST. However, for a complete API, we should also add DELETE, PATCH, and PUT as options to update and delete each of the entities.
