# Equipment Demand Planner

## Description
This little planner allow you see what equipment stations have and will have in the future.

## Setup
1. Put password for DB in `server/.env`
2.
```
cd server
composer install
bin/console d:d:c && bin/console d:m:m && bin/console d:f:l
cd ../client/ && npm install
cd ../server
```
3. Run server with `php -S 127.0.0.1:8000 -t public`
4. Run client in different terminal tab `cd client/ && npm start`

### Client 
http://localhost:3000/

### Simple HTML view
http://localhost:8000/admin

## Tech Description
### Back
- Symfony 5
- Doctrine
- API Platform
- Easy Admin

### Front
- Typescript
- React
    - rout
    - no redux

## Leftovers
- There are no tests for a server because there nothing to test really
- There are no tests for a client part because it was not in the scope
- DB query not optimised and left as is
- Cache function is disabled, but of course there are multiple places where application will benefit from it
- App delivered as is without proper delivery platform such as docker or what not
- API Endpoint not cleaned up. There if far more open endpoint than need to be
