Créez un site e-commerce exposant une API
========================

BileMo est un projet de formation OpenClassroom Développeur d'application PHP/Symfony

DEPENDENCES
--------------

* FOSUserBundle (users management)
* FOSOauthServerBundle (Oauth Server)
* JMSSerializerBundle (Serializer Json)
* BazingaHateoasBundle (Annotation Groups)
* NelmioApiDocBundle (Documentation API)
* DoctrineFixturesBundle (Generate Fake Data)

INSTALLATION
--------------

```
$ php composer install
```

### DATABASE

Create database:
```
$ php bin/console doctrine:database:create
```

Update table:
```
$ php bin/console doctrine:schema:update --force
```

### FIXTURES

Add article data into the database:
```
$ php bin/console doctrine:fixtures:load
```

REQUIRE FOR USE API
--------------

#### Create account 

Endpoint : `/api/users`

Method : `POST`

Headers : `Content-Type : Application/json`

Parameters (json format) :

```
{
	"email": "email@domain.com",
	"username": "username",
	"plainPassword": "password"
}
```

Return `client_id` and `client_secret`.
Keep this informations preciously for use API

#### Get Token API 

Endpoint : `/oauth/v2/token`

Method : `POST`

Headers : `Content-Type : Application/json`

Parameters (json format) :

```
{
	"grant_type": "password",
	"client_id": "your_client_id",
	"client_secret": "your_client_secret",
	"username": "your_username",
	"password": "your_password"
}
```

Return a `token` valid for 1 hour and a `refresh_token` 

#### Refresh Token API 

Endpoint : `/oauth/v2/token`

Method : `POST`

Headers : `Content-Type : Application/json`

Parameters (json format) :

```
{
	"grant_type": "refresh_token",
	"client_id": "your_client_id",
	"client_secret": "your_client_secret",
	"refresh_token": "your_refresh_token"
}
```

Return new `token` valid for 1 hour


ENDPOINTS
--------------

#### /api/doc
Method: `GET`

No need authorization for documentation consulting.

### For all others endpoints API you must use:

Method: `GET`

Headers : `authorization : Bearer your_token`

#### /api/users
For get all users api.

#### /api/users/{user_id}
For get a user details with id.

#### /api/articles
For get all articles api.

#### /api/articles/{article_id}
For get article details with id.

