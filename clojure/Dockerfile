FROM clojure:alpine
ENV LEIN_EXEC_VERSION=0.3.7
RUN echo "{:user {:plugins [[lein-exec \"$LEIN_EXEC_VERSION\"]]}}" > ~/.lein/profiles.clj
RUN lein
RUN mkdir /src
WORKDIR /src
