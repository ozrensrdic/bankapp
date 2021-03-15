# Slim Framework 4 Skeleton Application

## Available routes
Swagger: GET http://68.183.212.246/docs/v1
Branches:
GET http://68.183.212.246/branches
GET http://68.183.212.246/branches/{id}
POST http://68.183.212.246/branches

GET http://68.183.212.246/customers
GET http://68.183.212.246/customers/{id}
POST http://68.183.212.246/customers

GET http://68.183.212.246/transactions/
POST http://68.183.212.246/transactions/sender/{senderId}/receiver/{receiverId}

GET http://68.183.212.246/reports/branches/balance/
http://68.183.212.246/reports/branches/balance/highest/desc //highest and desc are optional parameters (highest, lowest and desc/asc)

GET http://68.183.212.246/reports/valuable/branches