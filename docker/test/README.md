# Elkarbackup test Docker image

Todo:
- run-docker-tests.sh build (include donotstop)
- run-docker-tests.sh up
- run-docker-tests.sh down
(by default, build & up)


Questions:

Missing an include statement in Dockerfile (i'm not the only one)
- Proposed solution: Base image, donotstart... alternatives:
  - Remove base image from docker-compose. Should be built and tagged by hand/bash script.
  - Use exactly the same image, with different entrypoint. We need to install dependencies in running stage - entrypoint?
  - Copy/paste the same Dockerfile and add the dependencies?



More questions:
- Mounting codebase as volume instead of copy? (first issue, composer install in entrypoint etc)
- Composer installed using docker itself (like in production).
- Mysql/Mariadb version?
- Db volume, required for tests?

By the way, in prod sudo is installed. I do not remember why...

Is this a problem?

elkarbackup_1  | No lock file found. Updating dependencies instead of installing from lock file. Use composer update over composer install if you do not have a lock file.
