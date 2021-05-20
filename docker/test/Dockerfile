# Use Elkarbackup as base image
FROM elkarbackup/base

# Required to run composer
RUN apt-get update && apt-get install -y \
      git \
      zip \
      sudo \
    && rm -rf /var/lib/apt/lists/*

# Download and install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY entrypoint.sh /
RUN chmod u+x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
CMD []
