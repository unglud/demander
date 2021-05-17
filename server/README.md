# Equipment Demand Planner

## Description
This little planner allow you see what equipment stations have and will have in the future.

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
