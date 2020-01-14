# Newsletter Sign-up
> A newsletter sign-up app built on PHP micro-services

## The Task

Create a newsletter sign-up form with validation, that posts to a JSON API which stores it in a database. It should only allow a user to sign up once.

## The Solution

This solution is relatively over-engineered considering the simplicity of the task.
However I've been experimenting with Micro-services, CQRS and Event Sourcing with PHP
so I decided to continue with this exploration.

The app consists of:
* A Vue.js front end with Bulma. This makes REST calls to -
* The API gateway built in Lumen. All of the backend services communicate through messages via RabbitMQ, only the API gateway exposes any endpoints.
This serves to keep the services decoupled and avoid building a "distributed monolith". The API turns the POST data into a synchronous message because
we need to know the result of the operation to inform the user. The message is handled by -
* The signup service. The bulk of the logic exists in this service. This handles validating the request and persisting the data into a PostgreSQL database
via a write repository built on Prooph (an event sourcing library for PHP) and a read repository built on Doctrine.
The controller in `src/Signup/Infrastructure/Delivery/RPC` converts the message into a request (also known as a command)
and passes it to the command bus which ferries it into the Domain layer to be handled by a service (or command handler).
On success the app creates a new message to alert other services to the successful addition of a new subscriber. This message
uses the publish/subscribe messaging pattern. This is firstly because this is asynchronous; the end user does not need to be made
aware of the success status of this operation. Also this will enable other services that may be added at a later date to also subscribe
to this event; for instance a reporting service may need to respond to a new subscriber being added. Currently the only subscriber is -
* The mailer service. This sends a welcome mailer to the new subscriber. Being a development build this uses mailcatcher, you can view it here:
http://localhost:1080/

## Setup

* Clone the project,
* Run `make setup` in the root of the project. This will build the first couple of containers, install the composer dependencies in each service and run the doctrine migrations,
* Run `docker-compose up` to spin up the rest of the containers. Each service runs in its own container to allow independent scaling and potentially different tech stacks per service.
Subsequent runs may take a little longer to become ready since RabbitMQ takes some time to become ready and start accepting connections. The service containers which rely on RabbitMQ
will continue to attempt to start until RabbitMQ becomes responsive. You can check whether the containers are running with `docker ps`. Or monitor them until they are all running with
`watch docker ps` if you have `watch` installed.
* Go to http://localhost:8080/ to test the project. You can also test the API directly if you wish, the `docs` directory in the root of the project contains postman exports to test the endpoints.
* View mailcatcher at http://localhost:1080/ or view the messages on the RabbitMQ dashboard at http://localhost:8081/ username and password: `guest`.

## Areas for Improvement

* The API key, DB  credentials and RabbitMQ connection details are all committed to the repository. Either in config files or in the docker configuration files.
These should be moved into a secret store,
* The API authentication is very basic with a static API key. It could be improved using oAuth or similar,
* The project currently has no tests. Ideally the unit tests should have been written first,
* The signup controller in the API currently does nothing with the error if an exception is thrown. This should be logged somewhere. Ideally we would have a centralized place
to store logs raised from every service. Using something like logstash,
* The Vue.js front-end "production" distribution is currently built and committed to the repository. We should really be building that as a step in an automated deployment pipeline,
perhaps using a Continuous Integration server,
* Messages passed between services are unencrypted,
* All services are committed to the same "monorepo". If each service was in its own repository it would be far more trivial to manage deployments for each service independently.


Giles Lloyd – giles@cableandcode.co.uk
