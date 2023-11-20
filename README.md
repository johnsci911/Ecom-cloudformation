# ecom-site

## Frontend
`ecom-site`

* Vue 3
* Vue Apollo
* GraphQL


### Backend

* Laravel 10
    - `catalogs` - to show products (Products have its own user, logged in user who bought the product)
    - `checkouts` - for tracking user checkouts
    - `email_sender` - for tracking emails sent

### Email service

* Mailtrap.io
```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME={username}
MAIL_PASSWORD={password}
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="admin@ecom.com"
MAIL_FROM_NAME="ecom"
```

### AWS Cloudformation

* `cf.json` - for provisioning the AWS Cloudformation

### Docker service names
    catalogs
    checkouts
    email_sender
---
  * Ports used for backend (GraphQL)
    * 8000 - catalogs
    * 8002 - checkouts
    * 8004 - email_sender
---
  * MySQL
    * `catalogs_db` - 33061
    * `checkouts_db` - 33062
    * `email_sender_db` - 33063
---
---
#### Project Address:
http://18.234.82.38:3000/

### Running localhost
* Catalogs, Checkouts, Email_sender
  * `docker-compose up -d` - Run a container
  * `docker-compose exec {server name} sh` - Run artisan command inside catalogs image
  ---
  #### Database setup inside each containers
  ##### catalogs
  ```
    DB_CONNECTION=mysql
    DB_HOST=checkouts_db
    DB_PORT=3306
    DB_DATABASE=checkouts
    DB_USERNAME=root
    DB_PASSWORD=root
  ```
  ##### checkouts
  ```
    DB_CONNECTION=mysql
    DB_HOST=checkouts_db
    DB_PORT=3306
    DB_DATABASE=checkouts
    DB_USERNAME=root
    DB_PASSWORD=root
  ```
  ##### email_sender
  ```
    DB_CONNECTION=mysql
    DB_HOST=email_sender_db
    DB_PORT=33061
    DB_DATABASE=email_sender
    DB_USERNAME=root
    DB_PASSWORD=root
  ```
---
### Limitation (free tier T2.micro)
Whenever I run 3 docker image, it consumes all of compute power so I decided to start two docker images
