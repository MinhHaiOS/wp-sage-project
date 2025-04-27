#!/bin/bash
set -euo pipefail

echo "Post-init script starting…"

install_nodejs_yarn() {
  apt-get update
  if ! command -v mysqlcheck >/dev/null; then
    echo "Installing MySQL client…"
    apt-get install -y default-mysql-client
  fi
  echo "Checking if curl exists..."

  if ! command -v curl > /dev/null; then
    echo "curl not found, installing..."
    apt-get install -y curl
  else
    echo "curl already installed."
  fi

  if ! command -v node > /dev/null; then
    echo "Node.js not found, installing..."
    curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
    apt-get install -y nodejs
  else
    echo "Node.js already installed."
  fi

  if ! command -v yarn > /dev/null; then
    echo "Yarn not found, installing..."
    npm install -g yarn
  else
    echo "Yarn already installed."
  fi
}

install_nodejs_yarn

# Directories
WORDPRESS_DIR="/bitnami/wordpress"
THEME_DIR="$WORDPRESS_DIR/wp-content/themes/sage-theme"
CACHE_DIR="$WORDPRESS_DIR/wp-content/cache"

# 1. Wait for database
echo "Waiting for database…"
until wp db check --allow-root --quiet; do
  sleep 3
done

# 2. Install WP core if needed
if ! wp core is-installed --allow-root --quiet; then
  echo "Installing WordPress core…"
  wp core install \
    --url="$WORDPRESS_URL" \
    --title="$WORDPRESS_SITE_TITLE" \
    --admin_user="$WORDPRESS_ADMIN_USER" \
    --admin_password="$WORDPRESS_ADMIN_PASSWORD" \
    --admin_email="$WORDPRESS_ADMIN_EMAIL" \
    --skip-email \
    --allow-root
else
  echo "WordPress already installed, skipping core install."
fi

# 3. Activate all plugins and setting permalink structure
echo "Activating all plugins…"
wp plugin activate --all --allow-root

echo "Setting permalink structure to 'Post name'…"
wp option update permalink_structure '/%postname%/' --allow-root

# 5. Your existing theme build steps
PAGE_COUNT=$(wp post list --post_type=page --format=count --allow-root)
if [ "$PAGE_COUNT" -gt 0 ]; then
  echo "Deleting $PAGE_COUNT existing page(s)…"
  wp post delete "$(wp post list --post_type=page --format=ids --allow-root)" --force --allow-root
else
  echo "No pages to delete."
fi

HOMEPAGE_ID=$(wp post list --post_type=page --title="Homepage" --format=ids --allow-root)
if [ -z "$HOMEPAGE_ID" ]; then
  echo "Creating new 'Homepage' page…"
  HOMEPAGE_ID=$(wp post create \
    --post_type=page \
    --post_title="Homepage" \
    --post_status=publish \
    --porcelain \
    --allow-root)
else
  echo "'Homepage' already exists (ID: $HOMEPAGE_ID), skipping create."
fi

# 5.3 Set Static Front Page
CURRENT_FRONT=$(wp option get show_on_front --allow-root)
CURRENT_PAGE=$(wp option get page_on_front --allow-root)
if [ "$CURRENT_FRONT" != "page" ] || [ "$CURRENT_PAGE" != "$HOMEPAGE_ID" ]; then
  echo "Setting static front page to 'Homepage' (ID: $HOMEPAGE_ID)…"
  wp option update show_on_front page --allow-root
  wp option update page_on_front "$HOMEPAGE_ID" --allow-root
else
  echo "Static front page already set correctly."
fi

if [ -d "$THEME_DIR" ]; then
  cd "$THEME_DIR"

  if [ -f composer.json ] && [ ! -d vendor ]; then
    echo "Installing Composer dependencies…"
    composer install -o --no-progress
  fi

  if [ -f package.json ] && [ ! -d node_modules ]; then
    echo "Installing NodeJS dependencies…"
    yarn install --frozen-lockfile --non-interactive
    echo "Building frontend assets…"
    yarn build
  fi
else
  echo "Sage theme not found at $THEME_DIR, skipping build."
fi

echo "Activating Sage theme…"
wp theme activate sage-theme --allow-root || {
  echo "Could not activate sage-theme—does it exist?"
}


# 6. Optional Laravel-Ignition step
if [ "${APP_ENV:-}" = "local" ]; then
  echo "APP_ENV is local: installing spatie/laravel-ignition…"
  composer require spatie/laravel-ignition --dev --no-interaction
  wp acorn optimize:clear --allow-root
else
  echo "APP_ENV is not local, skipping Ignition."
fi

# 7. Update permissions cache folder
if [ -d "$CACHE_DIR" ]; then
  echo "Updating permissions for cache folder…"
  chmod -R 777 "$CACHE_DIR"
else
  echo "Cache directory not found at $CACHE_DIR, skipping permissions update."
fi

echo "Post-init completed."