FROM ipunktbs/nginx:1.12.2

ADD https://releases.rancher.com/cli/v0.6.12/rancher-linux-amd64-v0.6.12.tar.gz /tmp

RUN apt-get update \
    && apt-get install -y wget ca-certificates apt-transport-https gnupg  \
	&& wget -q https://packages.sury.org/php/apt.gpg -O- | apt-key add - \
	&& echo "deb https://packages.sury.org/php/ stretch main" | tee /etc/apt/sources.list.d/php.list \
	&& apt-get update \
	&& apt-cache search php-fpm \
	&& apt-get install -y php7.2-fpm \
        tar \
        supervisor \
        && rm -Rf /var/lib/apt/lists/* \
        && tar -xzf /tmp/rancher-linux-amd64-v0.6.12.tar.gz --one-top-level=/usr/local/bin \
        && mkdir /run/php

COPY . /var/www/app/.
COPY docker/supervisor/*.conf /etc/supervisor/conf.d/
COPY docker/start.sh /usr/local/bin/start.sh

RUN chmod +x /usr/local/bin/start.sh

ENTRYPOINT [ '/usr/local/bin/start.sh' ]
CMD start

