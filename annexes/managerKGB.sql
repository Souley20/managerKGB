create table agents
(
    id            int auto_increment
        primary key,
    lastname      varchar(255) not null,
    firstname     varchar(255) not null,
    date_of_birth datetime     not null,
    id_code       varchar(255) not null
);

create table contacts
(
    id            int auto_increment
        primary key,
    lastname      varchar(255) null,
    firstname     varchar(255) not null,
    date_of_birth datetime     null,
    name_code     varchar(255) null
);

create table countries
(
    id            int auto_increment
        primary key,
    name          varchar(255) null,
    nationalities varchar(255) null,
    iso3166       varchar(255) null
);

create table agent_country
(
    id         int auto_increment
        primary key,
    agent_id   int null,
    country_id int null,
    constraint agent_country_agents_id_fk
        foreign key (agent_id) references agents (id),
    constraint agent_country_countries_id_fk
        foreign key (country_id) references countries (id)
);

create table contact_country
(
    id         int auto_increment
        primary key,
    contact_id int null,
    country_id int null,
    constraint contact_country_contacts_id_fk
        foreign key (contact_id) references contacts (id),
    constraint contact_country_countries_id_fk
        foreign key (country_id) references countries (id)
);

create table hideouts
(
    id      int auto_increment
        primary key,
    code    varchar(255) null,
    address varchar(255) null
);

create table country_hideout
(
    id         int auto_increment
        primary key,
    country_id int null,
    hideout_id int null,
    constraint country_hideout_countries_id_fk
        foreign key (country_id) references countries (id),
    constraint country_hideout_hideouts_id_fk
        foreign key (hideout_id) references hideouts (id)
);

create table missions
(
    id         int auto_increment
        primary key,
    title      varchar(255)                       null,
    content    longtext                           null,
    name_code  varchar(255)                       null,
    created_at datetime default CURRENT_TIMESTAMP not null,
    closed_at  datetime default CURRENT_TIMESTAMP null
);

create table agent_mission
(
    id         int auto_increment
        primary key,
    agent_id   int null,
    mission_id int null,
    constraint agent_mission_agents_id_fk
        foreign key (agent_id) references agents (id),
    constraint agent_mission_missions_id_fk
        foreign key (mission_id) references missions (id)
);

create table contact_mission
(
    id         int auto_increment
        primary key,
    contact_id int null,
    mission_id int null,
    constraint contact_mission_contacts_id_fk
        foreign key (contact_id) references contacts (id),
    constraint contact_mission_missions_id_fk
        foreign key (mission_id) references missions (id)
);

create table country_mission
(
    id         int auto_increment
        primary key,
    country_id int null,
    mission_id int null,
    constraint country_mission_countries_id_fk
        foreign key (country_id) references countries (id),
    constraint country_mission_missions_id_fk
        foreign key (mission_id) references missions (id)
);

create table hideout_mission
(
    id         int auto_increment
        primary key,
    hideout_id int null,
    mission_id int null,
    constraint hideout_mission_hideouts_id_fk
        foreign key (hideout_id) references hideouts (id),
    constraint hideout_mission_missions_id_fk
        foreign key (mission_id) references missions (id)
);

create table specialities
(
    id   int auto_increment
        primary key,
    name varchar(255) null
);

create table agent_speciality
(
    id            int auto_increment
        primary key,
    agent_id      int null,
    speciality_id int null,
    constraint agent_speciality_agents_id_fk
        foreign key (agent_id) references agents (id),
    constraint agent_speciality_specialities_id_fk
        foreign key (speciality_id) references specialities (id)
);

create table mission_speciality
(
    id         int auto_increment
        primary key,
    mission_id int null,
    speciality int null,
    constraint mission_speciality_missions_id_fk
        foreign key (mission_id) references missions (id),
    constraint mission_speciality_specialities_id_fk
        foreign key (speciality) references specialities (id)
);

create table status
(
    id   int auto_increment
        primary key,
    name varchar(255) null
);

create table mission_status
(
    id         int auto_increment
        primary key,
    mission_id int null,
    status_id  int null,
    constraint mission_status_missions_id_fk
        foreign key (mission_id) references missions (id),
    constraint mission_status_status_id_fk
        foreign key (status_id) references status (id)
);

create table targets
(
    id            int auto_increment
        primary key,
    lastname      varchar(255) null,
    firstname     varchar(255) null,
    date_of_birth datetime     null,
    name_code     varchar(255) null
);

create table country_target
(
    id         int auto_increment
        primary key,
    country_id int null,
    target_id  int null,
    constraint country_target_countries_id_fk
        foreign key (country_id) references countries (id),
    constraint country_target_targets_id_fk
        foreign key (target_id) references targets (id)
);

create table mission_target
(
    id         int auto_increment
        primary key,
    mission_id int null,
    target_id  int null,
    constraint mission_target_missions_id_fk
        foreign key (mission_id) references missions (id),
    constraint mission_target_targets_id_fk
        foreign key (target_id) references targets (id)
);

create table types_hideouts
(
    id   int auto_increment
        primary key,
    name varchar(255) null
);

create table hideout_type
(
    id         int auto_increment
        primary key,
    hideout_id int null,
    type       int null,
    constraint hideout_type_hideouts_id_fk
        foreign key (hideout_id) references hideouts (id),
    constraint hideout_type_types_hideouts_id_fk
        foreign key (type) references types_hideouts (id)
);

create table types_missions
(
    id   int auto_increment
        primary key,
    name varchar(255) null
);

create table mission_type
(
    id         int auto_increment
        primary key,
    mission_id int null,
    type_id    int null,
    constraint mission_type_missions_id_fk
        foreign key (mission_id) references missions (id),
    constraint mission_type_types_missions_id_fk
        foreign key (type_id) references types_missions (id)
);

create table users
(
    id         int auto_increment
        primary key,
    lastname   varchar(255)                       null,
    firstname  varchar(255)                       null,
    email      varchar(255)                       null,
    password   varchar(255)                       null,
    created_at datetime default CURRENT_TIMESTAMP null
);


