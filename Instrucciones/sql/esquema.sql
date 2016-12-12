create database BDNotas default character set utf8 collate utf8_unicode_ci;

create user userNotas@localhost identified by '@password@Notas';

grant all on BDNotas.* to  userNotas@localhost;

flush privileges;

use BDNotas;

create table usuario (
    idUsuario int not null primary key auto_increment,
    email varchar(150) unique not null,
    password varchar(256) not null,
    falta date not null,
    tipo enum('administrador','usuario') not null default 'usuario',
    estado tinyint,
    nombre varchar(150)
) engine=innodb  default charset=utf8 collate=utf8_unicode_ci;

create table nota (
    idnota int not null primary key auto_increment,
    idUsuario int not null,
    idTipoNota int not null,
    idColor int not null,
    fCreacion date not null
)engine=innodb  default charset=utf8 collate=utf8_unicode_ci;

create table color(
     idColor int primary key not null auto_increment,
     color varchar(6) not null,
     descripcion varchar(100)     
)engine=innodb  default charset=utf8 collate=utf8_unicode_ci;

create table tipoNota(
      idTipoNota int primary key not null auto_increment,
      tipo enum('texto','video','imagen') not null default 'texto',
      titulo varchar(150),
      texto varchar(250),
      url varchar(250) /*Cambiado por LongBlob para insertar img grandes*/          
)engine=innodb  default charset=utf8 collate=utf8_unicode_ci;



ALTER TABLE  `tipoNota` ADD  `video` VARCHAR( 200 ) NULL DEFAULT NULL AFTER  `url` ;