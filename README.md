# DAAD-70 - Examen 2do Parcial: CRUD Alumnos
Materia: Desarrollo de Aplicaciones con Acceso a Datos

# Requerimientos
- PHP >= 7
- MySQL >= 5.7

## Instalacion

Migrar base de datos:

    mysql -u root -p < database_scripts/database.sql
    
 Posteriormente deberá introducir su contraseña de MySQL.
 
**NOTA:** Generalmente **root** es el nombre de usuario por defecto en MySQL, en caso de tener un nombre de usuario diferente reemplazarlo. 

Finalmente, copiar el archivo de variables de entorno:

    cp env.json.example env.json

Y colocar dentro las variables requeridas para la configuracion de entorno y la conexion a la base de datos. Aquí un ejemplo:

```json
{
  "APP_ENV": "local",
  "DB_HOST": "localhost",
  "DB_USER": "root",
  "DB_PASSWORD": "password",
  "DB_DATABASE": "school"
}
```

## Notas finales

El presente software no es ningun framework oficial de PHP. Cada una de las librerias en este proyecto fueron programados desde cero unicamente con fines academicos y de practica.

Todos los archivos finales fueron publicados en el siguiente repositorio de GitHub:

[https://github.com/mikebsg01/DAAD-70-Examen2doParcial-CRUD-Alumnos/](https://github.com/mikebsg01/DAAD-70-Examen2doParcial-CRUD-Alumnos/)

---
Copyright (c) 2018 Michael Serrato
