FROM registry.fruition.net/fruition-internal/base-images:7.4-cli

## Get repo for latest LTS version of NodeJS
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - && \
  ## Get Debian Package for yarn
  curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
  echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
  apt-get update && apt-get install -y \
  gnupg2 nodejs yarn autoconf libtool && \
  apt-get clean && \
  rm -Rf /tmp/* \
  /var/tmp/* \
  /usr/include/php \
  /var/lib/apt/lists/* && \
  apt-get autoremove -y
  
EXPOSE 3000 3001
