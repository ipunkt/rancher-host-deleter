FROM alpine

ADD https://releases.rancher.com/cli/v0.6.12/rancher-linux-amd64-v0.6.12.tar.gz /tmp

RUN apk --no-cache add nginx \
        php \
        tar \
        && tar -xzf /tmp/rancher-linux-amd64-v0.6.12.tar.gz --one-top-level=/usr/local/bin

