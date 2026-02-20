drop database if exists blog;
create database if not exists blog;
use blog;

create table if not exists USERS (
    USER_ID int auto_increment primary key,
    USERNAME varchar(32),
    EMAIL varchar(64),
    PSSWRD varchar(128),
    IS_ADMIN tinyint(1) default 0,
    IS_RESTRICTED tinyint(1) default 0
);

create table if not exists POSTS (
    POST_ID int auto_increment primary key,
    TITLE varchar(32),
    CONTENT text,
    PUBLISH_DATE datetime default NOW()
);

create table if not exists COMMENTS (
    COMMENT_ID int auto_increment primary key,
    CONTENT text,

    USER_ID int,
    POST_ID int,

    foreign key (USER_ID) references USERS(USER_ID),
    foreign key (POST_ID) references POSTS(POST_ID)
);
