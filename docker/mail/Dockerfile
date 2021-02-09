FROM alpine:3.7

MAINTAINER henk

RUN apk add --no-cache ca-certificates openssl
RUN apk add --no-cache ruby ruby-bigdecimal ruby-json sqlite-libs libstdc++

RUN apk add --no-cache --virtual .build-deps \
        ruby-dev \
        make g++ \
        sqlite-dev \
        && \
    gem install -v 0.6.4 mailcatcher --no-ri --no-rdoc && \
    apk del .build-deps

ARG smtpport
ARG httpport

# EXPOSE $smtp_port $http_port

# CMD ["mailcatcher", "--foreground", "--ip=0.0.0.0", '--smtp-port=$smtp_port', '--http-port=$http_port']

EXPOSE $smtpport $httpport

ENV smtpport $smtpport
ENV httpport $httpport

CMD /usr/bin/mailcatcher --foreground --ip=0.0.0.0 --smtp-port=$smtpport --http-port=$httpport

