# rancher-host-deleter
Webhook to delete specific hosts in a rancher 1.6 environment

## Use case
In a perfect container environment every host is transient. If a host does not currently do work it can be thrown away
and later replaced by a new one should it become necessary.

Combining Prometheus and Grafana allows identifying empty hosts to be thrown away and to send alerts to webhooks with the 
hosts it found. (Note: make sure to activate reminders because grafana does not support alerts for multiple series yet but
reminders will show the current hosts)

This webhook is written as target for the grafana alert for an empty host, causing it to be deleted.

## Development
docker/docker-compose.yml is used for testing purposes. Note that is actually builds the current app as Image so you will
have to rebuild to test changes you made.

	docker-compose -f docker/docker-compose.yml up --build -d

In addition you need a `docker/.env` file with at least the following content:

    APP_SECRET=somestring

### RancherCliDeleter
To actually delete hosts use the following in the `.env` file or your docker containers environment

    APP_DELETER=rancher-cli
    RANCHER_URL=URL
    RANCHER_ACCESS_KEY=access_key
    RANCHER_SECRET_KEY=secret_key
    
This expects a rancher environment api key and a environment specific url

### SlackMessageDeleter
To instead send slack messages for each request use

    APP_DELETER=slack
    SLACK_URL=webhook-url

Creating the slack webhook url is outside the scope of this readme. Please see the slack documentation about
incoming webhooks instead.
