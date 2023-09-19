## Timetracker (Marc Lopez)

Hecho con el tiempo que he podido, la app ofrece prácticamente todo lo prescindible menos lo trabajado por día que no me ha dado tiempo a finalizar.

Para acceder a la app, usar comandos establecidos en archivo Makefile.

make build para montar docker.
make up para subirlo sin build
make down para bajar docker

A la app se accede a través de timetracker.com, tendréis que hostearlo en vuestro archivo hosts

Para poder acceder y probar los comandos, make console para entrar al contenedor

bin/console start:timer **nombre tarea** para comenzar a contar una tarea
bin/console stop:timer para parar el contador de una tarea en curso

Para poder acceder a la bdd tenéis el archivo .env con las credenciales

Un saludo,