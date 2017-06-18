FROM php:7.0-fpm

MAINTAINER Nithin Madhuranga <nithin@axis.lk>

# install mailcatcher
RUN apt-get update && \
    apt-get install -y build-essential g++ \
        libsqlite3-dev \
#        libaugeas-ruby1.9.1 \
#        augeas-tools \
        rubygems-integration \
        ruby \
        ruby-dev


RUN gem install mailcatcher

RUN apt-get remove -y build-essential && \
        apt-get autoremove -y && \
        apt-get clean && \
        rm -rf /var/lib/apt/lists


EXPOSE 1080 1025

CMD ["mailcatcher", "-f", "--ip=0.0.0.0"]