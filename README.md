# Docker Compose Setup for WordPress Environment

This repository provides a Docker Compose configuration for setting up a local WordPress development environment with
MariaDB, and phpMyAdmin.

* * *

## **Setup Guide**

### Prerequisites

- Docker and Docker Compose installed on your machine.

- Update your `/etc/hosts` file to include:

  `127.0.0.1 sports-web.local`

* * *

### **Steps to Set Up**

1. Clone this repository:
 ```bash
git clone <repository-url> && cd <repository-folder>
```
2. Copy `.env.example` to `.env`:
```bash
cp .env.example .env
```
3. Update the `.env` file with your desired configurations.
```
#example data
APP_ENV=local
DB_HOST=mariadb
DB_DATABASE=sports
DB_USERNAME=sport_user
DB_PASSWORD=p@ssword!123
MYSQL_ROOT_PASSWORD=p@ssword!123

WORDPRESS_ADMIN_USER=admin
WORDPRESS_ADMIN_PASSWORD=Admin@123
WORDPRESS_ADMIN_EMAIL=admin@example.com
WORDPRESS_URL=http://sports-web.local:8080
WORDPRESS_SITE_TITLE="Sport Site"
```
4. Copy the `wp-config.php.sample` file and update it with your database credentials:

```bash
cp ./wordpress/wp-config.php.sample ./wordpress/wp-config.php
```

5. Start the containers:
  ```bash
  #docker compose up -d on newest version
  docker-compose up -d
  ```

6. Turn off git file mode

```bash
git config core.fileMode false
```

* * *

### **WordPress CLI Commands**

Once the containers are up and running, SSH into the WordPress container to configure WordPress and migrate the database:

1. SSH into the WordPress container:

```bash
docker exec -it wordpress bash
```

2. Run migration and seeder (If asking about for production, can use yes):

```bash
cd /bitnami/wordpress && wp acorn migrate --seed --force --allow-root
```

3. Rebuild assets

```bash
cd /bitnami/wordpress/wp-content/themes/sage-theme && npm run build
```

* * *

### **Access the Environment**

- WordPress: http://sports-web.local:8080
- Live score dashboard: http://sport-web.local:8080/live-score-dashboard
- phpMyAdmin: http://sports-web.local:8081

* * *

## **File Structure**

- `wordpress/wp-content`: WordPress content folder.
- `wordpress/scripts`: Custom scripts for WordPress.
- `wordpress/wp-config.php`: WordPress configuration file.
- `db_data`: Persistent data storage for MariaDB.
- `wordpress/scripts/post-init.sh`: Script to run after the first installation of WordPress.

* * *

### Troubleshooting
- Verify that all ports specified in the `docker-compose.yml` file are available and not being used by other services.
