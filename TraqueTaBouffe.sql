/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de cr�ation :  24/10/2023 17:16:05                      */
/*==============================================================*/


/*==============================================================*/
/* Table : ALIMENTS                                             */
/*==============================================================*/
create table ALIMENTS
(
   ID_ALIMENT           int not null AUTO_INCREMENT comment '',
   INDICE_NOVA          int  comment '',
   NOM_ALIMENT          varchar(1024) not null  comment '',
   ISLIQUID             bool not null  comment '',
   primary key (ID_ALIMENT)
);

/*==============================================================*/
/* Table : ALIMENT_CONSOMME                                     */
/*==============================================================*/
create table ALIMENT_CONSOMME
(
   ID_REPAS             int not null AUTO_INCREMENT comment '',
   ID_ALIMENT_FK           int not null  comment '',
   ID_USER_FK              int not null  comment '',
   DATE                 datetime not null  comment '',
   QUANTITE             float not null  comment '',
   primary key (ID_REPAS)
);

/*==============================================================*/
/* Table : COMPOSITION                                          */
/*==============================================================*/
create table COMPOSITION
(
   ID_COMPOSANT_FK         int not null  comment '',
   ID_ALIMENT_FK           int not null  comment '',
   QUANTITE_DU_COMPOSANT float not null  comment '',
   primary key (ID_COMPOSANT_FK, ID_ALIMENT_FK)
);

/*==============================================================*/
/* Table : EST_COMPOSE                                          */
/*==============================================================*/
create table EST_COMPOSE
(
   ID_NUTRIMENT_FK         int not null  comment '',
   ID_ALIMENT_FK           int not null  comment '',
   POURCENTAGE          float not null  comment '',
   primary key (ID_NUTRIMENT_FK, ID_ALIMENT_FK)
);

/*==============================================================*/
/* Table : NUTRIMENTS                                           */
/*==============================================================*/
create table NUTRIMENTS
(
   ID_NUTRIMENT         int not null AUTO_INCREMENT comment '',
   NOM_NUTRIMENT        varchar(1024) not null  comment '',
   primary key (ID_NUTRIMENT)
);

/*==============================================================*/
/* Table : USER                                                 */
/*==============================================================*/
create table USER
(
   ID_USER              int not null AUTO_INCREMENT comment '',
   NOM                  varchar(1024) not null  comment '',
   AGE                  int not null  comment '',
   ISMALE               bool not null  comment '',
   POIDS                float not null  comment '',
   TAILLE               float not null  comment '',
   SPORT                int not null  comment '',
   PRENOM               varchar(1024)  comment '',
   primary key (ID_USER)
);

alter table ALIMENT_CONSOMME add constraint FK_ALIMENT__CONSOMME_USER foreign key (ID_USER_FK)
      references USER (ID_USER) on delete restrict on update restrict;

alter table ALIMENT_CONSOMME add constraint FK_ALIMENT__EST_ALIMENTS foreign key (ID_ALIMENT_FK)
      references ALIMENTS (ID_ALIMENT) on delete restrict on update restrict;

alter table COMPOSITION add constraint FK_COMPOSIT_COMPOSITI_ALIMENTS foreign key (ID_COMPOSANT_FK)
      references ALIMENTS (ID_ALIMENT) on delete restrict on update restrict;

alter table COMPOSITION add constraint FK2_COMPOSIT_COMPOSITI_ALIMENTS foreign key (ID_ALIMENT_FK)
      references ALIMENTS (ID_ALIMENT) on delete restrict on update restrict;

alter table EST_COMPOSE add constraint FK_EST_COMP_EST_COMPO_NUTRIMEN foreign key (ID_NUTRIMENT_FK)
      references NUTRIMENTS (ID_NUTRIMENT) on delete restrict on update restrict;

alter table EST_COMPOSE add constraint FK2_EST_COMP_EST_COMPO_ALIMENTS foreign key (ID_ALIMENT_FK)
      references ALIMENTS (ID_ALIMENT) on delete restrict on update restrict;

