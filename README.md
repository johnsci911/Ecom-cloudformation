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

### Limitation (free tier T2.micro)
Whenever I run 3 docker image, it consumes all of compute power so I decided to start two docker images

#### Project Address:
http://18.234.82.38:3000/

