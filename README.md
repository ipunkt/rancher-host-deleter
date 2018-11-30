# rancher-host-deleter
Webhook to delete specific hosts in a rancher 1.6 environment

## Use case
In a perfect container environment every host is transient. If a host does not currently do work it can be thrown away
and later replaced by a new one should it become necessary.

Combining Prometheus and Grafana allows identifying empty hosts to be thrown away and to send alerts to webhooks with the 
hosts it found. (Note: make sure to activate reminders because grafana does not support alerts for multiple series yet but
reminders will show the current hosts)

This webhook is written as target for the grafana alert for an empty host, causing it to be deleted.
