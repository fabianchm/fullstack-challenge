# Finizens' FullStack Challenge - Fabián Chirivella

## Instructions

In order to install and test the application, you can use the followings commands:

- make build : build every docker container (symfony app, vue frontend, nginx and mysql)
- make migrate : run the migrations to create all database tables. It is mandatory that mysql container is ready.
- make start : run the containers to serve the application*

* The application environment is set to development mode for testing the challenge, for example starting the
frontend runs the "npm run dev" command and keep the hot reloading active.

There is a few more commands available:

- make stop: stop the containers
- make unit-test : run the unit test for the application
- make integration-test : run integration test. In this case, there is only one test for testing the database integration

## Versions

- PHP: 8.1
- Nginx: 1.21
- Symfony: 6.3
- Mysql: 8.0.33
- Node: 20
- Vue: 3.4

## Folder structure and details

In terms of DDD I've decided to keep concepts like Portfolio and Order in the same bounded context. Maybe in a real 
application or having more context about the product it would have more sense having this two concepts separated.

In the Symfony application we have two main folders:
- /app contains controllers that are the entry points to the system.
- /src have the bounded contexts and the code related to the portfolio/order entities. Then we have the finance
bounded context with the two aggregate roots (Portfolio and Order) with the infrastructure folder having the listeners
and the persistence files required to persist the information in the database, the application folder that contains
the use cases of the platform and the domain folder containing all the business logic.
- /front have the frontent application contained in order to keep simplicity having all the application in the same repo.
The main parts of the frontends are inside the /src folder. All vue components and styles are inside /framework and all the
business logic, the types, the api calls are in /context folder.

## Some improvements

I've decided to have Portfolio as an aggregate root and the allocations inside as a collection, doing a join to keep 
them related in database. This may be not the best option in terms of performance but I think is the best option
for this challenge in terms of speed and efficiency. Other way to do this would be having the allocations as a json inside
the portfolio but in this application we are constantly modifying allocations so this would be bad on terms of performance.
Having portfolio and allocation in different modules as aggregates would be the correct way to do this, having a projection
of the portfolio and related data to serve to the frontend.

It would be nice to use value objects instead of primitives as entity properties. This would give us more validation
and encapsulate this code in the VO class instead of validating stuff outside. Also having object mothers to ensure
more variety in the tests. In the other way we have to create custom types and registering on the symfony class to map
this value objects to the database.

More validation and error handling. For example, at this moment, a non valid id error is handled by the database so we 
should have some domain errors to avoid this kind of errors. Or we can create an order for a non existent portfolio/allocation
and we should check this in a real environment.

At user experience level it would be a good idea to add some notifications for success/error actions in the frontend 
application.
