-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.1              
-- * Generator date: Dec  4 2018              
-- * Generation date: Sat Nov  7 19:52:20 2020 
-- * LUN file: H:\ETML\03 - 3eme semestre\ICT133_P40_CHA_PHP_151\040-Web2\Projet\DataBaseLunProject\P_WEB2_Raclette.lun 
-- * Schema: db_web2_recipe/1 
-- ********************************************* 


-- Database Section
-- ________________ 

create database db_web2_recipe;
use db_web2_recipe;


-- Tables Section
-- _____________ 

create table t_user (
     idUser int not null auto_increment,
     usePseudo varchar(50) not null,
     useFirstname varchar(50) not null,
     useName varchar(50) not null,
     usePassword varchar(255) not null,
     useMail varchar(50) not null,
     useTelephone varchar(20) not null,
     constraint ID_t_user_ID primary key (idUser));

create table t_recipe (
     idRecipe int not null auto_increment,
     recName varchar(100) not null,
     recIngredientList varchar(255) not null,
     recDescription varchar(255) not null,
     recPrepTime float(1) not null,
     recDifficulty int not null,
     recNote int not null,
     recImage varchar(255) not null,
     idUser int not null,
     constraint ID_t_recipe_ID primary key (idRecipe));


-- Constraints Section
-- ___________________ 

alter table t_recipe add constraint FKt_own_FK
     foreign key (idUser)
     references t_user (idUser);


-- Index Section
-- _____________ 

create unique index ID_t_user_IND
     on t_user (idUser);

create unique index ID_t_recipe_IND
     on t_recipe (idRecipe);

create index FKt_own_IND
     on t_recipe (idUser);

