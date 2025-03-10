FROM unit:php8.3 AS app-dev
RUN --mount=type=bind,from=mlocati/php-extension-installer:latest,source=/usr/bin/install-php-extensions,target=/usr/local/bin/install-php-extensions \
  set -eux; \
  apt-get update && apt-get install -y --no-install-recommends zip unzip; \
  install-php-extensions xdebug; \
  rm -rf /var/lib/apt/lists/*
COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/
