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

Clone this project and start command composer :

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

DOCUMENTATION API
--------------
`/doc/api`
 
 No need authorization for documentation consulting.

REQUIRE FOR USE API
--------------

#### Create account 

 - Endpoint : `/api/users`
 - Method : `POST`
 - Headers : `Content-Type : Application/json`
 - Request (json format) :
```json
{
    "email": "email@domain.com",
    "username": "username",
    "plainPassword": "password"
}
```
 - Response exemple (json format) :
```json
{
    "Utilisateur": "Créé",
    "Vos_identifiants": {
        "client_id": "YOUR_CLIENT_ID",
        "client_secret": "YOUR_CLIENT_SECRET"
    }
}
```
***Keep this informations preciously for use API***

#### Get Token API 

 - Endpoint : `/oauth/v2/token`
 - Method : `POST`
 - Headers : `Content-Type : Application/json`
 - Request (json format) :
```json
{
    "grant_type": "password",
    "client_id": "your_client_id",
    "client_secret": "your_client_secret",
    "username": "your_username",
    "password": "your_password"
}
```
 - Response exemple (json format) :
```json
{
    "access_token": "YOUR_ACCESS_TOKEN",
    "expires_in": 3600,
    "token_type": "bearer",
    "scope": null,
    "refresh_token": "YOUR_REFRESH_TOKEN"
}
```
***Keep this informations preciously for use API***

*NOTE : 'YOUR_ACCESS_TOKEN' is valid for 1 hour*
 
#### Refresh Token API 

 - Endpoint : `/oauth/v2/token`
 - Method : `POST`
 - Headers : `Content-Type : Application/json`
 - Request (json format) :
```json
{
	"grant_type": "refresh_token",
	"client_id": "your_client_id",
	"client_secret": "your_client_secret",
	"refresh_token": "your_refresh_token"
}
```
 - Response exemple (json format) :
```json
{
    "access_token": "YOUR_NEW_ACCESS_TOKEN",
    "expires_in": 3600,
    "token_type": "bearer",
    "scope": null,
    "refresh_token": "YOUR_NEW_REFRESH_TOKEN"
}
```
***Keep this informations preciously for use API***

*NOTE : 'YOUR_NEW_ACCESS_TOKEN' is valid for 1 hour*


ENDPOINTS
--------------
### For all endpoints API you must use:

 - Method: `GET`
 - Headers : `authorization : Bearer your_token`

#### /api/users
For get all users api.
 - Response exemple (json format) :
```
[
    {
        "id": 1,
        "username": "user1",
        "_links": {
            "self": {
                "href": "/api/users/1"
            }
        }
    },
    {
        "id": 2,
        "username": "user2",
        "_links": {
            "self": {
                "href": "/api/users/2"
            }
        }
    },
    …
]
```
#### /api/users/{user_id}
For get a user details with id.
 - Response exemple (json format) :
```
{
    "id": 1,
    "username": "user1",
    "email": "user@domain.com",
    "roles": [] //empty if 'ROLE_DEFAULT' 
}
```

#### /api/articles
For get all articles api.
 - Response exemple (json format) ::
 ```
[
    {
        "id": 1,
        "marque": "Apple",
        "modele": "Iphone 6",
        "_links": {
            "self": {
                "href": "/api/articles/1"
            }
        }
    },
    {
        "id": 2,
        "marque": "Apple",
        "modele": "Iphone 6 Plus",
        "_links": {
            "self": {
                "href": "/api/articles/2"
            }
        }
    },
    …
 ```

#### /api/articles/{article_id}
For get article details with id.
 - Response exemple (json format) :
```json
{
    "id": 1,
    "marque": "Apple",
    "modele": "Iphone 6",
    "description": "Déverrouillez votre nouvel iPhone 6 à l'aide de votre empreinte pour acheter de la musique, profiter des meilleurs jeux et applications de l'Apple Store et synchronisez le avec l'Apple Watch!",
    "prix": 500
}
```
